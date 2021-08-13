<?php
namespace App\Model;

use Core\Model\Model;

class PermissionModel extends Model
{
    protected $table = 'permissions';

    public function load($per_name) {
        return $this->query('SELECT
				permissions.id
				FROM permissions
				WHERE name=?
				', [$per_name]);
    }
}