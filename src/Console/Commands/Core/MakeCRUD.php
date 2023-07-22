<?php

namespace Atheer\Console\Commands\Core;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Atheer\Console\Commands\Core\Make;
 
class MakeCRUD extends Make
{
	private string $model_path = '';
    private string $model_name = '';
    public $model;
    public array $model_columns = [];
    public array $model_columns_arr = [];
    public string $form = '';
    public function __construct( public string $name, public string $group_name)
	{
        $this->model_path = $name;
        $name = explode('\\', $name);
        $this->name = Str::ucfirst(end($name));
        $this->group_name = Str::ucfirst($group_name);
        parent::__construct();
	}

    public function make(): MakeCRUD
    {
        $this->validate();
        if($this->hasError()) return $this;
        $this->setTableFields();
        $this->createController();
        $this->createRequests();
        $this->createRepository();
        $this->createRoutes();
        $this->createNavbars();
        $this->createViews();
        return $this;
    }

    private function validate():void
    {
        $this->groupIsVaild()->fileExist();
    }

    private function groupIsVaild():Make
    {
        $dirs = [
            "{$this->controller_path}/{$this->group_name}",
            "{$this->request_path}/{$this->group_name}",
            "{$this->route_path}/".strtolower($this->group_name),
            "{$this->navbar_path}/".strtolower($this->group_name),
            "{$this->view_path}/".strtolower($this->group_name),
        ];
        foreach($dirs as $dir){
            if(!File::isDirectory($dir)){
                $this->error[] = $dir . " group directory not found.";
            }
        }
        return $this;
    }

    private function fileExist():Make
    {
        $files = [
            "{$this->controller_path}/{$this->group_name}/{$this->name}Controller.php",
            "{$this->request_path}/{$this->group_name}/{$this->name}/StoreRequest.php",
            "{$this->request_path}/{$this->group_name}/{$this->name}/UpdateRequest.php",
            "{$this->repository_path}{$this->getModelNameSpace()}/{$this->name}Repository.php",
            "{$this->route_path}/{$this->getGroupLowerName()}/{$this->getItemLowerName()}.php",
            "{$this->navbar_path}/{$this->getGroupLowerName()}/{$this->getItemLowerName()}.blade.php",
        ];
        foreach($this->getViewFiles() as $file){
            $files[] = $file;
        }
        foreach($files as $file){
            if(File::isFile($file)){
                $this->error[] = $file . " already exits.";
            }
        }
        return $this;
    }

    private function createController(): void
    {
        $stub = File::get("{$this->stubs_path}/Controller.stub");
        $stub = Str::of($stub)
                   ->replace('{{ groupUpperName }}', $this->group_name)
                   ->replace('{{ itemLowerName }}', $this->getItemLowerName())
                   ->replace('{{ itemUpperName }}', $this->getItemUpperName())
                   ->replace('{{ itemSingularLowerName }}', $this->getItemSingularLowerName())
                   ->replace('{{ groupLowerName }}', $this->getGroupLowerName());
        $file = "{$this->controller_path}/{$this->group_name}/{$this->name}Controller.php";
        File::put($file, $stub);
        $this->setInfo(prefix: 'Controller', alert: 'success', line: "{$file} created success.");
    }

    private function createRequests(): void
    {
        $stub = File::get("{$this->stubs_path}/StoreRequest.stub");
        $stub = Str::of($stub)
                   ->replace('{{ groupUpperName }}', $this->group_name)
                   ->replace('{{ validation }}', $this->getvValidation())
                   ->replace('{{ itemUpperName }}', $this->getItemUpperName());
        $dir = "{$this->request_path}/{$this->group_name}/{$this->name}";
        if(!File::isDirectory($dir)){
            File::makeDirectory($dir, 0755, true, true);
        }
        $file = "{$dir}/StoreRequest.php";
        File::put($file, $stub);
        $this->setInfo(prefix: 'Request', alert: 'success', line: "{$file} created success.");

        $stub = File::get("{$this->stubs_path}/UpdateRequest.stub");
        $stub = Str::of($stub)
                   ->replace('{{ groupUpperName }}', $this->group_name)
                   ->replace('{{ validation }}', $this->getvValidation())
                   ->replace('{{ itemUpperName }}', $this->getItemUpperName());
        $file = "{$dir}/UpdateRequest.php";
        File::put($file, $stub);
        $this->setInfo(prefix: 'Request', alert: 'success', line: "{$file} created success.");
    }

    private function createRepository(): void
    {
        $stub = File::get("{$this->stubs_path}/Repository.stub");
        $stub = Str::of($stub)
                   ->replace('{{ modelNameSpace }}', $this->getModelNameSpace())
                   ->replace('{{ groupUpperName }}', $this->group_name)
                   ->replace('{{ fillable }}', $this->getFillable())
                   ->replace('{{ itemUpperName }}', $this->getItemUpperName());
        $file = "{$this->repository_path}/{$this->group_name}/{$this->name}Repository.php";
        File::put($file, $stub);
        $this->setInfo(prefix: 'Repository', alert: 'success', line: "{$file} created success.");
    }

    private function createRoutes(): void
    {
        $stub = File::get("{$this->stubs_path}/route-item.stub");
        $stub = Str::of($stub)
                   ->replace('{{ groupUpperName }}', $this->group_name)
                   ->replace('{{ itemUpperName }}', $this->getItemUpperName());
        $dir = "{$this->route_path}/{$this->getGroupLowerName()}/{$this->getItemLowerName()}";
        $file = "{$dir}.php";
        File::put($file, $stub);
        $this->setInfo(prefix: 'Route', alert: 'success', line: "{$file} created success.");
    }

    private function createNavbars(): void
    {
        $stub = File::get("{$this->stubs_path}/views/navbar-item.stub");
        $stub = Str::of($stub);
        $dir = "{$this->navbar_path}/".$this->getGroupLowerName()."/".$this->getItemLowerName();
        File::put("{$dir}.blade.php", $stub);
    }
    
    private function createViews(): void
    {
        $this->createViewDirectories();
        foreach(['index', 'forms/create', 'forms/edit', 'forms/form', 'tables/main', 'tables/row'] as $name){
            $stub = File::get("{$this->stubs_path}/views/{$name}.stub");
            $stub = Str::of($stub)
                        ->replace('{{ tableHeader }}', $this->getTableHeader())
                        ->replace('{{ tableRows }}', $this->getTableRows());
            $file = "{$this->view_path}/".$this->getGroupLowerName()."/".$this->getItemLowerName()."/{$name}.blade.php";
            File::put($file, $stub);
            $this->setInfo(prefix: 'View', alert: 'success', line: "{$file} created success.");
        }
    }
   
    public function setForm($inputs): void
    {
        $this->form = '';
        if($inputs){
            foreach(explode(',', $inputs) as $value) {
                $temp = explode('=', $value);
                if(!isset($temp[0]) || !isset($temp[1])){
                    $this->error[] = "Structure error ".__LINE__;
                    return;
                }
                if(array_key_exists($temp[0], $this->model_columns)){
                    if(in_array($temp[1], ['i', 'ignore'])){
                        unset($this->model_columns[$temp[0]]);
                    }elseif(in_array($temp[1], $this->getInputs())){
                        $this->model_columns[$temp[0]] = $temp[1];
                    }
                }
            }
        }
        foreach($this->model_columns as $key => $value) {
            $stub = File::get("{$this->stubs_path}/views/inputs/{$value}.stub");
            $this->form .= Str::of($stub)
                                ->replace('{{name}}', $key)
                                ->replace('{{title}}', Str::title(Str::replace('_', ' ', $key)))
                                ->toHtmlString()."\n";

        }
    }

    public function createForm(): void
    {
        $file = "{$this->view_path}/".$this->getGroupLowerName()."/".$this->getItemLowerName()."/forms/form.blade.php";
        File::put($file, $this->form);
        $this->setInfo(prefix: 'Form', alert: 'success', line: "{$file} created success.");
    }

    private function getModelNameSpace()
    {
        $temp = explode('\\', $this->model_path);
        array_pop($temp);
        $temp = implode('\\', $temp);
        if($temp){
            $temp = '\\'.$temp;
        }
        return  Str::replaceLast('\\', '', $temp);
    }

    private function getModelName()
    {
        $temp = explode('\\', $this->model_path);
        array_pop($temp);
        $temp = implode('\\', $temp);
        return $temp;
    }

    private function getItemUpperName()
    {
        return $this->name;
    }

    private function getItemLowerName()
    {
        return Str::snake(Str::plural($this->name), '-');
    }

    private function getItemSingularLowerName()
    {
        return Str::singular($this->getItemLowerName());
    }

    private function getGroupLowerName()
    {
        return Str::lower($this->group_name);
    }

    private function createViewDirectories()
    {
        foreach($this->getViewDirectories() as $dir){
            if(!File::isDirectory($dir)){
                File::makeDirectory($dir, 0755, true, true);
            }
        }
    }

    private function getViewDirectories():array
    {
        $dirs = [];
        foreach(['forms', 'tables', 'widgets'] as $dir){
            $dirs[] = "{$this->view_path}/{$this->getGroupLowerName()}/{$this->getItemLowerName()}/{$dir}";
        }
        return $dirs;
    }

    private function getViewFiles():array
    {
        $files = [];
        foreach(['forms', 'tables', 'widgets'] as $dir){
            switch ($dir) {
                case 'forms':
                    foreach(['form', 'create', 'edit'] as $dir2){
                        $files[] = "{$this->view_path}/{$this->getGroupLowerName()}/{$this->getItemLowerName()}/{$dir}/{$dir2}.blade.php";
                    }
                    break;
                case 'tables':
                    foreach(['main', 'row'] as $dir2){
                        $files[] = "{$this->view_path}/{$this->getGroupLowerName()}/{$this->getItemLowerName()}/{$dir}/{$dir2}.blade.php";
                    }
                    break;
                case 'widgets':
                    foreach([] as $dir2){
                        $files[] = "{$this->view_path}/{$this->getGroupLowerName()}/{$this->getItemLowerName()}/{$dir}/{$dir2}.blade.php";
                    }
                    break;
                default:
                    // code...
                    break;
            }
            $files[] = "{$this->view_path}/{$this->getGroupLowerName()}/{$this->getItemLowerName()}/index.blade.php";
        }
        return $files;
    }

    public function modelHasColumns()
    {
        $this->setTableFields();
        return !empty($this->model_columns)?true:false;
    }

    private function setTableFields():void
    {
        $model_path = "App\Models\\{$this->model_path}";
        $this->model = new $model_path;
        $columns = Schema::getConnection()->getDoctrineSchemaManager()->listTableColumns($this->model->getTable());
        //$column = Schema::getConnection()->getDoctrineColumn('table_name', 'column_name');
        $this->setModelColumns($columns);
    }

    public function getModelColumns()
    {
        return $this->model_columns;
    }

    private function getInputType($type):string
    {
        $arr = [
            'toggle' => ['bit', 'tinyint', 'bool', 'boolean'],
            'text' => [
                        'smallint', 'int', 'bigint', 'decimal', 'numeric', 'float', 'real', 'decimal', 'dec',
                        'char', 'varchar','nchar', 'nvarchar'
                        ],
            'textarea' => ['text', 'ntext', 'blob', 'mediumtext', 'mediumblob', 'longtext', 'longblob'],
            'select' => ['enum', 'set'],
            'date' => ['date', 'datetime', 'timestamp', 'year', 'time']
        ];
        foreach($arr as $key=>$value){
            if(in_array($type, $value)) return $key;
        }
        return 'text';
    }

    private function setModelColumns($columns):void
    {
        $data = [];
        foreach($columns as $column){
            if(in_array($column->getName(), ['id', 'created_at', 'updated_at'])){
                continue;
            }
            $data[$column->getName()] = $this->getInputType($column->getType()->getName());
        }
        $this->model_columns = $data;
    }

    public function getFormShema():string
    {
        foreach ($this->model_columns as $key => $value) {
            $arr[] = "{$key}={$value}";
        }
        return implode(',', $arr);
    }

    private function getInputs($columns):array
    {
        return ['toggle', 'text', 'textarea', 'select', 'date'];
    }

    private function getFillable(): string
    {
        if($this->modelHasColumns()){
            $arr = [];
            foreach($this->getModelColumns() as $key=>$value){
                $arr[] = "'{$key}'";
            }
            return '[ '. implode(', ', $arr) . ' ]';
        }else{
            return "[]";
        }
    }

    private function getvValidation(): string
    {
        if($this->modelHasColumns()){
            $arr = [];
            foreach($this->getModelColumns() as $key=>$value){
                $arr[] = "'{$key}' => 'required',\n";
            }
            return "[\n". implode("\t\t\t", $arr) . "\n\t\t]";
        }else{
            return "[]";
        }
    }

    private function getTableHeader(): string
    {
        if($this->modelHasColumns()){
            $arr = [];
            foreach($this->getModelColumns() as $key=>$value){
                $title = Str::of($key)
                            ->replace('_', ' ')
                            ->title()
                            ->toHtmlString();
                $arr[] = "<th>{{ __('{$title}') }}</th>";
            }
            return implode(" ", $arr);
        }else{
            return "";
        }
    }

    private function getTableRows(): string
    {
        if($this->modelHasColumns()){
            $arr = [];
            foreach($this->getModelColumns() as $key=>$value){
                $arr[] = '<td>{{ Str::limit($record->'. $key . ', 30, "...") }}</td>';
            }
            return implode(" ", $arr);
        }else{
            return "";
        }
    }
}