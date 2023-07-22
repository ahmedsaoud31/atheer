<?php

namespace Atheer\Console\Commands\Core;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Atheer\Console\Commands\Core\Make;

 
class MakeForm extends Make
{
	public function __construct( public string $name)
	{
        $this->name = Str::ucfirst($name);
        parent::__construct();
	}

    public function make(MakeCURD $make): MakeForm
    {
        $dirs = [
            ['prefix' => 'Controller', 'path' => base_path()."/app/Http/Controllers/{$this->name}"],
            ['prefix' => 'Controller', 'path' => base_path()."/app/Http/Requests/{$this->name}"],
            ['prefix' => 'Controller', 'path' => "{$this->path}/routes/atheer/".strtolower($this->name)],
            ['prefix' => 'Controller', 'path' => "{$this->path}/resources/views/vendor/atheer/groups/".strtolower($this->name)],
            ['prefix' => 'Controller', 'path' => "{$this->path}/resources/views/vendor/atheer/layouts/navbars/groups/".strtolower($this->name)],
        ];
        foreach($dirs as $dir){
            if(File::isDirectory($dir['path'])){
                $this->error[] = "{$dir['prefix']}: {$dir['path']} already exists.";
            }
        }
        if($this->hasError()) return $this;
        foreach($dirs as $dir){
            if(File::makeDirectory($dir['path'], 0755, true, true)){
                $this->setInfo(prefix: $dir['prefix'], alert: 'success', line: "{$dir['path']} created success.");
            }else{
                $this->setInfo(prefix: $dir['prefix'], alert: 'default', line: "{$dir['path']} not created.");
            }
        }
        return $this->makeRoute();
    }
}