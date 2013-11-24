<?php

class Utils{

    /* clear_str limpa string */
    public static function clear_str($str){
        return preg_replace('/[^A-Za-z0-9\-]/', '', $str);
    }

    /* validDateTime valida se d/m/Y H:i:s é verdadeiro
    *
    */
    public static function validDateTime($value, $format = 'd/m/Y H:i:s')
    {
        return (bool)DateTime::createFromFormat($format, $value);
    }

}