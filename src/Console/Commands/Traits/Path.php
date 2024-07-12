<?php

namespace Atheer\Console\Commands\Traits;
 
trait Path
{
    protected string $path = '';
    protected string $base_route = '';
    protected string $stubs_path = '';
    protected string $controller_path = '';
    protected string $request_path = '';
    protected string $repository_path = '';
    protected string $policy_path = '';
    protected string $route_path = '';
    protected string $navbar_path = '';
    protected string $view_path = '';

    public function initPaths()
    {
        if(config('atheer.dev')){
            $this->path = base_path()."/vendor/ahmedsaoud31/atheer";
            $this->stubs_path = "{$this->path}/app/Atheer/Stubs";
        }else{
            $this->path = base_path();
            $this->stubs_path = "{$this->path}/app/Atheer/Stubs";
        }
        $this->controller_path = base_path()."/app/Http/Controllers/Atheer";
        $this->request_path = base_path()."/app/Http/Requests/Atheer";
        $this->repository_path = base_path()."/app/Repositories/Atheer";
        $this->policy_path = base_path()."/app/Policies";
        $this->base_route = "{$this->path}/routes";
        $this->route_path = "{$this->path}/routes/atheer";
        $this->navbar_path = "{$this->path}/resources/views/vendor/atheer/layouts/navbars/groups";
        $this->view_path = "{$this->path}/resources/views/vendor/atheer/groups";
    }

    public function getBaseRoute()
    {
        return $this->base_route;
    }
}