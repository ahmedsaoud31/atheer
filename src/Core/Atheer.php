<?php

namespace Atheer\Core;

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

    public function toSelect($data, string $option_value_name = 'id', string $option_text_name = 'name', string $option_text_name2 = 'title'): array
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
            foreach ($data as $record) {
                $obj = (object)[];
                $obj->value = $record->{$option_value_name}?$record->{$option_value_name}:'';
                $obj->text = $record->{$option_text_name}?$record->{$option_text_name}:'';
                if($record->{$option_text_name2}){
                    $obj->text .= " - (" . $record->$option_text_name2 . ")";
                }
                $out[] = $obj;
            }
        }
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
}