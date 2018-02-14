<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class ProfileValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'user_id' => 'requiered',
            'avatar',
            'first_name' => 'requiered',
            'last_name' => 'requiered',
            'ddd' => 'requiered | min: 2',
            'cell_phone' => 'requiered | min: 8 | max: 11',
            'gender' => 'requiered'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'avatar',
            'first_name',
            'last_name',
            'ddd',
            'cell_phone',
            'gender',
            'status'
        ],
    ];
}
