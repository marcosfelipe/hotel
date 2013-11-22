<?php

class ServiceType extends ApplicationModel{

    protected $fields = array(
        'description' => array(
            'validates' => [
                'rule' => 'notEmpty',
                'message' => 'Campo obrigatório!'
            ]
        ),
        'created_at'
    );

}