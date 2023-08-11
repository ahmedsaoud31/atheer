<?php

namespace App\Repositories;

use App\Mail\Auth\ForgotPassword;
use Mail;

use App\Models\User as MainModel;

class UserRepository
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
        return $this->query()->whereId($id)->firstOrFail();
    }

    public function byEmail($email)
    {
        return $this->query()->whereEmail($email)->firstOrFail();
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
        return $this->byId($id)?$record->delete():false;
    }

    public function sendRestPasswordEmail($user): void
    {
        Mail::to($user)
            ->locale(app()->getLocale())
            ->queue(new ForgotPassword($user));
    }
}