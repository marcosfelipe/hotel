<?php

class User extends ApplicationModel
{

    protected $table = 'employees';

    protected $fields = array(
        'name' => [
            'validates' => [
                'rule' => 'notEmpty',
                'message' => 'Campo obrigatório!'
            ]
        ],
        'login' => [
            'validates' => [
                [
                    'rule' => 'validEmail',
                    'message' => 'Digite um e-mail válido!'
                ],
                [
                    'rule' => 'unique',
                    'message' => 'Este e-mail já está sendo
                        usado por outro usuário!'
                ]
            ]
        ],
        'password',
        'access',
        'level',
        'active',
        'created_at'
    );



}