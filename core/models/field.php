<?php

require_once 'vendor/utils.php';

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
    private $empty_value = false;

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

    public function setEmptyValue($value)
    {
        $this->empty_value = $value;
    }

    public function setDateFormat($format)
    {
        $this->date_format = $format;
    }

    private function ignore($str)
    {
        return str_replace($this->ignore, '', $str);
    }

    private function formatDate($date,$format = 'd/m/Y',$time = false)
    {
        if (strpos($date, '/') !== false && $time == false) {
            if( !Utils::validDateTime($date, 'd/m/Y')) return $date;
            $_date = explode('/', $date);
            return $_date[2] . '-' . $_date[1] . '-' . $_date['0'];
        }elseif (strpos($date, '/') !== false && $time) {
            if( !Utils::validDateTime($date)) return $date;
            $_date = explode('/', $date);
            $_time = explode(' ',$_date[2]);
            $_date[2] = $_time[0];
            return $_date[2] . '-' . $_date[1] . '-' . $_date['0'].' '.$_time[1];
        }elseif( !empty($date) ){
            if( !Utils::validDateTime($date, $format)) return $date;
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
                $this->value = $this->formatDate($value);
                break;
            case 'datetime' :
                $this->value = $this->formatDate($value,'Y-m-d H:i:s',true);
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
        $value = $this->value;
        if( $value == '' ){
            if( $this->empty_value != false ){
                $value = $this->empty_value;
            }
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