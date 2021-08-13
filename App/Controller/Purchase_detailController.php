<?php
namespace App\Controller;


use Core\HTML\BootstrapForm;

class Purchase_detailController extends AppController
{
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('PurchaseDetail');
        $this->loadModel('Inventory');
        $this->loadModel('Category');
        $this->loadModel('Unit');
        $this->loadModel('Supplier');
    }

    public function table(){

        $purchase_id = (int) (isset($_GET['id']))? $_GET['id'] : null;
        if(empty($purchase_id))
            $purchase_id = (int) (isset($_POST['purchase_id']))? $_POST['purchase_id'] : null;
        $supplier_id = (isset($_POST['supplier_id'])) ? $_POST['supplier_id'] : null;
        $filter = '1';
        if(!empty($purchase_id))
            $filter .= ' AND purchase_id = ' . $purchase_id;
        if(!empty($supplier_id)) {
            $filter .= ' AND supplier_id = ' . $supplier_id;
        }

        $items = $this->PurchaseDetail->load_arts($filter);
        $rs = '';
        $inventories = $this->Inventory->extract('id', 'name');
        $categories = $this->Category->extract('id', 'category');
        $units = $this->Unit->extract('id', 'unit');
        $suppliers = $this->Supplier->extract('id', 'name');
        if(!empty($items)) {
            $rs .= '<table class="table main-table rtl_table data-table table-striped table-hover">
                    <thead>
                        <th>ID</th>
                        <th>Product ID</th>
                        <th>Inventory</th>
                        <th>Supplier</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Unit</th>
                        <th>Photo</th>
                        <th>color</th>
                        <th>Expire</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Tax</th>
                        <th>Total price</th>
                        <th>Total tax</th>
                        <th>TTl</th>
                    </thead><tbody>
                ';
            foreach ($items as $item) {
                $rs .= '<tr>
						<td class="supplier_address">' . $item->purchase_details_id . '</td>
						<td class="supplier_address">' . $item->article_id . '</td>
						<td class="supplier_address">' . $inventories[$item->inventory_id] . '</td>
						<td class="supplier_address">' . $suppliers[$item->supplier_id] . '</td>
						<td class="supplier_address">' . $item->ref . '</td>
						<td class="supplier_address">' . $item->desig . '</td>
						<td class="supplier_address">' . $categories[$item->category_id] . '</td>
						<td class="supplier_address">' . $units[$item->unit_id] . '</td>
						<td class="supplier_address"><img width="150px" src="'. \App::$path . 'img/thumbs/articles/'. $item->thumb.'"></td>
						<td class="supplier_address">' . $item->color . '</td>
						<td class="supplier_address">' . $item->expire . '</td>
						<td class="supplier_address">' . $item->price . '</td>
						<td class="supplier_address">' . $item->qty . '</td>
						<td class="supplier_address">' . $item->tva . '%</td>
						<td class="supplier_address">' . $item->total . 'IQD</td>
						<td class="supplier_address">' . $item->total_tva . 'IQD</td>
						<td class="supplier_address">' . $item->over_all_total . 'IQD</td>
						
					</tr>';
            }
            $rs .="</tbody></table>";
            $totals = $this->PurchaseDetail->total($filter);
            $rs .= '<span class="total"><label>Total:</label>'. $totals[0]->total .'IQD</span>';
            $rs .= '<span class="total"><label>Total tva:</label>'. $totals[0]->total_tva .'IQD</span>';
            $rs .= '<span class="total"> <label>Overall total:</label>'. $totals[0]->over_all_total .'IQD</span>';

        }
        else {
            $rs = 'There are no products!';
        }
        echo $rs;
    }

}