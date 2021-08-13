<?php
namespace App\Model;

use Core\Model\Model;

class SaleDetailModel extends Model
{
    protected $table = 'sale_details';
    public $article_id, $qty;

    public function load($filter = null){
        return $this->query('SELECT
				*

				FROM sale_details 

				WHERE 1 AND
				'.$filter.'
				');
    }
    public function load_arts($filter){
        return $this->query($query = '
                        SELECT * FROM `sale_details_articles_join`
                        WHERE
                        '.$filter.'
				');
    }

    public function total($filter) {
        return $this->query($query = '
                        SELECT SUM(total) as total, SUM(total_tva) as total_tva,  SUM(over_all_total) as over_all_total FROM `sale_details_articles_join`
                        WHERE
                        '.$filter.'
				');
    }

    public function top($limit = 5) {
        return $this->query($query = '
                       SELECT article_id, desig, SUM(qty) as qty from sale_details_articles_join GROUP BY article_id ORDER BY qty DESC
                        LIMIT '. $limit .'
				');
    }

}