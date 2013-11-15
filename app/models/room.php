<?php

class Room extends Base
{

    protected $fields = array(
        'room_type_id',
        'number' => [
            'validates' =>[
                ['rule' => 'notEmpty', 'message' => 'Campo obrigatório'],
                ['rule' => 'size', 'interval' => [1,4], 'message' => 'Digite um valor entre 1 e 4 caracteres!'],
                ['rule' => 'numeric', 'message' => 'Digite apenas números!']
            ]
        ],
        'floor' => [
            'validates' => [
                ['rule' => 'numeric', 'message' => 'Insira apenas números!'],
                ['rule' => 'size', 'interval' => [1,4], 'message' => 'Digite um valor entre 1 e 4 caracteres!'],
            ]
        ],
        'description',
        'created_at'
    );

}