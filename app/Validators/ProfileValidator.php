<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class ProfileValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'user_id',
            'avatar',
            'first_name' => '',
            'last_name' => '',
            'cell_phone' => '',
            'gender' => '',
            'status'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'avatar',
            'first_name',
            'last_name',
            'cell_phone',
            'gender',
            'status'
        ],
    ];
}
