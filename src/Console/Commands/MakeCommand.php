<?php

namespace Atheer\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

use Atheer\Console\Commands\Core\Make;
use Atheer\Console\Commands\Core\MakeGroup;
use Atheer\Console\Commands\Core\MakeCRUD;

use Illuminate\Support\Str;
 
class MakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'atheer:make
                            {name? : The ID of the user}
                            {--choice : Choice for make group|curd}';
 
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to create atheer files';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $choice = $this->choice(
            'What do you want to create?',
            ['Group', 'CRUD'],
            'CRUD'
        );
        switch($choice){
            case "Group":
                while(true){
                    $name = $this->ask("What is your group name to create?");
                    $make = new MakeGroup($name);
                    $make->make();
                    if(!$make->hasError()){
                        foreach($make->getInfo() as $line){
                            $this->line($line);
                        }
                        break;
                    }
                    foreach($make->getError() as $error){
                        $this->error($error);
                    }
                }
                break;
            case "CRUD":
                $groups = (new make)->getGroupNames();
                $group_name = $this->choice(
                    'Which group you want to create the CRUD in it?',
                    $groups,
                    $groups[0] ?? ''
                );
                while(true){
                    $models = (new make)->getModelNames();
                    $model_name = $this->choice(
                        "Which Model you want to create a CRUD for it in ({$group_name}) group?",
                        $models,
                        $models[0] ?? ''
                    );
                    $make = new MakeCRUD($model_name, $group_name);
                    if($make->modelHasColumns()){
                        while(true){
                            $make = new MakeCRUD($model_name, $group_name);
                            $make->modelHasColumns();
                            $this->question($make->getFormShema());
                            $inputs = $this->ask("Please enter form schema or press enter to use default upove schema?");
                            $make->setForm($inputs);
                            if(!$make->hasError()){
                                $make->make();
                                if(!$make->hasError()){
                                    $make->createForm();
                                    foreach($make->getInfo() as $line){
                                        $this->line($line);
                                    }
                                    break 2;
                                }
                            }
                            foreach($make->getError() as $error){
                                $this->error($error);
                            }
                            $this->newLine();
                        }
                    }else{
                        if ($this->confirm("No columns in the {$make->model->getTable()} table, Do you want to create empty CURD?")) {
                            $make->make();
                            if(!$make->hasError()){
                                foreach($make->getInfo() as $line){
                                    $this->line($line);
                                }
                                break;
                            }
                            foreach($make->getError() as $error){
                                $this->error($error);
                            }
                        }
                    }
                }
                break;
        }
    }
}