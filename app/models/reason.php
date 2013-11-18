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

    public static function forSelect(){
        return self::allS(['fields' => 'id as value, description as option']);
    }

}