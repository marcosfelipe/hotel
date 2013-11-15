<?php


class Contact extends Base {

    protected $fields = array(
        'name' => array(
            'validates' => array(
                'rule' => 'notEmpty',
                'message' => 'Campo obrigatório!'
            )
        ),
        'email' => array(
            'validates' => array(
                'rule' => 'validEmail',
                'message' => 'Digite um e-mail válido!'
            )
        ),
        'content',
        'created_at'
    );

}
?>
