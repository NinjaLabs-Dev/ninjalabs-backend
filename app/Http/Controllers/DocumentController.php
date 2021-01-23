<?php

namespace App\Http\Controllers;

use App\Models\ApiToken;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image as ImageManager;
use Illuminate\Support\Facades\Storage;
use Mimey\MimeTypes;
use Illuminate\Support\Facades\Cache;

class DocumentController extends Controller
{
    public function index($slug) {
        $slug = explode(".", $slug);
        $slug = $slug[0];
        $img = Image::where('slug', $slug)->first();

        if(!is_null($img)) {
            $img = $img->toArray();
            return response(Storage::get($img["dir"]))->withHeaders([
                'Content-Type' => $img["type"],
            ]);
        } else {
            return response(Storage::get('images/404.png'))->withHeaders([
                'Content-Type' => 'image/png',
            ]);
        }
    }

    public function redirectToNew($slug) {
        $slug = explode(".", $slug);
        $slug = $slug[0];
        return $slug;
    }

    public function store(Request $request) {
        if(!($request->header('token') || $request->header('id'))) {
            return response()->json([
                'status' => 403,
                'message' => 'Authentication Error'
            ]);
        } else {
            $client = ApiToken::where('id',  $request->header('id'))->where('token',  $request->header('token'))->first();

            if(is_null($client)) {
                return response()->json([
                    'status' => 403,
                    'message' => 'Authentication Error'
                ]);
            }
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

        $name = Str::random(7);
        $rawimg = ImageManager::make($request->file('image'));
        $imgType = $rawimg->mime();
        $mimes = new MimeTypes;
        $img = $rawimg->encode($mimes->getExtension($imgType), 75);

        $folders = Storage::directories();
        if(!in_array('images', $folders)) {
            Storage::makeDirectory('images');
        }

        $dir = 'images/' . $name . '.' . $mimes->getExtension($imgType);

        $res = Storage::put($dir, $img, 'public');
        $url = Storage::url($dir);

        $image = new Image();
        $image->slug = $name;
        $image->url = $url;
        $image->dir = $dir;
        $image->type = $imgType;
        $image->save();

        return env('APP_URL') . "/" . $name;
    }

    public function store(Request $request) {
//        if(!($request->header('token') || $request->header('id'))) {
//            return response()->json([
//                'status' => 403,
//                'message' => 'Authentication Error'
//            ]);
//        } else {
//            $client = ApiToken::where('id',  $request->header('id'))->where('token',  $request->header('token'))->first();
//
//            if(is_null($client)) {
//                return response()->json([
//                    'status' => 403,
//                    'message' => 'Authentication Error'
//                ]);
//            }
//        }

        $t = [];

        foreach($request->file('images') as $file) {
            $name = $file->getClientOriginalName();

            $label = explode('.', $name);
            $name = $label[0];

            $img = $file;

            $folders = Storage::directories();
            if(!in_array('images', $folders)) {
                Storage::makeDirectory('images');
            }

            $dir = 'images/' . $name . '.' . $file->getClientOriginalExtension();

            $res = Storage::putFileAs('images', $file,$name . '.' . $file->getClientOriginalExtension(), 'public');
            $url = Storage::url($dir);

            $image = new Image();
            $image->slug = $name;
            $image->url = $url;
            $image->dir = $dir;
            $image->type = $img->getClientMimeType();
            $image->save();
        }

        return "Done";

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
        $rawimg = ImageManager::make($request->file('image'));
        $imgType = $rawimg->mime();
        $mimes = new MimeTypes;
        $img = $rawimg->encode($mimes->getExtension($imgType), 75);

        $folders = Storage::directories();
        if(!in_array('images', $folders)) {
            Storage::makeDirectory('images');
        }

        $dir = 'images/' . $name . '.' . $mimes->getExtension($imgType);

        $res = Storage::put($dir, $img, 'public');
        $url = Storage::url($dir);

        $image = new Image();
        $image->slug = $name;
        $image->url = $url;
        $image->dir = $dir;
        $image->type = $imgType;
        $image->save();

        return env('APP_URL') . "/" . $name;
    }
}
