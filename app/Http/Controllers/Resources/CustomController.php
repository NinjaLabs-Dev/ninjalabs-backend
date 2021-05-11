<?php

namespace App\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomsResource;
use App\Models\Customs;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class CustomController extends Controller
{
    public function __construct() {
        $this->middleware(['auth']);
    }

    public function index() {
        return CustomsResource::collection(Customs::where('user_id', Auth::user()->id)->get());
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
           'route_image' => 'required|exists:images,id|unique:customs,image_id',
           'uri' => 'required|unique:customs,slug',
        ]);

        if($validator->fails()) {
            return Response::json(array('error' => true, 'message' => $validator->errors()->first()), 403);
        }

        $image = Image::findOrFail($request->route_image);

        if($image->owner_id !== Auth::user()->id) {
            return Response::json(array('error' => true), 403);
        }

        $custom = new Customs;
        $custom->image_id = $request->route_image;
        $custom->user_id = Auth::user()->id;
        $custom->slug = $request->uri;
        $custom->save();

        return Response::json(array('success' => true, 'data' => $custom));
    }

    public function destroy($id) {
        $image = Customs::findOrFail($id);

        if($image->user_id === Auth::user()->id) {
            $image->delete();
            return Response::json(array('success' => true, 'data' => 'Deleted'));
        } else {
            return Response::json(array('error' => true), 403);
        }

    }
}
