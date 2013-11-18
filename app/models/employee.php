<?php

class Employee extends Base{

    protected $fields = array(
        'name' => [
            'validates' => [
                'rule' => 'notEmpty',
                'message' => 'Campo obrigatório!'
            ]
        ],
        'login' => [
            'validates' => [
                'rule' => 'validEmail',
                'message' => 'Digite um e-mail válido!'
            ]
        ],
        'level' => [
            'validates' => [
                'rule' => 'notEmpty',
                'message' => 'Campo obrigatório!'
            ]
        ],
        'password',
        'access',
        'active',
        'created_at'
    );

    public function destroy(){
        $this->setData(['active' => 'false']);
        return $this->update();
    }

    public static function forSelect(){
        return self::allS(['fields' => 'id as value, name as option']);
    }

}