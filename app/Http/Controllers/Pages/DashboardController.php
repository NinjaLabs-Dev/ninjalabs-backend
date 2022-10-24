<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DashboardController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $files = Auth::user()->images();
        $images = Image::query()
            ->orderByDesc('created_at')
            ->where('owner_id', Auth::user()->id)
            ->paginate(25);

        return view('pages.dashboard.index')
            ->with('files', $files)
            ->with('images', $images)
            ->with('url', null)
            ->with('file_count', $files->count());
    }

    public function destroy($id) {
        if(is_null($id)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Missing parameters'
            ], 500);
        }

        $file = Image::findOrFail($id);
        Storage::delete($file->dir);
        $file->delete();

        return Redirect::back();
    }

    public function update(Request $request, $id, $public) {
        if(is_null($id) || is_null($public)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Missing parameters'
            ], 500);
        }

        $file = Image::findOrFail($id);
        $file->is_public = $public;
        $file->save();

        Storage::setVisibility($file->dir, $public ? 'public' : 'private');

        return Redirect::back();

    }

    public function getPrivateURL($id) {
        if(is_null($id)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Missing parameters'
            ], 500);
        }

        $file = Image::findOrFail($id);

        if(!$file->is_public) {
            if( is_null($file->private_url) || ($file->updated_at <= Carbon::now()->subRealMinutes(50))) {
                $file->private_url = Storage::temporaryUrl($file->dir, now()->addHour(1));
                $file->save();
            } else {
                return Redirect::back()->withInput(['url' => $file->private_url]);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'That image is already public'
            ], 500);
        }

        return Redirect::back();
    }
}
