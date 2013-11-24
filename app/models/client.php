<?php


class Client extends Base
{

    protected $fields = array(
        'name' => array(
            'validates' => array(
                'rule' => 'notEmpty',
                'message' => 'Campo obrigatório!'
            )
        ),
        'cpf' => array(
            'validates' => array(
                [
                    'rule' => 'notEmpty',
                    'message' => 'Campo obrigatório!'
                ],
                [
                    'rule' => 'size',
                    'interval' => [11, 11],
                    'message' => 'CPF inválido!'
                ]
            ),
            'ignore' => ['.', '-']
        ),
        'rg',
        'enterprise_id',
        'active',
        'birth' => [ 'type' => 'date', 'date_format' => 'd/m/Y',
            'validates' => [
                'rule' => 'validDate',
                'message' => 'Data inválida!
                '
            ]
        ],
        'created_at'
    );


    public function destroy(){
        $this->setData(['active' => 'false']);
        return $this->update();
    }

    public static function forSelect(){
        return self::where('active = true',['fields' => 'id as value, name as option']);
    }

}

?>
