<?php

class RoomType extends Base{

    protected $fields = array(
        'title' => array(
            'validates' => [
                'rule' => 'notEmpty',
                'message' => 'Campo obrigatório!'
            ]
        ),
        'characteristics',
        'price' => [
            'type' => 'float',
            'validates' => [
                'rule' => 'numeric',
                'message' => 'Insira um valor válido!'
            ]
        ],
        'created_at'
    );

}