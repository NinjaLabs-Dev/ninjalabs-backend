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
        $this->middleware(['auth', 'can:mysql backups']);
    }

    public function index() {
        $backups = DbBackup::query()
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.backups.index')
            ->with('backups', $backups);
    }

    public function download($id) {
        $backup = DbBackup::findOrFail($id);

        return Redirect::away($backup->url);
    }
}
