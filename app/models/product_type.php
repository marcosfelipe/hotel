<?php

class ProductType extends Base{

    protected $table = 'product_types';

    protected $fields = array(
        'description' => array(
            'validates' => array(
                'rule' => 'notEmpty',
                'message' => 'Campo obrigatório!'
            )
        ),
        'created_at'
    );

}