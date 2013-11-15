<?php

class Enterprise extends Base{

    protected $fields = array(
        'name',
        'trading_name' => [
            'validates' => [
                'rule' => 'notEmpty',
                'message' => 'Campo obrigatório!'
            ]
        ],
        'phone' => [
            'validates' => [
                [
                    'rule' => 'numeric',
                    'message' => 'Insira apenas números!'
                ],
                [
                    'rule' => 'notEmpty',
                    'message' => 'Campo Obrigatório!'
                ]
           ]
        ],
        'phone2' => [
            'validates' => [
                'rule' => 'numeric',
                'message' => 'Campo obrigatório!'
            ]
        ],
        'cnpj' => [
            'validates' => [
                'rule' => 'numeric',
                'message' => 'Campo obrigatório!'
            ]
        ],
        'address',
        'zip' => [
            'validates' => [
                'rule' => 'numeric',
                'message' => 'Campo obrigatório!'
            ]
        ],
        'state_registration',
        'email',
        'created_at'
    );

}