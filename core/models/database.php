<?php
  class Database {

    public static function getConnection() {
      require 'database_config.php';
      $db_con = pg_connect("host={$db_host} port={$db_port} dbname={$db_dbname} user={$db_user} password={$db_pswd}");

      if ($db_con) {
        Logger::getInstance()->log("Aberta conexão com banco de dados!", Logger::NOTICE);
        return $db_con;
      } else {
        Logger::getInstance()->log("Falha na conexão com banco de dados!", Logger::FATAL);
        die("Falha na conexão com o banco de dados");
      }
    }
  }
?>
