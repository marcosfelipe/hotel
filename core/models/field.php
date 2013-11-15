<?php
class Field
{

    private $name;
    private $value;
    private $size;
    private $error;
    private $type;
    private $flag_error;
    private $required = false;
    private $ignore = [];
    private $date_format = 'd/m/Y';

    public function __construct($name = '', $value = '')
    {
        $this->setValue($value);
        $this->setName($name);
    }

    public function setRequired($required)
    {
        $this->required = $required;
    }

    public function isRequired()
    {
        return $this->required == true;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setDateFormat($format)
    {
        $this->date_format = $format;
    }

    private function ignore($str)
    {
        return str_replace($this->ignore, '', $str);
    }

    private function formatDate($date,$format = 'd/m/Y')
    {
        if (strpos($date, '/') !== false) {
            $_date = explode('/', $date);
            return $_date[2] . '-' . $_date[1] . '-' . $_date['0'];
        }elseif( !empty($date) ){
            return date( $format, strtotime($date));
        }
        return '';
    }

    public function setValue($value)
    {
        switch ($this->type) {
            case 'float' :
                $this->value = str_replace(',', '.', $value);
                break;
            case 'date' :
                $this->value = $this->formatDate($value,'Y-m-d');
                break;
            default :
                $this->value = $value;
                break;
        }
        $this->value = $this->ignore($this->value);
    }

    public function setSize($size)
    {
        $this->size = $size;
    }

    public function setError($error)
    {
        $this->error = $error;
    }

    public function setFlagError($flag)
    {
        $this->flag_error = $flag;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function setIgnore(array $array)
    {
        $this->ignore = $array;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getValue()
    {
        switch ($this->type) {
            case 'date' :
                $value = $this->formatDate($this->value, $this->date_format);
                break;
            default :
                $value = $this->value;
                break;
        }
        return $value;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function getError()
    {
        return $this->error;
    }

    public function getFlagError()
    {
        return $this->flag_error;
    }


}