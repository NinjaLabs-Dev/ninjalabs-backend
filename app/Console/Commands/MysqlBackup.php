<?php

namespace App\Console\Commands;

use App\Models\DbBackup;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class MysqlBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup database and save to Scaleway';

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
        $this->info("Backup started");

        $filename = "backup-" . Carbon::now()->format('d-m-Y_H-i-s') . ".sql";
        $command = "mysqldump --user=" . config("DB_USERNAME") .
            " --password=" . config("DB_PASSWORD") .
            " --host=" . config("DB_HOST") . " " .
            config("DB_DATABASE") . " > \"" . storage_path() .
            "/app/" . $filename . "\"";

        exec($command, $output, $result);

        $this->info($command);
        $this->info("Backup created");

        if(!$result) {
            $file = Storage::disk('local')->get($filename);
            Storage::put("sql_backups/" . $filename, $file, 'public');

            $backup = new DbBackup();
            $backup->url = Storage::url("sql_backups/" . $filename);
            $backup->dir = "sql_backups/" . $filename;
            $backup->save();

            Storage::disk('local')->delete($filename);

            $this->info("Backup stored");

            $oldBackups = DbBackup::where('created_at', '<=', Carbon::now()->subDays(2))->get();

            foreach($oldBackups as $b) {
                Storage::delete($b->dir);

                DbBackup::findOrFail($b->id)->delete();

                $this->info("Deleted Backup - " . $b->id . " | " . $b->dir);
            }

            $this->info("Removed out dated backups");
            $this->info("Backup complete");
        } else {
            $this->error("There was an error while backing up the database");
        };
    }
}
