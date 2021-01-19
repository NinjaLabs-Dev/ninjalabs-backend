<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Interest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class InterestController extends Controller
{
    public function index() {
        return view('pages.interest.index')
            ->with('submissions', Interest::all())
            ->with('interests', Interest::paginate(50))
            ->with('submission_count', Interest::all()->count());
    }

    public function delete($id) {
        $interest = Interest::findOrFail($id);

        $interest->delete();

        return Redirect::back();
    }
}
