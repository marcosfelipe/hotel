<?php

class ProductConsumption extends ApplicationModel
{

    protected $fields = [
        'product_id' => [
            'validates' => [
                'rule' => 'notEmpty',
                'message' => 'Campo obrigatório!'
            ]
        ],
        'accommodation_id',
        'note',
        'price' => [
            'type' => 'float',
            'validates' => [
                [
                    'rule' => 'notEmpty',
                    'message' => 'Campo obrigatório!'
                ],
                [
                    'rule' => 'numeric',
                    'message' => 'Digite um valor válido!'
                ],
                [
                    'rule' => 'min',
                    'value' => 0,
                    'message' => 'Permitido apenas valores acima de 0'
                ],
            ]
        ],
        'amount' => [
            'validates' => [
                [
                    'rule' => 'notEmpty',
                    'message' => 'Campo obrigatório!'
                ],
                [
                    'rule' => 'numeric',
                    'message' => 'Digite uma quantidade válido!'
                ],
                [
                    'rule' => 'between',
                    'interval' => [1, 1000],
                    'message' => 'Digite um valor entre 1 e 1000'
                ]
            ]
        ],
        'created_at'
    ];

    public static function last()
    {
        return self::joins(' INNER JOIN products ON products.id = product_consumptions.product_id
            INNER JOIN accommodations ON accommodations.id = product_consumptions.accommodation_id
            ORDER BY product_consumptions.created_at DESC
            LIMIT 20
        ', ['fields' =>
        'product_consumptions.id as id,
         products.description as product_description, products.id as product_id,
         accommodations.id as accommodation_id, accommodations.control as accommodation_control,
         product_consumptions.price as price, product_consumptions.amount as amount,
         product_consumptions.created_at as created_at'
        ]);
    }

    /* like para historico */
    public static function like($value)
    {
        if (!empty($value)) {
            $value = "%$value%";
            return self::joins(' INNER JOIN products ON products.id = product_consumptions.product_id
                INNER JOIN accommodations ON accommodations.id = product_consumptions.accommodation_id
                WHERE products.description LIKE $1
                    OR CAST( accommodations.control AS TEXT) LIKE $1
                ORDER BY product_consumptions.created_at DESC
            ', ['fields' =>
                'product_consumptions.id as id,
                 products.description as product_description, products.id as product_id,
                 accommodations.id as accommodation_id, accommodations.control as accommodation_control,
                 product_consumptions.price as price, product_consumptions.amount as amount,
                 product_consumptions.created_at as created_at',
                'values' => [$value]
            ]);
        }
        return false;
    }

}