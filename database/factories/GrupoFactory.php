<?php

use Faker\Generator as Faker;
use App\Entities\Api\Acl\Grupo;

$factory->define(Grupo::class, function (Faker $faker) {
    return [
        'titulo' => $faker->title,
        'descricao' => $faker->text,
    ];
});
