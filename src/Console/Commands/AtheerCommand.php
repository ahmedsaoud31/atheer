<?php

namespace Atheer\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
 
class AtheerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'atheer:install';
 
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Atheer';
 
	/**
	 * Execute the console command.
	 */
	public function handle(): void
	{
        
        $this->question('Please be patient while we copy all Atheer files to your project');
        $this->call('vendor:publish', [
            '--provider' => 'Atheer\AtheerServiceProvider'
        ]);
        $this->call('vendor:publish', [
            '--provider' => 'Spatie\Permission\PermissionServiceProvider'
        ]);
        $this->question('Go To:');
        $this->info(url(config('atheer.dashboard_name') ?? 'atheer'));
	}
}