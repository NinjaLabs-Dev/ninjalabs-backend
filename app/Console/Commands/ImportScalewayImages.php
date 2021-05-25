<?php

namespace App\Console\Commands;

use App\Models\Domain;
use App\Models\Image;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ImportScalewayImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scaleway:import {domain}';

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
            $this->info('Importing: ' . $i . ' / ' . count($files) . ' - ' . $i * (100 / count($files)) . '%');

            $name = explode('/', $file)[1];
            $slug = explode('.', $name)[0];
            $type = Storage::mimeType($file);

            $domain = Domain::where('domain', $this->argument('domain'))->firstOrFail();
            $folder = 'user_images/' . explode('.', $domain->domain)[0];
            $directories = Storage::directories();

            if(!in_array('user_images', $directories)) {
                Storage::makeDirectory('user_images');
                $this->info('Made: user_images');
            }

            if(!in_array($folder, $directories)) {
                Storage::makeDirectory($folder);
                $this->info('Made: ' . $folder);
            }

            $newDir = $folder . '/' . explode('/', $file)[1];
            $this->info('Moving File from ' . $file . ' to ' . $newDir);
            Storage::move($file, $newDir);
            $img = new Image;
            $img->owner_id = 2;
            $img->slug = $slug;
            $img->url = Storage::url($file);
            $img->type = $type;
            $img->dir = $newDir;
            $img->save();
        }

        $this->info('Done');

        return 1;
    }
}
