<?php

namespace Atheer\Console\Commands\Core;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

use Atheer\Console\Commands\Traits\Path;
use Atheer\Console\Commands\Traits\Support;
 
class Make
{
    Use Path, Support;
    public function __construct()
    {
        $this->initPaths();
    }
}