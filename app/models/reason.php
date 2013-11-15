<?php

class Reason extends Base{

    protected $fields = array(
        'description' => array(
            'validates' => array(
                'rule' => 'notEmpty',
                'message' => 'Campo obrigatório!'
            )
        )
    );

}