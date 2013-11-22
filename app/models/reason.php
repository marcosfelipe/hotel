<?php

class Reason extends ApplicationModel{

    protected $fields = array(
        'description' => array(
            'validates' => array(
                'rule' => 'notEmpty',
                'message' => 'Campo obrigatório!'
            )
        )
    );

}