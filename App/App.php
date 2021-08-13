<?php


use Core\Config;
use Core\Database;

class App{
    private $db;
    private static $_instance;
    public $cur_page = 'index';
    public static $path;

    public static function getInstance(){
        if(self::$_instance === null) {
            self::$_instance = new App();
        }
        return self::$_instance;
    }

    public static function load(){
        session_start();
        include(ROOT.'/App/Autoloader.php');
        \App\Autoloader::register();

    }

    public function getDb(){
        if ($this->db === null) {
            $config = Config::getInstance(ROOT.'/config/config.php');
            $this->db = new Database($config->get('db_name'));
        }
        return $this->db;
    }

    public function getModel($name){
        $model = '\App\Model\\'.ucfirst($name).'Model';
        return new $model($this->getDb());
    }

    public static function nFormat($number = 0){
        return number_format($number, 2, '.', ' ');
    }

    public static function getJWTConfig() {
        $config = Config::getInstance(ROOT.'/config/config.php');
        return [
            'exp' => $config->get('exp'),
            'iat' => $config->get('iat'),
            'nbf' => $config->get('nbf'),
            'iss' => $config->get('iss'),
            'aud' => $config->get('aud'),
            'key' => $config->get('key'),
        ];
    }
}