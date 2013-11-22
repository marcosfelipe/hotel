<?php

class ApplicationModel extends Base{

    public static function forSelect(){
        return self::allS(['fields' => 'id as value, description as option']);
    }

}