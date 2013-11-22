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
        'password',
        'access',
        'name',
        'level',
        'active'
    );

    public function wasCreate()
    {
        if (!$this->isValid()) return false;

        $resp = Employee::where("login = $1 and ( password = $2 or password is null)",
            ['values' => [$this->login->getValue(), $this->password->getValue()]]);

        if ($resp) {
            $_SESSION['user']['id'] = $resp[0]['id'];
            //incrementa o accesso do usuario
            $user = Employee::find($resp[0]['id']);
            if ($user)
                $user->update(['access' => $user->access->getValue() + 1]);
            return $user;
        }

        return false;
    }

    public static function destroySession()
    {
        unset($_SESSION['user']);
    }
}

?>
