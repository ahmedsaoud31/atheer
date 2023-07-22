<?php

namespace Atheer\Console\Commands\Core;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Atheer\Console\Commands\Core\Make;

 
class MakeGroup extends Make
{
	
    public function __construct( public string $name)
	{
        $this->name = Str::ucfirst($name);
        parent::__construct();
	}

    public function make(): MakeGroup
    {
        foreach($this->getGroupPaths($this->name) as $dir){
            if(File::isDirectory($dir->path)){
                $this->error[] = "{$dir->prefix}: {$dir->path} already exists.";
            }
        }
        if($this->hasError()) return $this;
        foreach($this->getGroupPaths($this->name) as $dir){
            if(File::makeDirectory($dir->path, 0755, true, true)){
                $this->setInfo(prefix: $dir->prefix, alert: 'success', line: "{$dir->path} created success.");
            }else{
                $this->setInfo(prefix: $dir->prefix, alert: 'default', line: "{$dir->path} not created.");
            }
        }
        return $this->makeRoute();
    }

    private function makeRoute(): MakeGroup
    {
        $stub = File::get("{$this->stubs_path}/route-group.stub");
        $dir = "{$this->route_path}/".strtolower($this->name);
        $file = "{$dir}.php";
        File::put($file, $stub);
        $this->setInfo(prefix: 'Route', alert: 'success', line: "{$file} created success.");
        return $this->makeNavbar();
    }

    private function makeNavbar(): MakeGroup
    {
        $stub = File::get("{$this->stubs_path}/views/navbar-group.stub");
        $dir = "{$this->navbar_path}/".strtolower($this->name);
        $file = "{$dir}.blade.php";
        File::put($file, $stub);
        $this->setInfo(prefix: 'Navbar', alert: 'success', line: "{$file} created success.");
        return $this;
    }
}