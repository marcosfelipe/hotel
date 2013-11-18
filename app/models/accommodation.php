<?php

class Accommodation extends Base{

    protected $fields = array(
        'reservation_id',
        'check_in' => ['type' => 'datetime'],
        'check_out' => ['type' => 'datetime'],
        'created_at'
    );

    public static function activeAccommodations(){
        return self::joins(
            'INNER JOIN reservations ON reservation_id = reservations.id
             INNER JOIN clients ON client_id = clients.id
             INNER JOIN rooms ON room_id = rooms.id
             INNER JOIN employees ON employee_id = employees.id
             WHERE reservations.active = true
             AND accommodations.check_out IS NULL
             ORDER BY check_in DESC
            ',
            ['fields' =>
                'clients.name as client_name,
                rooms.number as room_number,
                employees.name as employee_name,
                clients.id as client_id,
                reservations.id as reservation_id,
                rooms.id as room_id,
                employees.id as employee_id,
                date_reserve, date_prevision,
                accommodations.id as accommodation_id,
                accommodations.check_in as check_in
                '
            ]
        );
    }

    public static function countActiveAccommodations(){
        $count = self::joins(
            'INNER JOIN reservations ON reservation_id = reservations.id
             WHERE reservations.active = true
             AND accommodations.check_out IS NULL
            '
        );
        return $count == false ? 0 : count($count);
    }

    public function hasPayment(){
        $res = Payment::where("accommodation_id = {$this->id->getValue()} ");
        return $res ? true : false;
    }

    public function services(){
        return Service::joins('
            LEFT JOIN service_types ON services.service_type_id = service_types.id
            WHERE accommodation_id = $1
        ', ['values' => [$this->id->getValue()],
            'fields' => '
                services.id as service_id,
                 service_types.id as service_type_id,
                 service_types.description as service_type_description,
                 services.note as service_note,
                 services.created_at as service_created_at
            ']);
    }

    public function productConsumptions(){
        $acc_id = $this->id->getValue();

        /* FAZER JOIN COM CONSUMO E PRODUTO
        return $consumptions = ProductConsumption::where('
            accommodation_id = $1', ['fields' => 'price, amount', 'values' => [$acc_id] ]);
        */
    }

    public function totalDebt(){

        $acc_id = $this->id->getValue();

        //contabiliza diárias com o valor da acomodação
        $daily = self::joins('
            INNER JOIN reservations ON accommodations.reservation_id = reservations.id
            INNER JOIN rooms ON reservations.room_id = rooms.id
            WHERE accommodations.id = $1 ',
            [
                'values' => [$acc_id],
                'fields' =>
                    'accommodations.check_in as check_in,
                     rooms.price as price
                    '
            ]);
        $total = 0;
        if( $daily ){
            $now = strtotime(date('Y-m-d H:i:s'));
            $check_in = strtotime($daily[0]['check_in']);
            $days = ceil(($now - $check_in) / (24*60*60));
            $total = $daily[0]['price'] * $days;
        }

        //contabiliza consumo de produtos
        $consumptions = ProductConsumption::where('
            accommodation_id = $1', ['fields' => 'price, amount', 'values' => [$acc_id] ]);

        if( $consumptions ){
            foreach( $consumptions as $consumption ){
                $total += $consumption['price'] * $consumption['amount'];
            }
        }

        return $total;
    }

    /*
     * seleciona todos as acomodações onde não tem reserva ativa
     */
    public static function roomsForSelect(){
        return Room::where(' id not in (select room_id from reservations where active = true) ',
         ['fields' => 'id as value, number as option']);
    }

}