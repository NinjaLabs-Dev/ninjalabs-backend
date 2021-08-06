<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SoareCostin\FileVault\Facades\FileVault;

class TestingController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index(Request $request)
    {
        return FileVault::encrypt('test/tenor.gif');
    }
}
