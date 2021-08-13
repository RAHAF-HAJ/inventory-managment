<?php
namespace App\Model;

use Core\Model\Model;

class PurchaseDetailModel extends Model
{
    protected $table = 'purchase_details';

    public function load($filter = null){
        return $this->query('SELECT
				*

				FROM purchase_details 

				WHERE 1 AND
				'.$filter.'
				');
    }

    public function load_arts($filter){
        return $this->query($query = '
                        SELECT * FROM `purchase_details_articles_join`
                       WHERE 1 AND
				'.$filter.'
				');
    }

    public function total($filter) {
        return $this->query($query = '
                        SELECT SUM(total) as total, SUM(total_tva) as total_tva,  SUM(over_all_total) as over_all_total FROM `purchase_details_articles_join`
                       WHERE 1 AND
				'.$filter.'
				');
    }

    public function remaining_qty($article_id) {
        return $this->query("
          SELECT `productRemainingQty`(?) as remaining_qty;
        ", [$article_id]);
    }
}