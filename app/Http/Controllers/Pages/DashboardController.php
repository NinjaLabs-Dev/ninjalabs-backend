<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DashboardController extends Controller
{
    public function __construct() {
        $this->middleware([
            'auth'
        ]);
    }

    public function index() {

        $files = User::findOrFail(Auth::user()->id)->images();

        return view('pages.dashboard.index')
            ->with('files', $files)
            ->with('images', Image::orderBy('created_at', 'desc')->where('owner_id', Auth::user()->id)->paginate(25))
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
