<?php class UserSession extends Base
{

    protected $table = 'employees';

    protected $fields = array(
        'login' => array(
            'validates' => array(
                'rule' => 'validEmail',
                'required' => true,
                'message' => 'Digite um e-mail válido!'
            )
        ),
        'password' => array(
            'validates' => array(
                'rule' => 'notEmpty',
                'required' => true,
                'message' => 'Campo obrigatório!'
            )
        )
    );

    public function wasCreate()
    {
        if (!$this->isValid()) return false;

        $resp = self::where('login = $1 and password = $2',
            ['values' => [$this->login->getValue(),$this->password->getValue()],
             'table' => 'employees']);

        if ($resp) {
            $_SESSION['user']['id'] = $resp[0]['id'];
            return true;
        }

        return false;
    }

    public static function destroySession()
    {
        unset($_SESSION['user']);
    }
}

?>
