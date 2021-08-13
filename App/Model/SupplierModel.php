<?php
namespace App\Model;

use Core\Model\Model;

class SupplierModel extends Model
{
	protected $table = 'suppliers';

	public function load($filter = null){
		return $this->query('SELECT
				suppliers.*

				FROM suppliers, users

				WHERE suppliers.created_by = users.id
				'.$filter.'
				');
	}

}