<?php

namespace Atheer\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

use Database\Seeders\AtheerSeeder;
 
class FreshCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'atheer:fresh';
 
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fresh Atheer';
 
	/**
	 * Execute the console command.
	 */
	public function handle(): void
	{
        if ($this->confirm("This command will backup your data before re-migrate tables, are you sure you want to process this action?")) {
            $this->question('Please be patient while we backup your data.');
            $this->backup();
        }
        $this->question('Please be patient while we seed your data again to your database.');
        $this->call('migrate:fresh', []);
        //$this->seed();
        (new AtheerSeeder)->run();
        $this->info('Fresh atheer done.');
	}

    private function backup()
    {
        if(!Storage::disk('local')->exists('atheer')){
            Storage::disk('local')->makeDirectory('atheer', 0775, true, true);
        }
        $tables = \DB::select('SHOW TABLES');
        $tables = array_map('current',$tables);
        foreach($tables as $table){
            $data = \DB::table($table)->get()->toJson();
            Storage::disk('local')->put("atheer/{$table}.json", $data);
        }
    }

    private function seed()
    {
        Schema::disableForeignKeyConstraints();
        $tables = \DB::select('SHOW TABLES');
        $tables = array_map('current',$tables);
        foreach($tables as $table){
            if(in_array($table, ['migrations'])) continue;
            $columns = Schema::getColumnListing($table);
            $records = json_decode(Storage::disk('local')->get("atheer/{$table}.json"), true);
            if($records){
                foreach ($records as $record) {
                    $filtered = Arr::only($record, $columns);
                    \DB::table($table)->insert($filtered);
                }
            }
        }
        Schema::enableForeignKeyConstraints();
    }
}