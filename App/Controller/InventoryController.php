<?php
namespace App\Controller;

use Core\HTML\BootstrapForm;

class InventoryController extends AppController {
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('Inventory');
        $this->loadModel('User');
        $this->loadModel('Category');
        $this->loadModel('Unit');
    }

    public function index(){
        $inventories = $this->Inventory->all();
        $users = $this->User->extract('id', 'fname', 'lname');
        $form = new bootstrapForm($_POST);
        $this->render('inventory/index', compact('form', 'inventories', 'users' ));
    }

    public function delete(){
        if(isset($_POST['inventory_id'])){
            $rs = $this->Inventory->delete($_POST['inventory_id']);
            if($rs){
                return 1;
            } else {
                return 0;
            }
        }
    }

    public function add(){
        if(!empty($_POST)){
            $params = [
                'name' => $_POST['name'],
                'manager' => $_POST['manager'],
                'address' => $_POST['address'],
            ];
            $rs = $this->Inventory->create($params);
            if($rs){
                $this->redirect('inventory/index');
            }
        }
        $form = new bootstrapForm($_POST);
        $inventories = $this->Inventory->all();
        $this->render('inventory/edit', compact('form', 'inventories'));
    }

    public function edit(){
        $id = $_GET['id'];
        if(!empty($_POST)){
            $rs = $this->Inventory->update($id, [
                'name' => $_POST['name'],
                'manager' => $_POST['manager'],
                'address' => $_POST['address'],
            ]);
            if($rs){
                $this->redirect('inventory/index');
            }
        }
        $inventory = $this->Inventory->find($id);
        $form = new bootstrapForm($inventory);
        $this->render('inventory/edit', compact('form'));
    }

//    public function options() {
//        $inventories = $this->Inventory->all();
//        $rs = '';
//        foreach($inventories as $inventory) {
//            $rs .= '<option value="'. $inventory->id .'">
//						'. $inventory->name .'
//					</option>';
//        }
//        print_r( $rs);
//        exit();
//    }

    public function options() {
        //Check if the current user can sale from other inventories, he can't purchase for them too
        //If so, return the all inventories as options
        if($this->CurrentUser('sale_all_inventories')) {
            $inventories = $this->Inventory->all();
        }
        else {
            $inventories = $this->Inventory->load(' manager = ' . (int)$this->CurrentUser('id'));
        }

        $rs = '';
        foreach($inventories as $inventory) {
            $rs .= '<option value="'. $inventory->id .'">
						'. $inventory->name .'
					</option>';
        }
        return $rs;
    }

    public function articles() {
        $inventory_id = (int) (isset($_GET['id'])) ? $_GET['id'] : $_POST['inventory_id'];
        $articles = $this->Inventory->articles('  purchase_details_articles_join.inventory_id = ' . $inventory_id);
        return $articles;
    }

    public function totals() {
        $inventory_id = (int) (isset($_GET['id'])) ? $_GET['id'] : $_POST['inventory_id'];
        $totals = $this->Inventory->total('  purchase_details_articles_join.inventory_id = ' . $inventory_id);
        return $totals;
    }

    public function articles_options() {
        $articles = $this->articles();
//        print_r($articles);
//        exit();
        $categories = $this->Category->extract('id', 'category');
        $units = $this->Unit->extract('id', 'unit');
        $rs = '';
        if(!empty($articles)) {
            $rs .= '<table class="table main-table rtl_table data-table table-striped table-hover">
                    <thead>
                        <th>Product ID</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Unit</th>
                        
                        <th>Income quantity</th>
                        <th>Outcome quantity</th>
                        <th>Remaining quantity</th>
                        <th>total purchase price</th>
                        <th>total purchase tav</th>
                        <th>Overall purchase</th>
                        <th>total sale price</th>
                        <th>total sale tav</th>
                        <th>total product discount</th>
                        <th>total client discount</th>
                        <th>Overall sale</th>
                    </thead><tbody>
                ';
            foreach ($articles as $item) {
                $rs .= '<tr>
						<td class="supplier_address">' . $item->article_id . '</td>
						<td class="supplier_address">' . $item->ref . '</td>
						<td class="supplier_address">' . $item->desig . '</td>
						<td class="supplier_address">' . $categories[$item->category_id] . '</td>
						<td class="supplier_address">' . $units[$item->unit_id] . '</td>
						
						<td class="supplier_address">' . $item->purchase_qty . '</td>						
						<td class="supplier_address">' . $item->sale_qty . '</td>						
						<td class="supplier_address">' . $item->remaining_qty . '</td>						
						<td class="supplier_address">' . $item->purchase_total_price . '</td>
						<td class="supplier_address">' . $item->purchase_total_vat . '</td>
						<td class="supplier_address">' . $item->purchase_over_all_total . '</td>
						<td class="supplier_address">' . $item->sale_total_price . '</td>
						<td class="supplier_address">' . $item->sale_total_vat . '</td>
						<td class="supplier_address">' . $item->total_product_discount . '</td>
						<td class="supplier_address">' . $item->total_client_discount . '</td>
						<td class="supplier_address">' . $item->sale_over_all_total . '</td>
					</tr>';
            }
            $rs .="</tbody></table>";
            $totals = $this->totals();
            $rs .= '<span class="total"><label>Remaining purchase total:</label>'. $totals[0]->remaining_purchase_sum .'IQD</span>';
            $rs .= '<span class="total"><label>Remaining purchase Tva:</label>'. $totals[0]->remaining_purchase_tva .'IQD</span>';
            $rs .= '<span class="total"> <label>Remaining purchase ttl:</label>'. $totals[0]->remaining_purchase_ttc .'IQD</span>';
        }
        else {
            $rs = 'There are no products!';
        }
        return $rs;
    }

    /**
     * Load only the articles with remaining qty
     * @return mixed
     */
    public function available_articles() {
        $available_arts = [];
        $inventory_id = (int) (isset($_GET['id'])) ? $_GET['id'] : $_POST['inventory_id'];
        $articles = $this->Inventory->articles('  purchase_details_articles_join.inventory_id = ' . $inventory_id, 'group by purchase_details_articles_join.article_id', ' HAVING  (SUM(purchase_details_articles_join.qty) - COALESCE(SUM(sale_details_articles_join.qty), 0)) > 0');
        if(!empty($articles)) {
            foreach ($articles as $key=>$article) {
                $available_arts[$key]['id'] = $article->article_id;
                $available_arts[$key]['name'] = $article->desig;
                $available_arts[$key]['purchase_maximum_price'] = $article->purchase_maximum_price;
                $available_arts[$key]['remaining_qty'] = $article->remaining_qty;
            }
        }
        return json_encode($available_arts);
    }
}