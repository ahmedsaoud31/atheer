<?php

namespace Atheer\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

use Database\Seeders\AtheerSeeder;
 
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

        $this->call('migrate', []);

        $this->editUserModel();
        
        (new AtheerSeeder)->run();

        $this->question('Go To:');
        $this->info(url(config('atheer.dashboard_name') ?? 'atheer'));
	}

    private function editUserModel()
    {
        $path = base_path()."/app/Models/User.php";
        $file = File::get($path);
        $file = Str::of($file);
        if(!$file->contains('use Spatie\Permission\Traits\HasRoles;')){
            $file = $file->replace("namespace App\Models;", "namespace App\Models;\n\nuse Spatie\Permission\Traits\HasRoles;\n");
        }
        if(!$file->contains('use HasRoles;')){
            $file = $file->replace("class User extends Authenticatable\n{", "class User extends Authenticatable\n{\n\tuse HasRoles;");
        }
        File::put($path, $file);
    }
}