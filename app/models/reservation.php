<?php

class Reservation extends Base
{

    protected $fields = array(
        'reason_id',
        'client_id' => [
            'validates' => [
                'rule' => 'notEmpty',
                'message' => 'Campo obrigatório!'
            ]
        ],
        'room_id' => [
            'validates' => [
                'rule' => 'notEmpty',
                'message' => 'Campo obrigatório!'
            ]
        ],
        'employee_id' => [
            'validates' => [
                'rule' => 'notEmpty',
                'message' => 'Campo obrigatório!'
            ]
        ],
        'prevision_check_in' => [
            'type' => 'datetime',
            'validates' => [
                [
                    'rule' => 'notEmpty',
                    'message' => 'Campo obrigatório!'
                ],
                [
                    'rule' => 'validDateTime',
                    'message' => 'Data inválida!'
                ],
                [
                    'rule' => 'greaterNow',
                    'message' => 'Data inválida! Digite uma data maior que a data de agora.'
                ]
            ]
        ],
        'prevision_check_out' => [
            'type' => 'datetime',
            'validate' => [
                'rule' => 'greaterNow',
                'message' => 'Data inválida! Digite uma data maior que a data de agora.'
            ]
        ],
        'active',
        'created_at'
    );

    public static function activeReservations()
    {
        return self::joins(
            'INNER JOIN clients ON client_id = clients.id
             INNER JOIN rooms ON room_id = rooms.id
             INNER JOIN employees ON employee_id = employees.id
             LEFT JOIN reasons ON reason_id = reasons.id
             WHERE reservations.active = true
             AND reservations.id NOT IN
                (SELECT reservation_id FROM accommodations)
             ORDER BY reservations.created_at DESC
            ',
            ['fields' =>
            'clients.name as client_name,
            rooms.number as room_number,
            employees.name as employee_name,
            reasons.description as reason_description,
            clients.id as client_id,
            reservations.id as reservation_id,
            rooms.id as room_id,
            employees.id as employee_id,
            reasons.id as reason_id,
            reservations.created_at as date_reserve, prevision_check_in, prevision_check_out
            '
            ]
        );
    }

    /*like -> usado para history*/

    public static function like($value)
    {
        if (!empty($value)) {
            $value = "%$value%";

            return self::joins(
                'INNER JOIN clients ON client_id = clients.id
                 INNER JOIN rooms ON room_id = rooms.id
                 INNER JOIN employees ON employee_id = employees.id
                 LEFT JOIN reasons ON reason_id = reasons.id
                 WHERE reservations.active = false
                 AND ( clients.name LIKE $1
                    OR CAST( rooms.number AS TEXT) LIKE $1
                    OR employees.name LIKE $1
                 )
                 ORDER BY reservations.created_at DESC
                ',
                ['fields' =>
                'clients.name as client_name,
                rooms.number as room_number,
                employees.name as employee_name,
                reasons.description as reason_description,
                clients.id as client_id,
                reservations.id as reservation_id,
                rooms.id as room_id,
                employees.id as employee_id,
                reasons.id as reason_id,
                reservations.created_at as date_reserve, prevision_check_in, prevision_check_out
                ',
                    'values' => [$value]
                ]
            );
        }
        return false;
    }

    public static function countActiveReservations()
    {
        $count = self::where(
            'reservations.active = true
             AND reservations.id NOT IN
                (SELECT reservation_id FROM accommodations)
            '
        );
        return $count ? count($count) : 0;
    }

    /*
     * seleciona todos as acomodações onde não tem reserva ativa
     */
    public static function roomsForSelect()
    {
        return Room::where(' id not in
            ( select room_id from
              reservations
              INNER JOIN accommodations
              ON accommodations.reservation_id = reservations.id
              where active = true
            ) ',
            ['fields' => 'id as value, number as option']
        );
    }

}