<?php


class PaymentType extends Base
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
