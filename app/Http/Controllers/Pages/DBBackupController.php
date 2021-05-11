<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\DbBackup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class DBBackupController extends Controller
{
    public function __construct() {
        $this->middleware(['auth', 'can:sql backups']);
    }

    public function index() {
        return view('pages.backups.index')->with('backups', DbBackup::orderBy('created_at', 'desc')->get());
    }

    public function download($id) {
        $backup = DbBackup::findOrFail($id);

        return Redirect::away($backup->url);
    }
}
