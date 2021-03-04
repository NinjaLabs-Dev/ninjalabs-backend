<?php

namespace App\Console\Commands;

use App\Models\Image;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImportScalewayImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scaleway:import';

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

        $this->warn('Starting import');

        $files = Storage::allFiles('/images');

        foreach ($files as $i => $file) {
            $this->info('Importing: ' . $i . ' / ' . count($files));

            $name = explode('/', $file)[1];
            $type = mime_content_type($name);
            $img = new Image;
            $img->owner_id = 1;
            $img->slug = $name;
            $img->url = Storage::url($file);
            $img->type = $type;
            $img->dir = $file;
            $img->save();
        }

        $this->info('Done');

        return 1;
    }
}
