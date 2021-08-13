<?php

namespace Core;


class Config
{
    private static $_instance;
    private $settings = [];

    public function __construct($config_file)
    {
        $this->settings = include ($config_file);
    }

    public static function getInstance($config_file){
        if(self::$_instance === null) {
            self::$_instance = new Config($config_file);
        }
        return self::$_instance;
    }

    public function get($key){
        if(!isset($this->settings[$key])){
            return null;
        }
        return $this->settings[$key];
    }

}