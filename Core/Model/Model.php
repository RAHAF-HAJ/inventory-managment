<?php

namespace Core\Model;

use Core\Database;

class Model
{
    protected $db;
    protected $table;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function all(){
        return $this->query("SELECT * FROM ".$this->table);
    }
    public function max(){
        $rs = $this->query("SELECT max(id) as maxid FROM ".$this->table);
        return intval($rs[0]->maxid);
    }
    public function extract($key, $value, $postfix_value = ''){
        $records = $this->all();
        $arr = [];
        foreach($records as $row){
            $arr[$row->$key] = $row->$value;
            if(!empty($postfix_value)) {
                $arr[$row->$key] = $row->$value .' '. $row->$postfix_value;
            }
        }
        return $arr;
    }
    public function create($fields){
        $sql_pairs = [];
        $attributes = [];
        foreach ($fields as $k => $v) {
            $sql_pairs[] = "$k = ?";
            $attributes[] = $v;
        }
        $sql_parts = implode(', ', $sql_pairs);
//        print_r($attributes);
//        exit();
        return $this->query("INSERT INTO {$this->table} SET $sql_parts ", $attributes);
    }

    public function update($id, $fields){
        $sql_pairs = [];
        $attributes = [];
        foreach ($fields as $k => $v) {
            $sql_pairs[] = "$k = ?";
            $attributes[] = $v;
        }
        $attributes[] = $id;
        $sql_parts = implode(', ', $sql_pairs);
        return $this->query("UPDATE {$this->table} SET $sql_parts  WHERE id = ?", $attributes);
    }
    public function delete($id){
        return $this->query("DELETE FROM {$this->table} WHERE id = ?", [$id], true);
    }

    public function find($id){
        return $this->query("SELECT * FROM {$this->table} WHERE id = ?", [$id], true);
    }

    public function search($id, $fields = null){

    }

    public function query($statement, $attributes = null, $one = false){
        if($attributes){
            return $this->db->prepare(
                $statement,
                $attributes,
                $one,
                str_replace('Model', 'Entity', get_class($this))
            );
        } else{
            return $this->db->query(
                $statement,
                $one,
                str_replace('Model', 'Entity', get_class($this))
            );
        }
    }

    public function queryProcedure() {

    }
}