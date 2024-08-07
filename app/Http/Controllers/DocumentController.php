<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomImageResource;
use App\Http\Resources\ImageResource;
use App\Models\ApiToken;
use App\Models\Customs;
use App\Models\Domain;
use App\Models\ErrorFile;
use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image as ImageManager;
use Illuminate\Support\Facades\Storage;
use Mimey\MimeTypes;
use WebPConvert\WebPConvert;

class DocumentController extends Controller
{
    public function index(Request $request, $slug) {
        // Getting hostname & domain ready to check & search
        $hostname = $request->getHost();
        $hostname = explode('.', $hostname);
        if(count($hostname) > 2) {
            unset($hostname[0]);
        }
        $domain = implode('.', $hostname);
        $domain_raw = $domain;

        // If url includes an extension, redirect to page without
        $slug = explode('.', $slug);
        if(isset($slug[1])) {
            return Redirect::away('/' . $slug[0]);
        }
        $slug = $slug[0];

        if(config('app.env') !== 'production') {
            $domain = 'ninjalabs.dev';
            $domain_raw = 'ninjalabs.dev';
        }

        $domain = Domain::query()
            ->where('domain', $domain)
            ->first();

        if(!$domain) {
            return self::redirectError($domain_raw);
        }

        $user = User::query()
            ->where('id', $domain->user_id)
            ->first();

        if(!$user) {
            return self::redirectError($domain_raw);
        }

        $img = Image::query()
            ->with('user')
            ->where('slug', $slug)
            ->where('owner_id', $user->id)
            ->first();

        $custom  = Customs::query()
            ->with(['user', 'image'])
            ->where('slug', $slug)
            ->where('user_id', $user->id)
            ->first();

        if($img || $custom) {
            $image = [];
            if($img) {
                $image = new ImageResource($img);
            } elseif ($custom) {
                $image = new ImageResource(
                    Image::query()
                        ->with('user')
                        ->where('id', $custom->image->id)
                        ->where('owner_id', $user->id)
                        ->first()
                );
            }

            if($request->header('Referer') && parse_url($request->header('Referer'))["host"] !== 'panel.ninjalabs.dev') {
                if($custom) {
                    Image::findOrFail($custom->image->id)->increment('views');
                } elseif($img) {
                    Image::findOrFail($img->id)->increment('views');
                }
            }

            return response(Storage::get($image->dir))->withHeaders([
                'Content-Type' => $image->type,
            ]);
        }

        return self::redirectError($domain_raw);

    }

    public function store(Request $request) {
        if(!($request->header('token') || $request->header('id'))) {
            return response()->json([
                'status' => 403,
                'message' => 'Authentication Error'
            ], 403);
        }

        $client = ApiToken::query()
            ->where('id',  $request->header('id'))
            ->first();

        if(is_null($client) || !Hash::check($request->header('token'), $client->token)) {
            return response()->json([
                'status' => 403,
                'message' => 'Authentication Error'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'image' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->toArray()
            ], 500);
        }

        $name = Str::random(5);
        $img = $request->file('image')->getContent();
        $imgType = $request->file('image')->getMimeType();

        $fileExt = '';
        switch($imgType) {
            case 'image/gif':
                $fileExt = '.gif';
                break;
            case 'video/mp4':
                $fileExt = '.mp4';
                break;
        }

        $userDomain = Domain::query()
            ->where('user_id', $client->user_id)
            ->where('default', true)
            ->firstOrFail();

        $imageDomain = $userDomain->sub . '.' . $userDomain->domain;
        $fileDir = explode('.', $userDomain->domain)[0];

        if(config('app.env') !== 'production') {
            $imageDomain = 'localhost:8000';
        }

        $fileDir = 'user_images/' . $fileDir;
        $dir = $fileDir . '/' . $name . '.' . $request->file('image')->extension();

        Storage::put($dir, $img, [
            'visibility' => 'public'
        ]);
        $url = Storage::url($dir);

        $image = new Image();
        $image->slug = $name;
        $image->owner_id = $client->user_id;
        $image->url = $url;
        $image->dir = $dir;
        $image->type = $imgType;
        $image->save();

        $protocol = config('app.env') !== 'production' ? 'http' : 'https';

        return $protocol . '://' . $imageDomain . "/" . $name . $fileExt;
    }

    public static function redirectError($domain) {
        $domain_check = Domain::where('domain', $domain)->first();

        if($domain_check) {
            $error_files = ErrorFile::where('domain_id', $domain_check->id)->get();

            if($error_files) {
                $error_file = $error_files->shuffle()->first();
                return response(Storage::get($error_file->dir))->withHeaders([
                    'Content-Type' => 'image/png',
                ]);
            }
        }

        return response(Storage::get('images/404.png'))->withHeaders([
            'Content-Type' => 'image/png',
        ]);
    }
}
