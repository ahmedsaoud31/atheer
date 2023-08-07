<?php

namespace Atheer\Core;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

use Atheer\Console\Commands\Core\Make;

use Atheer\Core\Language;

class Atheer
{   
    protected string $path = '';

    public function __construct()
    {
        if(config('atheer.dev')){
            $this->path = base_path()."/vendor/ahmedsaoud31/atheer";
        }else{
            $this->path = base_path();
        }
    }

    public function optionsFormat(array | object $data, string | callable $value = 'id', string | callable $text = 'name'): array
    {
        $out = [];
        if (is_array($data) && array_values($data) === $data){
            foreach ($data as $v) {
                $obj = (object)[];
                $obj->value = $v;
                $obj->text = ucfirst($v);
                $out[] = $obj;
            }
        }else{
            foreach ($data as $key=>$record) {
                $obj = (object)[];
                if(is_string($record)){
                    $obj->value = $key;
                    $obj->text = $record;
                }else{
                    if(is_callable($value)){
                        $obj->value = $value($record);
                    }else{
                        $obj->value = $record->{$value} ?? '';
                    }
                    if(is_callable($text)){
                        $obj->text = $text($record);
                    }else{
                        if($text == 'name' && !isset($record->{$text})){
                            $obj->text = $record->title ?? '';
                        }else{
                            $obj->text = $record->{$text} ?? '';
                        }
                    }
                }
                $out[] = $obj;
            }
        }
        return $out;
    }

    public function navbarGroups()
    {
        $path = "{$this->path}/resources/views/vendor/atheer/layouts/navbars/groups/*.*";
        $out = [];
        foreach(glob($path) as $file) {
            $file = basename($file);
            $file = explode('.', $file)[0];
            $out[] = $file;
        }
        return $out;
    }

    public function routeGroups()
    {
        $path = "{$this->path}/routes/atheer/*.*";
        $out = [];
        foreach(glob($path) as $file) {
            $file = basename($file);
            $file = explode('.', $file)[0];
            $out[] = $file;
        }
        return $out;
    }

    public function routeItems($file_name)
    {
        $file_name = explode('.', $file_name)[0];
        $path = "{$this->path}/routes/atheer/{$file_name}/*.*";
        $out = [];
        foreach(glob($path) as $file) {
            $file = basename($file);
            $file = explode('.', $file)[0];
            $out[] = $file;
        }
        return $out;
    }

    public function navbarItems($group_name)
    {
        $path = "{$this->path}/resources/views/vendor/atheer/layouts/navbars/groups/{$group_name}/*.*";
        $out = [];
        foreach(glob($path) as $file) {
            $file = basename($file);
            $file = explode('.', $file)[0];
            $out[] = $file;
        }
        return $out;
    }

    public function nameFromFile($path)
    {
        return explode('.', basename($path))[0];
    }

    public function url(): string
    {
        return url('/') .'/'. config('atheer.dashboard_name');
    }

    public function publicUrl(): string
    {
        return url('/atheer_public');
    }

    public function getTables(): array
    {
        $make = new make;
        $names = [];
        foreach($make->getGroupNames() as $group_name){
            $names = array_merge($names, $make->getGroupTables($group_name));
        }
        return $names;
    }

    public function getPermissions(): array
    {
        return (new make)->getPermissions();
    }

    public function isAtheerPermission($permission): bool
    {
        foreach($this->getPermissions() as $name){
            foreach($this->getTables() as $table){
                if($permission == "{$name} {$table}"){
                    return true;
                }
            }
        }
        return false;
    }

    public function languages(): array
    {
        $path = "{$this->path}/lang/*.*";
        $all_languages = (new Language)->all();;
        $languages = [];
        foreach(glob($path) as $file) {
            $name = basename($file);
            $name = explode('.', $name);
            if(isset($name[1]) && $name[1] == 'json'){
                if(isset($all_languages->{$name[0]})){
                    $temp = $all_languages->{$name[0]};
                    $temp->code = $name[0];
                    $languages[] = $temp;
                }
            }
        }
        $temp = $all_languages->en;
        $temp->code = 'en';
        $languages[] = $temp;
        return $languages;
    }

    public function languageCodes(): array
    {
        return Arr::map($this->languages(), function ($value, $key) {
                    return $value->code;
                });
    }

    public function getLocale()
    {
        $all_languages = (new Language)->all();;
        if(isset($all_languages->{app()->getLocale()})){
            $temp = $all_languages->{app()->getLocale()};
            $temp->code = app()->getLocale();
        }else{
            $temp = $all_languages->en;
            $temp->temp = 'en';
        }
        return $temp;
    }

}