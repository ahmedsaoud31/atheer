<?php

namespace Atheer\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

use Atheer\Console\Commands\Core\Make;
use Atheer\Console\Commands\Core\Delete;
use Atheer\Console\Commands\Core\MakeGroup;
use Atheer\Console\Commands\Core\MakeCRUD;

use Illuminate\Support\Str;
 
class DeleteCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'atheer:delete
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
            'What do you want to delete?',
            ['Group', 'CRUD'],
            'CRUD'
        );
        switch($choice){
            case "Group":
                while(true){
                    $groups = (new make)->getGroupNames();
                    if(empty($groups)){
                        $this->error('No groups found.');
                        break;
                    }
                    $group_name = $this->choice(
                        'Which group you want to delete?',
                        $groups,
                        $groups[0] ?? ''
                    );

                    if(in_array($group_name, ['auth'])){
                        $this->error("You can't delete {$group_name} group.");
                        continue;
                    }

                    $delete = new Delete(group_name: $group_name);
                    foreach ($delete->getFormatedGroupFiles() as $line) {
                        $this->line($line);
                        $this->newLine();
                    }
                    if ($this->confirm("Do you want to delete ({$group_name}) group and all related files above?")) {
                        $delete->deleteGroup();
                        $this->info("({$group_name}) group deleted done");
                    }else{
                       $this->info("undo deleting done."); 
                   }
                    break;
                }
                break;
            case "CRUD":
                $groups = (new make)->getGroupNames();
                if(empty($groups)){
                    $this->error('No groups found.');
                    break;
                }
                $group_name = $this->choice(
                    'Which group contain your CRUD?',
                    $groups,
                    $groups[0] ?? ''
                );
                if(in_array($group_name, ['auth'])){
                    $this->error("You can't delete any CURD in {$group_name} group.");
                    break;
                }
                while(true){
                    $delete = new Delete(group_name: $group_name);
                    $models = $delete->getGroupModels();
                    if(empty($models)){
                        $this->error("No models found.");
                        break;
                    }
                    $item_name = $this->choice(
                        "Which CRUD you want to delete in ({$group_name}) group?",
                        $models,
                        $models[0] ?? ''
                    );
                    $delete = new Delete(group_name: $group_name, item_name: $item_name);
                    $item_name = $delete->getItemUpperName();
                    foreach ($delete->getFormatedItemFiles() as $line) {
                        $this->line($line);
                        $this->newLine();
                    }
                    if ($this->confirm("Do you want to delete ({$item_name}) CURD and all related files above?")) {
                        $delete->deleteCURD();
                        $this->info("({$item_name}) CURD deleted done");
                    }else{
                        $this->info("undo deleting done.");
                    }
                    break;
                }
                break;
        }
    }
}