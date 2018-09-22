<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class RoleCategoryValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'title' => 'required | min: 3 | max: 60',
            'description' => ''
        ],
        ValidatorInterface::RULE_UPDATE => [
            'title' => 'min: 3 | max: 60',
            'description' => ''
        ],
    ];
}
