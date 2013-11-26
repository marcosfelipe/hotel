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
        'price' => [
            'type' => 'float',
            'validates' => [
                ['rule' => 'notEmpty', 'message' => 'Campo obrigatório'],
                ['rule' => 'numeric', 'message' => 'Insira apenas números!']
            ]
        ],
        'active',
        'created_at'
    );


    public function destroy(){
        $this->setData(['active' => 'false']);
        return $this->update();
    }

    public static function forSelect(){
        return self::where('active = true',['fields' => 'id as value, number as option']);
    }

    /*seleciona as reservas do quarto onde
    * tem a maxima previsão de check-out
    */
    public function hasReservation(){
        $id = $this->id->getValue();
        $count = Reservation::where('active = true
            AND room_id = $1
            ORDER BY prevision_check_out DESC',
            ['values' => [$id] ]
        );
        return $count ? $count[0] : false;
    }

}