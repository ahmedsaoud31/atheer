<?php

namespace Atheer\Console\Commands\Core;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

use Atheer\Console\Commands\Traits\Path;
use Atheer\Console\Commands\Traits\Support;

use App\Repositories\Atheer\Auth\PermissionRepository;

class Delete extends Make
{

    public function __construct(public string $group_name = '', public string $item_name = '')
	{
        if($item_name){
            $this->model_path = $item_name;
            $item_name = explode('\\', $item_name);
            $this->name = Str::ucfirst(end($item_name));
        }
        $this->group_name = Str::ucfirst($group_name);
        parent::__construct();
	}

    public function deleteGroup(): Delete
    {
        $this->deleteGroupPermissions();
        $this->deletePolicies();
        foreach($this->getGroupPaths($this->group_name) as $dir){
            File::cleanDirectory($dir->path);
            File::deleteDirectory($dir->path);
        }
        foreach($this->getGroupFiles() as $file){
            File::delete($file);
        }
        return $this;
    }

    public function deleteCURD(): Delete
    {
        foreach($this->getItemPaths($this->group_name, $this->getItemUpperName(), $this->getItemLowerName()) as $dir){
            File::cleanDirectory($dir->path);
            File::deleteDirectory($dir->path);
        }
        foreach($this->getFormatedFiles() as $file){
            File::delete($file);
        }
        $this->deletePermissions();
        return $this;
    }

    public function getGroupFiles()
    {
        $files = [];
        foreach($this->getGroupPaths($this->group_name) as $dir){
            if(File::isDirectory($dir->path)){
                foreach(File::allFiles($dir->path) as $file){
                    $files[] = str_replace("/", DIRECTORY_SEPARATOR, $file->getPathName());
                }
            }
        }
        $files[] = str_replace("/", DIRECTORY_SEPARATOR, "{$this->route_path}/".strtolower($this->group_name).".php");
        $files[] = str_replace("/", DIRECTORY_SEPARATOR, "{$this->navbar_path}/".strtolower($this->group_name).".blade.php");
        return $files;
    }

    public function getFormatedFiles()
    {
        $files = [];
        foreach($this->getItemPaths($this->group_name, $this->getItemUpperName(), $this->getItemLowerName()) as $dir){
            if(File::isDirectory($dir->path)){
                foreach(File::allFiles($dir->path) as $file){
                    $files[] = str_replace("/", DIRECTORY_SEPARATOR, $file->getPathName());
                }
            }
        }
        $files[] = str_replace("/", DIRECTORY_SEPARATOR, "{$this->controller_path}/{$this->group_name}/{$this->getItemUpperName()}Controller.php");
        $files[] = str_replace("/", DIRECTORY_SEPARATOR, "{$this->repository_path}/{$this->group_name}/{$this->getItemUpperName()}Repository.php");
        $files[] = str_replace("/", DIRECTORY_SEPARATOR, "{$this->policy_path}/{$this->getModelNameSpace()}/{$this->getItemUpperName()}Policy.php");
        $files[] = str_replace("/", DIRECTORY_SEPARATOR, "{$this->navbar_path}/".strtolower($this->group_name)."/{$this->getItemLowerName()}.blade.php");
        $files[] = str_replace("/", DIRECTORY_SEPARATOR, "{$this->route_path}/".strtolower($this->group_name)."/{$this->getItemLowerName()}.php");
        return $files;
    }

    public function getFormatedGroupFiles()
    {
        $files = [];
        foreach ($this->getGroupFiles() as $file) {
            $files[] = $this->getFormatedLine(prefix:'File', alert:'warning', line:$file);
        }
        return $files;
    }

    public function getFormatedItemFiles()
    {
        $files = [];
        foreach ($this->getFormatedFiles() as $file) {
            $files[] = $this->getFormatedLine(prefix:'File', alert:'warning', line:$file);
        }
        return $files;
    }

    private function deletePermissions(): void
    {
        foreach($this->getPermissions() as $name){
            (new PermissionRepository)->query()->whereName("$name {$this->model->getTable()}")->delete();      
        }
    }

    private function deleteGroupPermissions(): void
    {
        foreach($this->getGroupTables($this->group_name) as $table){
            foreach($this->getPermissions() as $name){
                (new PermissionRepository)->query()->whereName("$name {$table}")->delete();      
            }
        }
    }

    private function deletePolicies(): void
    {
        foreach($this->getModelNames() as $model){
            $temp = explode('\\', $model);
            $temp = end($temp);
            if(in_array($temp, $this->getGroupModels($this->group_name))){
                $policy_file = "App\Policies\\{$model}Policy.php";
                if(File::exists($policy_file)){
                   File::delete($policy_file); 
                }
            }
        }
    }

    /*
    public function getItemUpperName()
    {
        return Str::ucfirst($this->item_name);
    }

    public function getItemLowerName()
    {
        return Str::snake(Str::plural($this->getItemUpperName($this->item_name)), '-');
    }
    */
}