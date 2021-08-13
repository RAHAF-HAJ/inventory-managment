<?php
namespace App\Model;

use Core\Model\Model;

class ClientModel extends Model
{
	protected $table = 'clients';

	public function load($filter = null){
		return $this->query('SELECT
				clients.*

				FROM clients, users

				WHERE clients.created_by = users.id
				'.$filter.'
				');
	}

}