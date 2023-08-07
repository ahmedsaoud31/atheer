<?php

namespace App\Repositories\Atheer\Auth;

use Spatie\Permission\Models\Role as MainModel;

class RoleRepository
{
    public function model()
    {
        return new MainModel;
    }

    public function query()
    {
        return $this->model()->query();
    }

    public function create($inputs)
    {
        return $this->model()->create($inputs);
    }

    public function update($record, $inputs)
    {
        return $record->update($inputs);
    }
    
    public function byId($id)
    {
        return $this->query()->whereId($id)->first();
    }
    
    public function first($id)
    {
        return $this->query()->whereId($id)->first();
    }
    
    public function firstOrFail($id)
    {
        return $this->query()->whereId($id)->firstOrFail();
    }

    public function deleteById($id)
    {
        return $record = $this->byId($id)?$record->delete():false;
    }
}