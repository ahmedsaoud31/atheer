<?php

namespace Atheer\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

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
        if ($this->confirm("This command will delete all database data, are you sure you want to process this action?")) {
            $this->call('migrate:fresh', []);
            (new AtheerSeeder)->run();
            $this->info('Fresh atheer done.');
        }
	}
}