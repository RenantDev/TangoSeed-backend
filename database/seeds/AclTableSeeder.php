<?php

use Illuminate\Database\Seeder;
use App\Repositories\AclRepository;
use App\Entities\Api\Acl\Grupo;
use App\Entities\Api\Acl\Funcao;
use App\Entities\Api\Acl\GrupoFuncao;

class AclTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->grupos();
    }

    private function grupos(){
        Grupo::create(['titulo' => 'Developer', 'descricao' => 'Grupo de desenvolvedores']); // 1
        Grupo::create(['titulo' => 'Administrador', 'descricao' => 'Grupo administrativo']); // 2
        Grupo::create(['titulo' => 'Usuário', 'descricao' => 'Grupo de usuário padrão']); // 3
    }

    private function grupoFuncoes(){

    }

    private function funcoes(){

    }
}
