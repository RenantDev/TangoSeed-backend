<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class UserRGroupValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'user_id' => 'required',
            'group_id' => 'required'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'user_id' => 'required',
            'group_id' => 'required'
        ],
    ];
}
