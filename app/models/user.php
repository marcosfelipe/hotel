<?php class User extends Base {

    protected $fields = array(
        'nome',
        'login',
        'senha',
        'nivel',
        'criado_em'
    );

    public function update($data = array()) {
      $this->setData($data);
      if (!$this->isvalid()) return false;

      $db_conn = Database::getConnection();
      $params = array($this->nome, $this->login, $this->id);

      if (empty($this->senha)) {
        $sql = "update funcionarios set nome=$1, login=$2 where id = $3";
      } else {
        $params[] = sha1($this->senha);
        $sql = "update funcionarios set nome=$1, login=$2, senha=$4 where id = $3";
      }

      return pg_query_params($db_conn, $sql, $params);
    }

    public static function findById($id){
      $db_conn = Database::getConnection();
      $sql = "select * from funcionarios where id = $1;";
      $params = array($id);
      $resp = pg_query_params($db_conn, $sql, $params);

      if ($resp && $row = pg_fetch_assoc($resp)) {
        $user = new User($row);
        return $user;
      }

      return null;
    }

/*    public static function all(){
      $db_conn = Database::getConnection();
      $sql = "select * from funcionarios order by createdat desc";
      $resp = pg_query($db_conn, $sql);

      $funcionarios = array();
      while ($row = pg_fetch_assoc($resp)) {
        $funcionarios[] = new User($row);
      }

      pg_close($db_conn);
      return $funcionarios;
    }

    public function delete() {
      $db_conn = Database::getConnection();
      $params = array($this->id);
      $sql = "delete from funcionarios where id = $1";
      $resp = pg_query_params($db_conn, $sql, $params);

      pg_close($db_conn);
      return $resp;
    }
 */
} ?>
