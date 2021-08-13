<?php
namespace App\Model;

use Core\Database;
use Core\Model\Model;
use App\Model\RoleModel;

class UserModel extends Model
{
	protected $table = 'users';

	function __construct(Database $db)
    {
        parent::__construct($db);
        $this->Role = new RoleModel($db);
    }

    public function load($filter = null){
		return $this->query('SELECT
				users.*,
				 roles.role_name

				FROM users, roles

				WHERE users.role_id = roles.id
				'.$filter.'
				');
	}
	public function find($id, $full_version = false){
	    $id = (integer)$id;
	    if($full_version) {
            $user = new \stdClass();
	        $user_ob = $this->query('SELECT
				*
				FROM users
				WHERE users.id = ?
				', [$id], true);

	        if(!empty($user_ob)) {
                //load role
                $user = $this->Role->find($user_ob->role_id);
                $user_ob = (array)$user_ob;
                foreach ($user_ob as $prop => $value) {
                    $user->$prop = $value;
                }
            }
            return $user;
        }
	    else {
            return $this->query('SELECT
				users.*,
				 roles.role_name

				FROM users, roles

				WHERE users.role_id = roles.id
				AND users.id = ?
				', [$id], true);

        }
	}

	public function show($id){

	}

	public function login($login, $pass){
	    $user_ob = $this->db->prepare("SELECT
				users.*
				FROM users
				WHERE
				login = ?
		", [$login], true);
		if($user_ob) {
		    //load role
            $user = $this->Role->find($user_ob->role_id);
            $user_ob = (array)$user_ob;
            foreach ($user_ob as $prop => $value) {
                $user->$prop = $value;
            }
        }
		if($user){
			if($user->pass == sha1($pass)){
			    $requestContentType = $_SERVER['HTTP_ACCEPT'];
                if(strpos($requestContentType,'application/json') === false) {
                    $_SESSION['user'] = $user;
                    setcookie('cm_user_id', $user->id, time() + 3600, '/');
                    return true;
                }
                else {
                    return $user;
                }
			}
		} else {
			return true;
		}
		return false;
	}

}