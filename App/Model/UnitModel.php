<?php
namespace App\Model;

use Core\Model\Model;

class UnitModel extends Model
{
	protected $table = 'units';

	public function load($filter = null){
		return $this->query('SELECT
				units.id,
				 units.unit

				FROM units
				'.$filter.'
				');
	}

}