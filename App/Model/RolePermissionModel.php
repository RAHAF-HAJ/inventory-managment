<?php
namespace App\Model;

use Core\Model\Model;

class RolePermissionModel extends Model
{
    protected $table = 'roles_permissions';

    public function load($filter = null){
        return $this->query('SELECT
                id
				FROM roles_permissions

				WHERE 1 AND 
				'.$filter.'
				');
    }
}