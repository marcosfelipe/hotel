<?php

abstract class Base
{

    protected $table = '';
    protected $fields = array();
    protected $errors = array();
    protected $primary_key;

    public $id;
    public $created_at;

    /*
     * __construct cria cada campo
     * da tabela (this.table) pelo atributo this.fields
     * colocando no model dinamicamente com
     * o tipo Field
     */

    public function __construct($data = array())
    {
        if (empty($this->primary_key))
            $this->primary_key = 'id';

        if (empty($this->table))
            $this->table = self::parseTableName(get_called_class());

        $this->makeAttributes();
        $this->setData($data);
    }

    /*
     * makeAtributes transforma o array de fields em
     * atributos do objeto
     *
     */

    private function makeAttributes(){

        foreach ($this->fields as $key => $field) {

            $key = strtolower($key);

            if (is_array($field)) {
                $this->{$key} = new Field($key);
                if (isset($field['validates'])) {

                    $validates = $field['validates'];
                    //correção para forçar um array de validades
                    if (!isset($validates[0])) {
                        $validates = [$validates];
                    }

                    foreach ($validates as $key1 => $validate) {
                        if (isset($validate['require'])) {
                            $this->{$key}->setRequired((bool)$validate['require']);
                            break;
                        }
                    }
                }
                if (isset($field['type'])) {
                    $this->{$key}->setType($field['type']);
                }
                if( isset($field['ignore']) ){
                    $this->{$key}->setIgnore($field['ignore']);
                }
                if( isset($field['date_format']) ){
                    $this->{$key}->setDateFormat($field['date_format']);
                }
                if( isset($field['empty_value']) ){
                    $this->{$key}->setEmptyValue($field['empty_value']);
                }
            } else {
                $this->{strtolower($field)} = new Field(strtolower($field));
            }
        }

        $this->created_at = new Field('created_at', date('Y-m-d H:i:s'));
        $this->created_at->setValue(date('Y-m-d H:i:s'));
        $this->id = new Field('id');

    }

    /**
     * Validates verifica e cria erro para cada campo
     * da tabela (this.table) pelos atributos this.fields
     * colocados no model dinamicamente
     *
     */

    public function validates()
    {

        foreach ($this->fields as $key => $field) {
            if (is_array($field)) {
                if (isset($field['validates'])) {

                    $validates = $field['validates'];
                    //correção para forçar um array de validades
                    if (!isset($validates[0])) {
                        $validates = [$validates];
                    }

                    foreach ($validates as $validate) {
                        switch ($validate['rule']) {
                            case 'notEmpty' :
                                if (!Validations::notEmpty($this->{$key}->getValue(), $key, $this->errors)) {
                                    $this->{$key}->setFlagError('error');
                                    $this->{$key}->setError($validate['message']);
                                }
                                break;
                            case 'validEmail' :
                                if (!Validations::validEmail($this->{$key}->getValue(), $key, $this->errors)) {
                                    $this->{$key}->setFlagError('error');
                                    $this->{$key}->setError($validate['message']);
                                }
                                break;
                            case 'numeric' :
                                if (!Validations::numeric($this->{$key}->getValue(), $key, $this->errors)) {
                                    $this->{$key}->setFlagError('error');
                                    $this->{$key}->setError($validate['message']);
                                }
                                break;
                            case 'between' :
                                if (!Validations::between($this->{$key}->getValue(), $validate['interval'], $key, $this->errors)) {
                                    $this->{$key}->setFlagError('error');
                                    $this->{$key}->setError($validate['message']);
                                }
                                break;
                            case 'size' :
                                if (!Validations::size($this->{$key}->getValue(), $validate['interval'], $key, $this->errors)) {
                                    $this->{$key}->setFlagError('error');
                                    $this->{$key}->setError($validate['message']);
                                }
                                break;
                            case 'min' :
                                if (!Validations::min($this->{$key}->getValue(), $validate['value'], $key, $this->errors)) {
                                    $this->{$key}->setFlagError('error');
                                    $this->{$key}->setError($validate['message']);
                                }
                                break;
                            case 'unique' :
                                if (!Validations::unique($this->{$key}->getValue(), $key, $this->table, $this->id->getValue(), $this->errors)) {
                                    $this->{$key}->setFlagError('error');
                                    $this->{$key}->setError($validate['message']);
                                }
                                break;
                        }
                    }
                }
            }
        }
    }

    public function errors($index = null)
    {
        if ($index == null)
            return $this->errors;

        if (isset($this->errors[$index]))
            return $this->errors[$index];

        return false;
    }

    public function isValid()
    {
        $this->errors = array();
        $this->validates();
        return empty($this->errors);
    }

    public function newRecord()
    {
        return empty($this->id);
    }

    public function changedFieldValue($field, $table)
    {
        $db_conn = Database::getConnection();
        $sql = "select {$field} from {$table} where id = $1";
        $resp = pg_query_params($db_conn, $sql, array($this->id));

        $method = "get" . $field;
        $email_db = pg_fetch_assoc($resp)[$field];
        Logger::getInstance()->log("Mudou: {$this->$method()}", Logger::NOTICE);
        pg_close($db_conn);
        return $email_db !== $this->$method();
    }

    private function snakToCamelCase($value)
    {
        return preg_replace('/_/', '', $value);
    }

    public function setData($data = array())
    {
        foreach ($data as $key => $value) {
            $this->{$key}->setValue(strip_tags(trim($value)));
        }
    }

    /*
     *  parseFieldValue pega os campos do array this.fields
     *  e parse para array como chave => campo, valor => valor do campo
     *  segundo o formulario
     *
     */

    private function parseFieldsValues()
    {
        $fields = array();
        foreach ($this->fields as $key => $field) {
            if (is_array($field)) {
                $fields[$key] = $this->{$key}->getValue();
            } else {
                $fields[$field] = $this->{$field}->getValue();
            }
        }
        return $fields;
    }

    /*
     * save faz insert basico
     *
     */

    public function save()
    {

        if (!$this->isvalid()) return false;

        $fields_values = $this->parseFieldsValues();
        $fields = array();
        $values = array();

        //separando (field1,field2) values (v1, v2)
        foreach ($fields_values as $key => $value) {
            /**
             * exceto a primary key para inserção
             * convenção primary key com auto increment
             */
            if ($this->primary_key != $key) {
                $fields[] = $key;
                $values[] = $value == '' ? null : $value;
            }
        }


        /// colocando parametros ? ? ?
        $sifras = [];
        for ($i = 1; $i <= count($values); $i++) {
            $sifras [] = "$" . $i;
        }

        $sql = "insert into {$this->table}
            (" . implode(',', $fields) . ") values (" . implode(',', $sifras) . ')';

        $db_conn = Database::getConnection();

        return pg_query_params($db_conn, $sql, $values);

    }

    public function update($param = false)
    {
        if (!$this->isvalid()) return false;

        $fields_values = $param ? $param : $this->parseFieldsValues();

        $data = $values = [];
        $i = 1;
        //separando (field1,field2) values (v1, v2)
        foreach ($fields_values as $key => $value) {
            $data[] = "{$key}=$$i";
            $values[] = empty($value) ? null : $value;
            $i++;
        }

        $sql = "update {$this->table} set
            " . implode(',', $data) . " where id = '{$this->id->getValue()}'";

        $db_conn = Database::getConnection();
        $resp = @pg_query_params($db_conn, $sql, $values);

        return true;
    }

    private static function parseTableName($table)
    {
        return strtolower(Router::camelToSnake($table) . 's');
    }

    public static function allS($params = array())
    {
        $params = array_merge(
            array(
                'order' => null,
                'limit' => 0,
                'table' => null,
                'fields' => '*'
            ),
            $params
        );

        if ($params['table'] === null)
            $params['table'] = self::parseTableName(get_called_class());

        $sql = "select {$params['fields']} from {$params['table']} " .
            ($params['limit'] > 0 ? ' limit ' . $params['limit'] : '').
            ($params['order'] != null ? ' order by ' . $params['order'] : '');
        $db_conn = Database::getConnection();
        $query = @pg_query($db_conn, $sql);

        return @pg_fetch_all($query);

    }

    /*
     * joins faz operação de todos os joins com este model
     *  passando o sql como paremetro, ex: self::joins('left join b on y=x')
     */

    public static function joins($sql, $params = [])
    {
        $params = array_merge(
            array(
                'limit' => 0,
                'table' => null,
                'fields' => '*',
                'values' => []
            ),
            $params
        );

        if ($params['table'] === null)
            $params['table'] = self::parseTableName(get_called_class());

        $sql = "select {$params['fields']} from {$params['table']} " . $sql . ($params['limit'] > 0 ? ' limit ' . $params['limit'] : '');
        $db_conn = Database::getConnection();
        $query = pg_query_params($db_conn, $sql,$params['values']);

        return @pg_fetch_all($query);

    }

    /*
     * all
     *
     */

    public function all($limit = '')
    {
        if (!empty($this->table)) {
            $sql = "select * from {$this->table} " . ($limit > 0 ? ' limit ' . $limit : '');
            $db_conn = Database::getConnection();
            $query = @pg_query($db_conn, $sql);
            return @pg_fetch_all($query);
        }
        return array();
    }

    public static function find($id, $params = [])
    {
        $params = array_merge(
            [
                'table' => null,
            ],
            $params
        );

        $model = get_called_class();

        if ($params['table'] === null)
            $params['table'] = self::parseTableName($model);

        $sql = "select * from {$params['table']} where id = '{$id}' limit 1";
        $db_conn = Database::getConnection();
        $query = @pg_query($db_conn, $sql);
        $result = @pg_fetch_assoc($query);
        return $result ? new $model($result) : $result;
    }

    /* where
     *
     *
    */

    public static function where($sql, $params = [])
    {
        $params = array_merge(
            [
                'table' => null,
                'limit' => null,
                'fields' => '*',
                'values' => []
            ],
            $params
        );

        $model = get_called_class();

        if ($params['table'] === null)
            $params['table'] = self::parseTableName($model);

        $sql = "select {$params['fields']} from {$params['table']} where {$sql} ".($params['limit'] == null ? '' : $params['limit']);

        $db_conn = Database::getConnection();
        $query = pg_query_params($db_conn, $sql, $params['values']);
        return @pg_fetch_all($query);
    }




    /* findBelongs
    *
     *
    */

    public static function findBelongs($id, $params = [])
    {
        $result = [];
        $params = array_merge(
            [
                'table' => null,
            ],
            $params
        );

        $model = get_called_class();

        if ($params['table'] === null)
            $params['table'] = self::parseTableName($model);

        $sql = "select * from {$params['table']} where id = '{$id}' limit 1";
        $db_conn = Database::getConnection();
        $query = @pg_query($db_conn, $sql);
        $result[$params['table']] = @pg_fetch_assoc($query);

        if (isset($params['belongs']) > 0) {
            foreach ($params['belongs'] as $wit) {
                if (isset($wit['table']) && isset($wit['through'])) {
                    $id = $result[$params['table']][$wit['through']];
                    if (!empty($id)) {
                        $sql = "select * from {$wit['table']} where id = '{$id}' limit 1";
                        $db_conn = Database::getConnection();
                        $query = @pg_query($db_conn, $sql);
                        $result[$wit['table']] = pg_fetch_assoc($query);
                    }
                }
            }
        }
        return $result;

    }

    public function destroy()
    {
        if (!empty($this->table)) {
            $sql = "delete from {$this->table} where id = $1";
            $db_conn = Database::getConnection();
            $query = @pg_query_params($db_conn, $sql, array($this->id->getValue()));
            return true;
        }
        return false;
    }

}

/** PERGUNTAR AO PROFESSOR */
function __call($name, $arguments)
{
    // TODO: Implement __call() method.
}

?>
