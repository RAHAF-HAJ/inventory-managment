<?php
namespace App\Model;

use Core\Model\Model;

class RoleModel extends Model
{
	protected $table = 'roles';

	public function all()
    {
        $new_roles = [];
        $roles = parent::all();
        if(!empty($roles)) {
            foreach ($roles as $role) {
                $new_role = new \stdClass();
                $new_role->id = $role->id;
                $new_role->role_name = $role->role_name;
                $permissions = $this->query('SELECT permission, value FROM `roles_permissions_join` WHERE id = ' . $role->id);

                if(!empty($permissions)) {
                    foreach ($permissions as $permission) {
                        $perm_name = $permission->permission;
                        $perm_value = $permission->value;
                        $new_role->$perm_name = $perm_value;
                    }
                }
                $new_roles[] = $new_role;
            }
        }
        return $new_roles;
    }

    public function find($id)
    {
        $role = parent::find($id);
        $new_role = new \stdClass();
        $new_role->id = $role->id;
        $new_role->role_name = $role->role_name;
        $permissions = $this->query('SELECT permission, value FROM `roles_permissions_join` WHERE id = ' . $role->id);
        if(!empty($permissions)) {
            foreach ($permissions as $permission) {
                $perm_name = $permission->permission;
                $perm_value = $permission->value;
                $new_role->$perm_name = $perm_value;
            }
        }
        return $new_role;
    }

}