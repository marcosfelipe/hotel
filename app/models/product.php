<?php

class Product extends ApplicationModel{

    protected $fields = [
        'description' => [
            'validates' => [
                'rule' => 'notEmpty',
                'message' => 'Campo obrigatório!'
            ]
        ],
        'product_type_id',
        'price' => [
            'validates' => [
                'rule' => 'notEmpty',
                'message' => 'Campo obrigatório!'
            ],
            'type' => 'float'
        ],
        'created_at'
    ];

}