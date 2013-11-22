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

}