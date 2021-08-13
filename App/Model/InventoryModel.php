<?php
namespace App\Model;

use Core\Model\Model;

class InventoryModel extends Model {
    protected $table = 'inventories';

    public function load($filter = null){
        return $this->query('SELECT
				*
				FROM inventories
				WHERE 
				'.$filter.'
				');
    }

    public function articles($filter = '', $group = ' group by purchase_details_articles_join.article_id', $having = '') {
        return $this->query("
         CALL `InventoryPurchaseSalesDetails`(?, ?, ?);
        ", [$filter, $group, $having]);
    }

    public function total($filter = null) {
        return $this->query("
         CALL `InventoryTotals`(?);
        ", [$filter]);

    }
}