<?php


class Payment extends Base
{

    protected $fields = array(
        'payment_type_id',
        'accommodation_id',
        'data' => ['type' => 'datetime'],
        'note',
        'price' => [
            'type' => 'float',
            'validates' => [
                'rule' => 'notEmpty',
                'message' => 'Campo Obrigatório'
            ]
        ],
        'created_at'
    );

}

?>
