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
        $hostname = $request->getHost();
        $hostname = explode('.', $hostname);
        if(count($hostname) > 2) {
            unset($hostname[0]);
        }
        $domain = implode('.', $hostname);
        $slug = explode(".", $slug);
        if(isset($slug[1])) {
            return Redirect::away('/' . $slug[0]);
        }
        $slug = $slug[0];
        $domain_raw = $domain;

        if(config('app.env') !== 'production') {
            $domain = 'ninjalabs.dev';
            $domain_raw = 'ninjalabs.dev';
        }

        $domain = Domain::where('domain', $domain)->first();



        if(!$domain) {
            return $this->redirectError($domain_raw);
        }

        $user = User::where('id', $domain->user_id)->first();

        if(!$user) {
            return $this->redirectError($domain_raw);
        }

        $img = Image::with('user')->where('slug', $slug)->where('owner_id', $user->id)->first();
        $custom  = Customs::with(['user', 'image'])->where('slug', $slug)->where('user_id', $user->id)->first();

        if($img || $custom) {
            $image = [];
            if($img) {
                $image = new ImageResource($img);
            } elseif ($custom) {
                $image = new ImageResource(Image::with('user')->where('id', $custom->image->id)->where('owner_id', $user->id)->first());
            }

            return response(Storage::get($image->dir))->withHeaders([
                'Content-Type' => $image->type,
            ]);
        }

        return $this->redirectError($domain_raw);

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

    public function redirectToNew($slug) {
        $slug = explode(".", $slug);
        $slug = $slug[0];
        return Redirect::to('http://cdn.ninjalabs.dev/' . $slug);
    }

    public function store(Request $request) {
        if(!($request->header('token') || $request->header('id'))) {
            return response()->json([
                'status' => 403,
                'message' => 'Authentication Error'
            ]);
        }

        $client = ApiToken::where('id',  $request->header('id'))->first();

        if(is_null($client) && Hash::check($request->header('token'), $client->token)) {
            return response()->json([
                'status' => 403,
                'message' => 'Authentication Error'
            ]);
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
        $rawimg = ImageManager::make($request->file('image')->getRealPath());
        $imgType = $rawimg->mime();
        $mimes = new MimeTypes;
        $img = $rawimg->encode($mimes->getExtension($imgType), 75);

        $fileExt = '';
        if($request->file('image')->getMimeType() === 'image/gif') {
            $img = $request->file('image')->getContent();
            $fileExt = '.gif';
        }



        $folders = Storage::directories();

        $userDomain = Domain::where('user_id', $client->user_id)->where('default', true)->first();
        $imageDomain = $userDomain->sub . '.' . $userDomain->domain;
        $fileDir = explode('.', $userDomain->domain)[0];

        $fileDir = 'user_images/' . $fileDir;

        if(!in_array($fileDir, $folders)) {
            Storage::makeDirectory($fileDir);
        }

        $dir = $fileDir . '/' . $name . '.' . $mimes->getExtension($imgType);

        $res = Storage::put($dir, $img, [
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

        return 'https://' . $imageDomain . "/" . $name . $fileExt;
    }
}
