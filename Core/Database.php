<?php
namespace Core;
use \PDO;

class Database{
    private $db_host;
    private $db_user;
    private $db_pass;
    private $db_name;
    private $pdo;

    public function __construct($db_name, $db_host = 'localhost', $db_user = 'root', $db_pass = '') {
        $this->db_host = $db_host;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_name = $db_name;
    }

    private function getPDO(){
        if($this->pdo === null) {
            $pdo = new PDO('mysql:dbname=' . $this->db_name . ';host=' . $this->db_host, $this->db_user, $this->db_pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->query('SET names utf8; SET CHARACTER SET utf8');
            $this->pdo = $pdo;
        }
        return $this->pdo;

    }

    public function query($statement, $one = false, $class = null){
        $rs = $this->getPDO()->query($statement);
        if(
            strpos(strtolower($statement), 'INSERT') === 0 ||
            strpos(strtolower($statement), 'DELETE') === 0 ||
            strpos(strtolower($statement), 'UPDATE') === 0
        ){
            return $rs;
        }
        if($class === null){
            $rs->setFetchMode(PDO::FETCH_OBJ);
        } else {
            $rs->setFetchMode(PDO::FETCH_CLASS, $class);
        }
        if($one){
            if($one === 'muti_insert')
                $data = $rs->rowCount();
            else
                $data = $rs->fetch();

        } else {
            $data = $rs->fetchAll();
        }

        return $data;
    }



    public function prepare($statement, $attributes, $one = false, $class = null){
        $rs = $this->getPDO()->prepare($statement);
        $rst = $rs->execute($attributes);
        if(
            strpos(strtolower($statement), 'insert') === 0 ||
            strpos(strtolower($statement), 'delete') === 0 ||
            strpos(strtolower($statement), 'update') === 0
        ){
            return $rst;
        }
        if ($class === null){
            $rs->setFetchMode(PDO::FETCH_OBJ);
        } else {
            $rs->setFetchMode(PDO::FETCH_CLASS, $class);
        }
        if($one){
            $data = $rs->fetch();
        } else {
            $data = $rs->fetchAll();
        }

        return $data;
    }

}