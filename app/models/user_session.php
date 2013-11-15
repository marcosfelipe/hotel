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

        $db_conn = Database::getConnection();
        $sql = "select * from " . $this->table . " where login = $1 and senha = $2";

        $params = array($this->login->getValue(), sha1($this->senha->getValue()));
        $this->senha->setValue('');

        $resp = pg_query_params($db_conn, $sql, $params);

        if ($resp && $user = pg_fetch_assoc($resp)) {
            $_SESSION['user']['id'] = $user['id'];
            return true;
        }

        return false;
    }

    public function destroy()
    {
        unset($_SESSION['user']);
    }
}

?>
