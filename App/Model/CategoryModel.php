<?php
namespace App\Model;

use Core\Model\Model;

class CategoryModel extends Model
{
	protected $table = 'categories';

	public function load($filter = null){
		return $this->query('SELECT
				categories.id,
				 categories.category

				FROM categories
				'.$filter.'
				');
	}


}