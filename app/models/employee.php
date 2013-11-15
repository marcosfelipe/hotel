<?php

class Employee extends Base{

    protected $fields = array(
        'name' => [
            'validates' => [
                'rule' => 'notEmpty',
                'message' => 'Campo obrigatório!'
            ]
        ],
        'login' => [
            'validates' => [
                'rule' => 'validEmail',
                'message' => 'Campo obrigatório!'
            ]
        ],
        'password' => [
            'validates' => [
                'rule' => 'notEmpty',
                'message' => 'Campo obrigatório!'
            ]
        ],
        'level' => [
            'validates' => [
                'rule' => 'notEmpty',
                'message' => 'Campo obrigatório!'
            ]
        ]
    );

}