<?php
namespace App\Model;

use Core\Model\Model;

class SaleModel extends Model
{
    protected $table = 'sales';

    public function load($filter = null){
        return $this->query('SELECT
				*

				FROM $this->table 

				WHERE 1 AND
				'.$filter.'
				');
    }
}