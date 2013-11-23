<?php

class Employee extends ApplicationModel
{

    protected $fields = array(
        'name' => [
            'validates' => [
                'rule' => 'notEmpty',
                'message' => 'Campo obrigatório!'
            ]
        ],
        'login' => [
            'validates' => [
                [
                    'rule' => 'validEmail',
                    'message' => 'Digite um e-mail válido!'
                ],
                [
                    'rule' => 'unique',
                    'message' => 'Este e-mail já está sendo
                        usado por outro usuário!'
                ]
            ]
        ],
        'level' => [
            'validates' => [
                'rule' => 'notEmpty',
                'message' => 'Campo obrigatório!'
            ]
        ],
        'password' => [
            'empty_value' => null
        ],
        'access',
        'active',
        'created_at'
    );

    public function destroy()
    {
        $this->setData(['active' => 'false']);
        return $this->update();
    }

    public static function forSelect()
    {
        return self::allS(['fields' => 'id as value, name as option']);
    }

    public function lastReservations(){
        return Reservation::joins(' INNER JOIN clients ON reservations.client_id = clients.id
            INNER JOIN rooms ON reservations.room_id = rooms.id
            WHERE employee_id = $1
            ORDER BY reservations.created_at DESC
            LIMIT 5
        ',['fields' => 'clients.name as client_name, client_id,
            rooms.number as room_number, room_id,
            reservations.created_at as created_at,
            reservations.id as reservation_id',
            'values' => [$this->id->getValue()]
        ]);
    }

    public function countReservations(){
        $count = Reservation::where('employee_id = $1',['values' => [$this->id->getValue()]]);
        return $count ? count($count) : 0;
    }

}