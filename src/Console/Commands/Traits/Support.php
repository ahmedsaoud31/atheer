<?php

namespace Atheer\Console\Commands\Traits;
 
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

use Atheer\Console\Commands\Traits\Path;

trait Support
{
    use Path;

    protected array $error = [];
    protected array $info = [];

    public function hasError()
    {
        return !empty($this->error) ? true : false;
    }

    public function getError()
    {
        return $this->error;
    }

    public function getInfo()
    {
        return $this->info;
    }

    public function getGroupNames(): array
    {
        $names = [];
        foreach(File::directories($this->view_path) as $dir){
            $name = strtolower(File::basename($dir));
            if(in_array($name, ['auth', 'settings'])){
                continue;
            }
            $names[] = $name;
        }
        return $names;
    }

    public function getGroupPaths($group_name): array
    {
        return [
            (object)['prefix' => 'Controller', 'path' => "{$this->controller_path}/{$group_name}"],
            (object)['prefix' => 'Request', 'path' => "{$this->request_path}/{$group_name}"],
            (object)['prefix' => 'Repository', 'path' => "{$this->repository_path}/{$group_name}"],
            (object)['prefix' => 'Route', 'path' => "{$this->route_path}/".strtolower($group_name)],
            (object)['prefix' => 'Navbar', 'path' => "{$this->navbar_path}/".strtolower($group_name)],
            (object)['prefix' => 'View', 'path' => "{$this->view_path}/".strtolower($group_name)],
        ];
    }

    public function getItemPaths($group_name, $item_upper_name, $item_lower_name): array
    {
        return [
            (object)['prefix' => 'Controller', 'path' => "{$this->controller_path}/{$group_name}/$item_upper_name"],
            (object)['prefix' => 'Request', 'path' => "{$this->request_path}/{$group_name}/$item_upper_name"],
            (object)['prefix' => 'Repository', 'path' => "{$this->repository_path}/{$group_name}/$item_upper_name"],
            //(object)['prefix' => 'Policy', 'path' => "{$this->policy_path}/$item_upper_name"],
            (object)['prefix' => 'Route', 'path' => "{$this->route_path}/".strtolower($group_name)."/{$item_lower_name}"],
            (object)['prefix' => 'Navbar', 'path' => "{$this->navbar_path}/".strtolower($group_name)."/{$item_lower_name}"],
            (object)['prefix' => 'View', 'path' => "{$this->view_path}/".strtolower($group_name)."/{$item_lower_name}"],
        ];
    }

    public function getModelNames(): array
    {
        $names = [];
        foreach(File::allFiles(base_path()."/app/Models") as $item){
            $temp = explode('Models\\', $item->getRealPath());
            if(isset($temp[1])){
                $temp = Str::replaceLast('.php', '', $temp[1]);
                $names[] = $temp;
            }
        }
        return $names;
    }

    public function getNotUsedModelNames($group_name): array
    {
        $names = [];
        foreach($this->getModelNames() as $name){
            $model = "App\Models\\{$name}";
            $model = new $model;
            if(in_array($model->getTable(), $this->getGroupTables($group_name)) || $model->getTable() == 'users'){
                continue;
            }
            $names[] = $name;
        }
        return $names;
    }

    public function getGroupTables($group_name): array
    {
        $group_name = Str::ucfirst($group_name);
        $names = [];
        foreach(File::allFiles(base_path()."/app/Repositories/Atheer/{$group_name}") as $item){
            $temp = explode('\\', $item->getRealPath());
            $temp = end($temp);
            $temp = Str::replaceLast('Repository.php', '', $temp);
            $names[] = (string) Str::of($temp)->lower()->plural()->toHtmlString();
        }
        return $names;
    }

    public function getGroupModels($group_name): array
    {
        $names = [];
        foreach($this->getGroupTables($group_name) as $name){
            $names[] = (string) Str::of($name)->ucfirst()->singular()->toHtmlString();
        }
        return $names;
    }

    public function getItemNames(): array
    {
        $names = [];
        $dir = "{$this->repository_path}/{$this->group_name}";
        if(File::isDirectory($dir)){
            foreach(File::allFiles($dir) as $item){
                $names[] = Str::replace('Repository.php', '', $item->getFileName());
            }
        }
        return $names;
    }

    public function getPermissions(): array
    {
        return ['view', 'add', 'edit', 'delete'];
    }

    protected function setInfo($prefix = 'Default', $alert = 'default', $line = '')
    {
        switch ($alert) {
            case 'success':
                $this->info[] = "<fg=white;bg=default>{$prefix}:</><fg=white;bg=magenta>{$line}</>";
                break;
            case 'error':
                $this->info[] = "<fg=white;bg=default>{$prefix}:</><fg=white;bg=red>{$line}</>";
                break;
            case 'warning':
                $this->info[] = "<fg=white;bg=default>{$prefix}:</><fg=white;bg=yellow>{$line}</>";
                break;
            case 'info':
                $this->info[] = "<fg=white;bg=default>{$prefix}:</><fg=white;bg=cyan>{$line}</>";
                break;
            default:
                $this->info[] = "<fg=white;bg=default>{$prefix}:</><fg=white;bg=default>{$line}</>";
                break;
        }
    }

    protected function getFormatedLine($prefix = 'Default', $alert = 'default', $line = '')
    {
        switch ($alert) {
            case 'success':
                return "<fg=white;bg=default>{$prefix}:</><fg=white;bg=magenta>{$line}</>";
                break;
            case 'error':
                return "<fg=white;bg=default>{$prefix}:</><fg=white;bg=red>{$line}</>";
                break;
            case 'warning':
                return "<fg=white;bg=default>{$prefix}:</><fg=black;bg=yellow>{$line}</>";
                break;
            case 'info':
                return "<fg=white;bg=default>{$prefix}:</><fg=white;bg=cyan>{$line}</>";
                break;
            default:
                return "<fg=white;bg=default>{$prefix}:</><fg=white;bg=default>{$line}</>";
                break;
        }
    }
}