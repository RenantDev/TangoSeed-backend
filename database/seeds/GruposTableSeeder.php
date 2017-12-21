<?php

use Illuminate\Database\Seeder;
use App\Entities\Api\Acl\Grupo;


class GruposTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Grupo::create(['titulo' => 'Developer', 'descricao' => 'Grupo de desenvolvedores']);
        Grupo::create(['titulo' => 'Administrador', 'descricao' => 'Grupo administrativo']);
        Grupo::create(['titulo' => 'Usuário', 'descricao' => 'Grupo de usuário padrão']);
    }
}
