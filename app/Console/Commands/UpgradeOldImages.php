<?php

namespace App\Console\Commands;

use App\Models\Domain;
use App\Models\Image;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class UpgradeOldImages extends Command
{
    protected $signature = 'upgrade:files {domain}';

    protected $description = 'Command description';

    public function handle()
    {
        $domain = Domain::where('domain', $this->argument('domain'))->firstOrFail();
        $files = Image::all();
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

        $this->info('Folders checked, starting');

        foreach ($files as $file) {
            if(explode('/', $file->dir)[0] !== 'images') {
                $this->info('Skipping Image: ' . $file->slug . ', already migrated');
            } else {
                $newDir = str_replace('images', $folder, $file->dir);
                $this->info('Moving File from ' . $file->dir . ' to ' . $newDir);
                Storage::move($file->dir, $newDir);
                $image = Image::findOrFail($file->id);
                $image->dir = $newDir;
                $image->url = Storage::url($newDir);
                $image->save();
                $this->info('Image Saved, Next!');
            }
        }
        $this->info('Done');
    }
}
