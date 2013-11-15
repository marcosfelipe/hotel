<?php


class Client extends Base
{

    protected $fields = array(
        'name' => array(
            'validates' => array(
                'rule' => 'notEmpty',
                'message' => 'Campo obrigatório!'
            )
        ),
        'cpf' => array(
            'validates' => array(
                [
                    'rule' => 'notEmpty',
                    'message' => 'Campo obrigatório!'
                ],
                [
                    'rule' => 'size',
                    'interval' => [11, 11],
                    'message' => 'CPF inválido!'
                ]
            ),
            'ignore' => ['.', '-']
        ),
        'rg',
        'enterprise_id',
        'active',
        'birth' => [ 'type' => 'date', 'date_format' => 'd/m/Y' ],
        'created_at'
    );

}

?>
