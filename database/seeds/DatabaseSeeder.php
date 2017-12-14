<?php

use Illuminate\Database\Seeder;
use App\Entities\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->developer();
        //$this->production();

    }

    // Gerador de informações fake para popular o banco
    private function developer()
    {
        $this->call(UsersTableSeeder::class);
        factory(User::class, 150)->create();
    }

    // Gera apenas as informações basicas para rodar o sistema
    private function production()
    {
        $this->call(UsersTableSeeder::class);
    }
}
