<?php
namespace App\Entity;

use Core\Entity\Entity;

class UserEntity extends Entity{

    public function getUrl(){
        return 'user/profile/'.$this->id;
    }
    public function getCurrent_pass(){
        return null;
    }
    public function getNew_pass_confirmation(){
        return null;
    }
    public function getNew_pass(){
        return null;
    }

}