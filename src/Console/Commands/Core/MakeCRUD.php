<?php

namespace Atheer\Console\Commands\Core;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Atheer\Console\Commands\Core\Make;

use App\Repositories\Atheer\Auth\PermissionRepository;
 
class MakeCRUD extends Make
{
    public array $model_columns = [];
    public string $form = '';
    public function __construct( public string $name, public string $group_name)
	{
        $this->model_path = $name;
        $name = explode('\\', $name);
        $this->name = Str::ucfirst(end($name));
        $this->group_name = $this->toCamelFirst($group_name);
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
        $this->createPolicy();
        $this->createRoutes();
        $this->createNavbars();
        $this->createViews();
        $this->createPermissions();
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
            "{$this->route_path}/".$this->toSnakeDash($this->group_name),
            "{$this->navbar_path}/".$this->toSnakeDash($this->group_name),
            "{$this->view_path}/".$this->toSnakeDash($this->group_name),
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
            "{$this->policy_path}{$this->getModelNameSpace()}/{$this->name}Policy.php",
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
                   ->replace('{{ validation }}', $this->getValidation())
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
                   ->replace('{{ validation }}', $this->getValidation())
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

    private function createPolicy(): void
    {
        $stub = File::get("{$this->stubs_path}/Policy.stub");
        $stub = Str::of($stub)
                   ->replace('{{ modelNameSpace }}', $this->getModelNameSpace())
                   ->replace('{{ itemLowerName }}', $this->getItemLowerName())
                   ->replace('{{ itemUpperName }}', $this->getItemUpperName());
        $dir = "{$this->policy_path}/{$this->getModelNameSpace()}";
        if(!File::isDirectory($dir)){
            File::makeDirectory($dir, 0755, true, true);
        }
        $file = "{$dir}/{$this->name}Policy.php";
        File::put($file, $stub);
        $this->setInfo(prefix: 'Policy', alert: 'success', line: "{$file} created success.");
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
        foreach([
                    'index',
                    'forms/create', 'forms/edit', 'forms/form',
                    'modals/create', 'modals/edit',
                    'scripts/create', 'scripts/edit', 'scripts/delete',
                    'tables/main', 'tables/row'
                ] as $name){

            if(in_array($name, [
                                'modals/create', 'modals/edit', 'scripts/create',
                                'scripts/edit', 'scripts/delete', 'tables/row'
                                ]) && config('atheer.use_templates')){
                $stub = File::get("{$this->stubs_path}/views/{$name}-template.stub");
            }else{
                $stub = File::get("{$this->stubs_path}/views/{$name}.stub");
            }
            $stub = Str::of($stub)
                        ->replace('{{ tableHeader }}', $this->getTableHeader())
                        ->replace('{{ tableRows }}', $this->getTableRows());
            $file = "{$this->view_path}/".$this->getGroupLowerName()."/".$this->getItemLowerName()."/{$name}.blade.php";
            File::put($file, $stub);
            $this->setInfo(prefix: 'View', alert: 'success', line: "{$file} created success.");
        }
    }

    private function createPermissions(): void
    {
        foreach($this->getPermissions() as $name){
            (new PermissionRepository)->model()->firstOrCreate(['name' => "$name {$this->model->getTable()}"]);            
        }
    }
   
    public function setForm($inputs): void
    {
        $this->form = "@csrf\n";
        //$this->form = "<!-- Flash message here -->\n@include(\"atheer::support.templates.widgets.form-alert\")\n";
        if($inputs){
            foreach(explode(',', $inputs) as $value) {
                $temp = explode('=', $value);
                if(!isset($temp[0]) || !isset($temp[1])){
                    $this->error[] = "Structure error ".__LINE__;
                    return;
                }
                $name = $temp[0];
                $type = $temp[1];
                $index = array_search($name, $this->getModelColumnsArr());
                if(in_array($name, $this->getModelColumnsArr())){
                    if(in_array($type, ['i', 'ignore'])){
                        unset($this->model_columns[$index]);
                    }elseif(in_array($type, $this->getInputTypes())){
                        $this->model_columns[$index]->type = $type;
                    }
                }
            }
        }

        foreach($this->getModelColumns() as $item) {
            $stub = File::get("{$this->stubs_path}/views/inputs/{$item->type}.stub");
            $this->form .= Str::of($stub)
                                ->replace('{{name}}', $item->name)
                                ->replace('{{title}}', Str::title(Str::replace('_', ' ', $item->name)))
                                ->replace('{{options}}', $this->makeEnumOptions($item))
                                ->toHtmlString()."\n";

        }
    }

    public function createForm(): void
    {
        $file = "{$this->view_path}/".$this->getGroupLowerName()."/".$this->getItemLowerName()."/forms/form.blade.php";
        File::put($file, $this->form);
        $this->setInfo(prefix: 'Form', alert: 'success', line: "{$file} created success.");
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
        foreach(['forms', 'modals', 'scripts', 'tables', 'widgets'] as $dir){
            $dirs[] = "{$this->view_path}/{$this->getGroupLowerName()}/{$this->getItemLowerName()}/{$dir}";
        }
        return $dirs;
    }

    private function getViewFiles():array
    {
        $files = [];
        foreach(['forms', 'modals', 'scripts', 'tables', 'widgets'] as $dir){
            switch ($dir) {
                case 'forms':
                    foreach(['form', 'create', 'edit'] as $dir2){
                        $files[] = "{$this->view_path}/{$this->getGroupLowerName()}/{$this->getItemLowerName()}/{$dir}/{$dir2}.blade.php";
                    }
                    break;
                case 'modals':
                    foreach(['create', 'edit'] as $dir2){
                        $files[] = "{$this->view_path}/{$this->getGroupLowerName()}/{$this->getItemLowerName()}/{$dir}/{$dir2}.blade.php";
                    }
                    break;
                case 'scripts':
                    foreach(['create', 'edit', 'delete'] as $dir2){
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
        $arr = [];
        $columns = DB::select("SHOW COLUMNS FROM {$this->model->getTable()}");
        foreach($columns as $column){
            $temp = (object)[];
            $temp->name = $column->Field;
            if(in_array($temp->name, ['id', 'created_at', 'updated_at'])){
                continue;
            }
            foreach($this->getInputs() as $key=>$value){
                foreach($value as $key2 => $value2){
                    if(Str::startsWith($column->Type, $value2)){
                        $temp->db_type = $value2;
                        $temp->type = $key;
                    }
                }
            }
            if(!isset($temp->db_type) || !$temp->db_type){
                $temp->db_type = 'varchar';
            }
            if(!isset($temp->type) || !$temp->type){
                $temp->type = 'text';
            }
            if(Str::endsWith($temp->name, '_id')){
                $temp->type = 'select';
            }
            $temp->enum = [];
            if(in_array($temp->db_type, ['enum', 'set'])){
                $temp->enum = $this->getEnum($column->Type);
            }
            $arr[] = $temp;
        }
        $this->model_columns = $arr;
    }

    public function getModelColumns()
    {
        return $this->model_columns;
    }

    private function getInputs():array
    {
        return [
                'toggle' => ['bit', 'tinyint', 'bool', 'boolean'],
                'text' => [
                            'smallint', 'int', 'bigint', 'decimal', 'numeric', 'float', 'real', 'decimal', 'dec',
                            'char', 'varchar','nchar', 'nvarchar'
                            ],
                'textarea' => ['json', 'text', 'ntext', 'blob', 'mediumtext', 'mediumblob', 'longtext', 'longblob'],
                'select' => ['enum', 'set'],
                'date' => ['date', 'datetime', 'timestamp', 'year', 'time']
            ];
    }

    private function getInputTypes():array
    {
        [$keys, $values] = Arr::divide($this->getInputs());
        return $keys;
    }

    private function getEnum($type):array
    {
        preg_match_all("/'(.*?)'/", $type, $matches);
        return isset($matches[1])?$matches[1]:[];
    }

    public function getFormShema():string
    {
        foreach($this->getModelColumns() as $item) {
            $arr[] = "{$item->name}={$item->type}";
        }
        return implode(',', $arr);
    }

    private function getFillable(): string
    {
        if($this->modelHasColumns()){
            $arr = [];
            foreach($this->getModelColumns() as $item){
                $arr[] = "'{$item->name}'";
            }
            return '[ '. implode(', ', $arr) . ' ]';
        }else{
            return "[]";
        }
    }

    private function getValidation(): string
    {
        if($this->modelHasColumns()){
            $arr = [];
            foreach($this->getModelColumns() as $item){
                $arr[] = "'{$item->name}' => 'required',";
            }
            return "[\n\t\t\t". implode("\n\t\t\t", $arr) . "\n\t\t]";
        }else{
            return "[]";
        }
    }

    private function getTableHeader(): string
    {
        if($this->modelHasColumns()){
            $arr = [];
            foreach($this->getModelColumns() as $item){
                $title = Str::of($item->name)
                            ->replace('_', ' ')
                            ->title()
                            ->toHtmlString();
                $arr[] = "<th>{{ __('{$title}') }}</th>"."\n\t\t\t\t";
            }
            return implode("", $arr);
        }else{
            return "";
        }
    }

    private function getTableRows(): string
    {
        if($this->modelHasColumns()){
            $arr = [];
            foreach($this->getModelColumns() as $item){
                switch($item->type) {
                    case 'toggle':
                        $arr[] = '<td><label class="form-switch"><input class="form-check-input" type="checkbox" {{ $record->'. $item->name .'? "checked":"" }} disabled></label></td>'."\n\t";
                        break;
                    default:
                        $arr[] = '<td>{{ Str::limit($record->'. $item->name . ', 30, "...") }}</td>'."\n\t";
                        break;
                }
            }
            return implode("", $arr);
        }else{
            return "";
        }
    }

    private function makeEnumOptions($item): string
    {
        $html = 'Atheer::optionsFormat([';
        foreach($item->enum as $value){
            $html .= "'{$value}' => '". Str::of($value)->replace('_', ' ')->replace('-', ' ')->title()->toHtmlString() ."',";
        }
        $html .= '])';
        return $html;
    }


    private function getModelColumnsArr(): array
    {
        return array_column($this->getModelColumns(), 'name');
    }
}