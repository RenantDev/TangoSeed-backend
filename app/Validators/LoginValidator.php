<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class LoginValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required',
            'email' => 'required | unique:users',
            'password' => 'required'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => '',
            'email' => 'unique:users',
            'password' => ''
        ],
    ];
}
