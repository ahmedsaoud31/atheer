<?php

namespace Atheer\Facades;

use Illuminate\Support\Facades\Facade;
use Spatie\LaravelIgnition\Support\SentReports;
use Atheer\Core\Atheer as AtheerCore;

class Atheer extends Facade
{
    protected static function getFacadeAccessor()
    {
        return AtheerCore::class;
    }
}