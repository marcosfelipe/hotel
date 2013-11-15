<?php namespace Admin;

class Admin extends \Base {
    private $name;
    private $email;
    private $password;

    public function setName($name) {
      $this->name = $name;
    }
    public function getName() {
      return $this->name;
    }

    public function setEmail($email) {
      $this->email = $email;
    }
    public function getEmail() {
      return $this->email;
    }

    public function setPassword($password) {
      $this->password= $password;
    }

    public static function findById($id){
      $db_conn = \Database::getConnection();
      $sql = "select * from admins where id = $1;";
      $params = array($id);
      $resp = pg_query_params($db_conn, $sql, $params);

      if ($resp && $row = pg_fetch_assoc($resp)) {
        $user = new Admin($row);
        return $user;
      }

      return null;
    }
} ?>

