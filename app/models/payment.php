<?php


class Payment extends Base
{

    protected $fields = array(
        'payment_type_id' => [
            'validates' => [
                'rule' => 'notEmpty',
                'message' => 'Campo Obrigatório'
            ]
        ],
        'accommodation_id',
        'note',
        'price' => [
            'type' => 'float',
            'validates' => [
                'rule' => 'notEmpty',
                'message' => 'Campo Obrigatório'
            ]
        ],
        'control',
        'created_at'
    );

    private static function rols($sql = '', $limit = false, $values = [])
    {
        return Payment::joins("INNER JOIN payment_types ON payment_types.id = payments.payment_type_id
             INNER JOIN accommodations ON accommodation_id = accommodations.id
             {$sql}
             ORDER BY payments.created_at DESC
        ", ['fields' => '
            payments.id as id, payment_type_id, accommodation_id,
            payments.created_at as created_at, payments.price as price,
            payment_types.description as type, payments.control as pay_control,
            accommodations.control as acc_control
        ', 'limit' => $limit, 'values' => $values]);
    }

    public static function last()
    {
        return self::rols('', 20);
    }

    public static function like($value)
    {
        if (!empty($value)) {
            $value = "%$value%";
            return self::rols("where cast(payments.control as text) like $1
            OR payment_types.description = $1 OR cast( accommodations.control as text) like $1
        ", 100, [$value]);
        }
        return false;
    }

}

?>
