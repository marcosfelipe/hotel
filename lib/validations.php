<?php class Validations
{

    public static function notEmpty($value, $key = null, &$errors = null)
    {
        if ($value == "") {
            if ($key !== null && $errors !== null) {
                $msg = 'não deve ser vazio';
                $errors[$key] = $msg;
            }
            return false;
        }
        return true;
    }

    public static function validEmail($email, $key = null, &$errors = null)
    {
        $pattern = '/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+/';

        if (preg_match($pattern, $email))
            return true;

        if ($key !== null && $errors !== null)
            $errors[$key] = 'não é válido';

        return false;
    }

    /*
     * numeric verifica se o valor é numerico
     */

    public static function numeric($value, $key = null, &$errors = null)
    {
        if (!empty($value)) {
            if ($key !== null && $errors !== null) {
                if (!is_numeric($value)) {
                    $errors[$key] = 'a';
                    return false;
                }
            }
        }
        return true;
    }

    /*
     * between passa o intervalo inteiro [ 1, 5 ]
     * intervalo equivalente = 1 a 5
     *
     */
    public static function between($value, array $interval, $key = null, &$errors = null)
    {
        if ($value != '') {
            if ($key !== null && $errors !== null) {
                if (!in_array($value, range($interval[0], $interval[1]))) {
                    $errors[$key] = 'a';
                    return false;
                }
            }
        }
        return true;
    }

    /*
     * min passa o float minimo do valor
     */
    public static function min($value, $min, $key = null, &$errors = null)
    {
        if (!empty($value)) {
            if ($key !== null && $errors !== null) {
                if ($value < $min) {
                    $errors[$key] = 'a';
                    return false;
                }
            }
        }
        return true;
    }

    /*
     * greaterNow passa data que o  minimo deve ser agora
     */
    public static function greaterNow($value, $key = null, &$errors = null)
    {
        if (!empty($value)) {
            if ($key !== null && $errors !== null) {
                $now = new Datetime(date('Y-m-d H:i:s'));
                $date = new Datetime($value);
                if ($date < $now) {
                    $errors[$key] = 'a';
                    return false;
                }
            }
        }
        return true;
    }

    /*
     * size intervalo [ 0, 5 ]
     * intervalo equivalente = palavra de 0 a 5 letras
     *
     */
    public static function size($value, array $interval, $key = null, &$errors = null)
    {
        if (!empty($value)) {
            if ($key !== null && $errors !== null) {
                if (!in_array(strlen($value), range($interval[0], $interval[1]))) {
                    $errors[$key] = 'a';
                    return false;
                }
            }
        }
        return true;
    }

    public static function unique($value, $field, $table, $id, &$errors = null)
    {
        $db_conn = Database::getConnection();
        $sql = "select {$field} from {$table} where lower({$field}) = $1 and
            cast(id as text) <> $2
         ";

        $params = array(strtolower($value), $id);
        $resp = pg_query_params($db_conn, $sql, $params);

        if ($row = pg_fetch_assoc($resp)) {
            $errors[$field] = 'já existe um cadastro com esse dado';
            pg_close($db_conn);
            return false;
        }
        pg_close($db_conn);
        return true;
    }
}

?>
