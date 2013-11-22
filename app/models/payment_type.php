<?php


class PaymentType extends ApplicationModel
{

    protected $fields = array(
        'description' => array(
            'validates' => array(
                'rule' => 'notEmpty',
                'message' => 'Campo obrigatório!'
            )
        ),
        'note',
        'created_at'
    );


}

?>
