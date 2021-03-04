<?php

namespace App\Http\Controllers\Resources;

use App\Http\Controllers\Controller;
use App\Models\Shows;
use Illuminate\Http\Request;
use App\Http\Resources\ShowsResource;

class ShowImageController extends Controller
{
    public function __construct() {
        $this->middleware(['api', 'auth']);
    }

    public function index() {
        return response()->json(ShowsResource::collection(Shows::all()));
    }

    public function store(Request $request) {
        return $request->all();
    }
}
