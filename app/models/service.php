<?php

class Service extends ApplicationModel{

    protected $fields = [
        'accommodation_id' => [
            'validates' => [
                'rule' => 'notEmpty',
                'message' => 'Campo obrigatório!'
            ]
        ],
        'service_type_id',
        'note' => [
            'validates' => [
                'rule' => 'notEmpty',
                'message' => 'Campo obrigatório!'
            ]
        ],
        'created_at'
    ];

    public static function last(){

        return self::joins(' LEFT JOIN service_types ON service_types.id = service_type_id
            INNER JOIN accommodations ON accommodations.id = accommodation_id
            ORDER BY created_at DESC
            LIMIT 20
        ', [ 'fields' => 'services.id as id, service_types.description as service_type_description,
                service_type_id, services.created_at as created_at,
                accommodations.control as control,
                accommodation_id
                '
        ]);

    }

}