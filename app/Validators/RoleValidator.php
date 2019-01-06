<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class RoleValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [

            'category_id' => '',
            'icon' => 'max: 60',
            'title' => 'required | min: 3 | max: 60',
            'slug' => '',
            'description' => ''
        ],
        ValidatorInterface::RULE_UPDATE => [
            'category_id' => '',
            'icon' => 'max: 60',
            'title' => 'min: 3 | max: 60',
            'slug' => '',
            'description' => ''
        ],
    ];
}
