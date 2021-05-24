<?php

namespace App\Console\Commands;

use App\Models\ErrorFile;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class UpdateErrorFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:errors {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $files = Storage::files('error');

        foreach ($files as $file) {
            $fileExsists = ErrorFile::where('dir', $file)->count();

            if(!$fileExsists) {
                $eFile = new ErrorFile;
                $eFile->domain_id = $this->argument('id');
                $eFile->dir = $file;
                $eFile->url = Storage::url($file);
                $eFile->save();
                $this->info('Added new error file, ' . $file);
            }
        }
        $this->info('Syned error files');
    }
}
