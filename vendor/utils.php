<?php

class Utils{

    public static function clear_str($str){
        return preg_replace('/[^A-Za-z0-9\-]/', '', $str);
    }

}