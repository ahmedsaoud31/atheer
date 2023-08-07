<?php

namespace Atheer\Console\Commands\Core;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

use Atheer\Console\Commands\Traits\Path;
use Atheer\Console\Commands\Traits\Support;
 
class Make
{
    Use Path, Support;

    public $model;
    protected string $model_path = '';
    protected string $model_name = '';
    
    public function __construct()
    {
        $this->initPaths();
        $this->setModel();
    }

    protected function setModel()
    {
        if($this->model_path){
            $model_path = "App\Models\\{$this->model_path}";
            $this->model = new $model_path;
        }
    }

    public function getItemUpperName()
    {
        return $this->name;
    }

    public function getItemLowerName()
    {
        return Str::snake(Str::plural($this->name), '-');
    }

    public function getModelNameSpace()
    {
        $temp = explode('\\', $this->model_path);
        array_pop($temp);
        $temp = implode('\\', $temp);
        if($temp){
            $temp = '\\'.$temp;
        }
        return  Str::replaceLast('\\', '', $temp);
    }

    public function getModelName()
    {
        $temp = explode('\\', $this->model_path);
        array_pop($temp);
        $temp = implode('\\', $temp);
        return $temp;
    }

    public function getItemSingularLowerName()
    {
        return Str::singular($this->getItemLowerName());
    }

    public function getGroupLowerName()
    {
        return Str::lower($this->group_name);
    }

}