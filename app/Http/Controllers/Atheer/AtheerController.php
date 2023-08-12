<?php

namespace App\Http\Controllers\Atheer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AtheerController extends Controller
{
    protected $validator;

    public function __construct()
    {
        $this->validator = Validator::make([], []);
    }

    protected function addPublicError($message)
    {
        $this->validator->getMessageBag()->add('public', $message);
    }

    protected function getValidator()
    {
        return $this->validator;
    }
}
