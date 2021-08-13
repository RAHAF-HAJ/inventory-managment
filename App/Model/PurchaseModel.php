<?php
namespace App\Model;

use Core\Model\Model;

class PurchaseModel extends Model
{
    protected $table = 'purchases';

    public function load($filter = null){
        return $this->query('SELECT
				*

				FROM $this->table 

				WHERE 1 AND
				'.$filter.'
				');
    }
}