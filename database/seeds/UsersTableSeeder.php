<?php

use Illuminate\Database\Seeder;
use App\Entities\User;
use App\Entities\UserRGroup;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Developer',
            'email' => 'developer@tangoseed.com.br',
            'password' => bcrypt('tango123'),
            'remember_token' => str_random(10),
        ]);

        UserRGroup::create([
            'user_id' => 1,
            'group_id' => 1
        ]);

    }
}