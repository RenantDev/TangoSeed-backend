<?php
/**
 * Created by PhpStorm.
 * User: Renant
 * Date: 09/07/2018
 * Time: 03:23
 */
return [
    'users' => [
        'create' => [
            'success' => 'Usuário criado com sucesso!',
            'error' => 'Não foi possível criar o novo usuário.'
        ],
        'update' => [
            'success' => 'Usuário atualizado com sucesso!',
            'error' => 'Não foi possível atualizar o usuário.'
        ],
        'delete' => [
            'success' => 'Usuário excluido com sucesso!',
            'error' => 'Não foi possível excluir o usuário.'
        ],
        'info' => [
            'error' => 'O usuário não existe.'
        ]
    ],
    'users-r-groups' => [
        'create' => [
            'success' => 'Usuário vinculado com sucesso!',
            'error' => 'Não foi possível vincular o usuário ao grupo.'
        ],
        'delete' => [
            'success' => 'Usuário removido do grupo com sucesso!',
            'error' => 'Não foi possível remover o usuário do grupo.'
        ],
        'info' => [
            'error' => 'O usuário não faz parte de um grupo.'
        ]
    ],
    'groups' => [
        'create' => [
            'success' => 'Grupo criado com sucesso!',
            'error' => 'Não foi possível criar o novo grupo.'
        ],
        'update' => [
            'success' => 'Grupo atualizado com sucesso!',
            'error' => 'Não foi possível atualizar o Grupo.'
        ],
        'delete' => [
            'success' => 'Grupo excluido com sucesso!',
            'error' => 'Não foi possível excluir o Grupo.'
        ],
        'info' => [
            'error' => 'O grupo não existe.'
        ]
    ],
    'group-r-roles' => [
        'create' => [
            'success' => 'Função vinculada com sucesso!',
            'error' => 'Não foi possível vincular a função ao grupo.'
        ],
        'delete' => [
            'success' => 'Função removida do grupo com sucesso!',
            'error' => 'Não foi possível remover a função do grupo.'
        ],
        'info' => [
            'error' => 'Nenhuma função foi definida para este grupo.'
        ]
    ],
    'roles' => [
        'create' => [
            'success' => 'Função criada com sucesso!'
        ],
        'update' => [
            'success' => 'Função atualizada com sucesso!'
        ],
        'delete' => [
            'success' => 'Função excluida com sucesso!',
            'error' => 'Não foi possível excluir a Função.'
        ],
        'info' => [
            'error' => 'Esta função não existe.'
        ]
    ],
    'role-r-scopes' => [
        'create' => [
            'success' => 'Extenção vinculada com sucesso!',
            'error' => 'Não foi possível vincular a extenção na função.'
        ],
        'delete' => [
            'success' => 'Extenção removida da função com sucesso!',
            'error' => 'Não foi possível remover a extenção da função.'
        ],
        'info' => [
            'error' => 'Nenhuma extenção foi definida para este grupo.'
        ]
    ],
    'scopes' => [
        'create' => [
            'success' => 'Extenção criada com sucesso!'
        ],
        'update' => [
            'success' => 'Extenção atualizada com sucesso!'
        ],
        'delete' => [
            'success' => 'Extenção excluida com sucesso!',
            'error' => 'Não foi possível excluir a Extenção.'
        ],
        'info' => [
            'error' => 'Esta extenção não existe.'
        ]
    ],
];