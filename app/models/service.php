<?php

class Service extends Base{

    protected $fields = [
        'accommodation_id' => [
            'validates' => [
                'rule' => 'notEmpty',
                'message' => 'Campo obrigatório!'
            ]
        ],
        'service_type_id',
        'note',
        'created_at'
    ];

}