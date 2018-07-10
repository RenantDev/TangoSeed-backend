<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class ScopeValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'tag' => 'required | min: 3 | max: 60',
            'title' => 'required | min: 3 | max: 60',
            'description' => ''
        ],
        ValidatorInterface::RULE_UPDATE => [
            'tag' => 'min: 3 | max: 60',
            'title' => 'min: 3 | max: 60',
            'description' => ''
        ],
    ];
}
