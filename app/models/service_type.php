<?php

class ServiceType extends Base{

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