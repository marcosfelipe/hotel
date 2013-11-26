<?php

class Accommodation extends Base
{

    protected $fields = array(
        'reservation_id',
        'check_in' => ['type' => 'datetime'],
        'check_out' => ['type' => 'datetime'],
        'control',
        'created_at'
    );

    public static function activeAccommodations()
    {
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
            reservations.created_at as date_reserve, prevision_check_in, prevision_check_out,
            accommodations.id as accommodation_id,
            accommodations.check_in as check_in,
            accommodations.control as control
            '
            ]
        );
    }

    public static function countActiveAccommodations()
    {
        $count = self::joins(
            'INNER JOIN reservations ON reservation_id = reservations.id
             WHERE reservations.active = true
             AND accommodations.check_out IS NULL
            '
        );
        return $count == false ? 0 : count($count);
    }

    public function hasPayment()
    {
        $res = Payment::where("accommodation_id = {$this->id->getValue()} ");
        return $res ? true : false;
    }

    public function services()
    {
        return Service::joins('
            LEFT JOIN service_types ON services.service_type_id = service_types.id
            WHERE accommodation_id = $1
            ORDER BY services.created_at DESC
        ', ['values' => [$this->id->getValue()],
            'fields' => '
                services.id as service_id,
                 service_types.id as service_type_id,
                 service_types.description as service_type_description,
                 services.note as service_note,
                 services.created_at as service_created_at
            ']);
    }

    public function productConsumptions()
    {
        $acc_id = $this->id->getValue();
        return ProductConsumption::joins('
            INNER JOIN products ON products.id = product_consumptions.product_id
            WHERE accommodation_id = $1
            ORDER BY product_consumptions.created_at DESC',
            ['fields' => 'product_id, note, product_consumptions.price as price,
                amount, product_consumptions.created_at as date,
                products.description as description,
                product_consumptions.id as id
            ',
                'values' => [$acc_id]]);
    }

    public function payments()
    {
        $acc_id = $this->id->getValue();
        return Payment::joins('
            INNER JOIN payment_types ON payment_types.id = payments.payment_type_id
            WHERE accommodation_id = $1
            ORDER BY payments.created_at DESC',
            ['fields' => '
                payments.id as id,
                payments.control as control,
                payment_types.description as description,
                payments.created_at as created_at,
                payments.price as price
            ',
                'values' => [$acc_id]]);
    }

    public function totalDebt()
    {

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

        $total = ['days' => 0, 'daily' => 0,
            'total' => 0, 'products' => 0,
            'payments' => 0, 'subtotal' => 0
        ];

        if ($daily) {
            $now = strtotime(date('Y-m-d H:i:s'));
            $check_in = strtotime($daily[0]['check_in']);
            $days = ceil(($now - $check_in) / (24 * 60 * 60));
            $total['total'] = $daily[0]['price'] * $days;
            $total['days'] = $days;
        }

        //contabiliza consumo de produtos
        $consumptions = ProductConsumption::where('
            accommodation_id = $1', ['fields' => 'price, amount', 'values' => [$acc_id]]);

        if ($consumptions) {
            foreach ($consumptions as $consumption) {
                $consum = $consumption['price'] * $consumption['amount'];
                $total['total'] += $consum;
                $total['products'] += $consum;
            }
        }

        $total['subtotal'] = $total['total'];
        //contabiliza pagamentos
        $payments = $this->payments();
        if( $payments ){
            foreach($payments as $payment){
                $price = $payment['price'];
                $total['payments'] += $price;
                $total['total'] -= $price;
            }
        }

        return $total;
    }

    /*
     * seleciona todos as acomodações onde não tem reserva ativa
     */
    public static function roomsForSelect()
    {
        return Room::where(' id not in (select room_id from reservations where active = true) ',
            ['fields' => 'id as value, number as option']);
    }

    /* like para historico */
    public static function like($value, $date1, $date2)
    {

        if (!empty($date1) && !empty($date2)) {
            $value = "%$value%";
            $date1 = DateTime::createFromFormat('d/m/Y',$date1)->format('Y-m-d');
            $date2 = DateTime::createFromFormat('d/m/Y',$date2)->format('Y-m-d');
            return self::joins(
                'INNER JOIN reservations ON reservation_id = reservations.id
                 INNER JOIN clients ON client_id = clients.id
                 INNER JOIN rooms ON room_id = rooms.id
                 INNER JOIN employees ON employee_id = employees.id
                 WHERE reservations.active = false
                 AND accommodations.check_out IS NOT NULL
                 AND
                 ( CAST( accommodations.control AS TEXT) LIKE $1 OR CAST(rooms.number AS TEXT) LIKE $1
                    OR clients.name LIKE $1 ) AND
                    accommodations.check_out BETWEEN $2 AND $3
                 ORDER BY check_out DESC
                ',
                ['fields' =>
                'clients.name as client_name,
                rooms.number as room_number,
                employees.name as employee_name,
                clients.id as client_id,
                reservations.id as reservation_id,
                rooms.id as room_id,
                employees.id as employee_id,
                reservations.created_at as date_reserve, prevision_check_in, prevision_check_out,
                accommodations.id as accommodation_id,
                accommodations.check_in as check_in,
                accommodations.check_out as check_out,
                accommodations.control as control
                ', 'values' => [$value, $date1, $date2]]
            );
        }
        return false;
    }

    //verifica se há ocupação da acomodação

    public function hasCheckIn(){
        $reservation = Reservation::find($this->reservation_id->getValue());
        if( $reservation ){
            $room = $reservation->room_id->getValue();
            $count = self::joins('
                INNER JOIN reservations ON reservations.id = accommodations.reservation_id
                WHERE reservations.active = true AND reservations.room_id = $1
                ',['values' => [$room]]);
            return $count ? true : false;
        }
        return false;
    }

}