<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\ApiToken;
use App\Models\Image;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Testing\MimeType;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function __construct() {
        $this->middleware([
            'auth'
        ]);
    }

    public function index() {

        $files = Image::all();

//        $diskUseage = Cache::remember('disk-space', 3600, function() {
//            $space = 0;
//            foreach (Storage::all() as $f) {
//                $space += Storage::size($f);
//            }
//
//            return self::formatBytes($space);
//        });


        return view('pages.dashboard.index')
            ->with('files', $files)
//            ->with('storage', $diskUseage)
            ->with('images', Image::paginate(50))
            ->with('url', null)
            ->with('file_count', $files->count());
    }

    public function temp() {
        return view('pages.temp');
    }


    private function formatBytes($bytes, $precision = 2) {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    public function destroy(\Illuminate\Support\Facades\Request $request, $id) {
        if(is_null($id)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Missing parameters'
            ], 500);
        }

        $file = Image::find($id);

        Storage::delete($file->dir);

        $file->delete();

        return Redirect::back();

    }

    public function update(\Illuminate\Http\Request $request, $id, $public) {
        if(is_null($id) || is_null($public)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Missing parameters'
            ], 500);
        }

        $file = Image::find($id);
        $file->is_public = $public;
        $file->save();

        if($public) {
            Storage::setVisibility($file->dir, 'public');
        } else {
            Storage::setVisibility($file->dir, 'private');
        }

        return Redirect::back();

    }

    public function getPrivateURL($id) {
        if(is_null($id)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Missing parameters'
            ], 500);
        }

        $file = Image::find($id);

        if(!$file->is_public) {
            if(($file->updated_at <= Carbon::now()->subRealMinutes(50)) || is_null($file->private_url)) {
                $file->private_url = Storage::temporaryUrl($file->dir, now()->addHour(1));
                $file->save();
            } else {
                return Redirect::back()->withInput(['url' => $file->private_url]);
            }
        } else {
            return "That is public, dummy!";
        }

        return Redirect::back();
    }
}
