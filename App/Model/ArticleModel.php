<?php
namespace App\Model;

use Core\Model\Model;

class ArticleModel extends Model
{
	protected $table = 'articles';
	public function load($filter = null){
		return $this->query('SELECT
				articles.id,
				 articles.ref,
				 articles.desig,
				 articles.tva,
				 articles.color,
				units.unit,
				categories.category,
				suppliers.name as supplier_name

				FROM articles, suppliers, units, categories

				WHERE articles.supplier_id = suppliers.id
				AND articles.category_id = categories.id
				AND articles.unit_id = units.id
				'.$filter.'
				');
	}
	public function find($id){
		return $this->query("SELECT
				articles.*,
				suppliers.name,
				suppliers.city,
				suppliers.address,
				units.unit,
				categories.category

				FROM articles, suppliers, units, categories

				WHERE articles.supplier_id = suppliers.id
				AND articles.unit_id = units.id
				AND articles.category_id = categories.id
				AND articles.id = ?", [$id], true);
	}

	public function show($id){
"BEGIN
DECLARE remining_qty INT(11);
remining_qty = productRemainingQty(id);
if(remining_qty < qty) THEN
SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'table t1 does not support deletion';
END";
	}

}