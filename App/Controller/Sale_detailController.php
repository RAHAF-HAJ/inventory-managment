<?php
namespace App\Controller;


use Core\HTML\BootstrapForm;

class Sale_detailController extends AppController
{
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('SaleDetail');
        $this->loadModel('Category');
        $this->loadModel('Unit');
        $this->loadModel('Inventory');
        $this->loadModel('Client');
    }


    public function table(){
        $sale_id = (int) (isset($_GET['id']))? $_GET['id'] : null;
        if(empty($sale_id)) {
            $sale_id = (int) (isset($_POST['sale_id']))? $_POST['sale_id'] : null;
        }
        $client_id = (isset($_POST['client_id'])) ? $_POST['client_id'] : null;
        $filter = '1';
        if(!empty($sale_id))
            $filter .= ' AND sale_id = ' . $sale_id;
        if(!empty($client_id)) {
            $filter .= ' AND client_id = ' . $client_id;
        }
        $items = $this->SaleDetail->load_arts($filter);
        $rs = '';
        $categories = $this->Category->extract('id', 'category');
        $units = $this->Unit->extract('id', 'unit');
        $inventories = $this->Inventory->extract('id', 'name');
        $clients = $this->Client->extract('id', 'name');
        if(!empty($items)) {
            $rs .= '<table class="table main-table rtl_table data-table table-striped table-hover">
                    <thead>
                        <th>ID</th>
                        <th>Product ID</th>
                        <th>Inventory</th>
                        <th>Client</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Unit</th>
                        <th>color</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Tax</th>
                        <th>Product discount</th>
                        <th>Client discount</th>
                        <th>Total price</th>
                        <th>Total tax</th>
                        <th>Total product discount</th>
                        <th>Total client discount</th>
                        <th>TTl</th>
                    </thead><tbody>
                ';
            foreach ($items as $item) {
                $rs .= '<tr>
						<td class="supplier_address">' . $item->sale_details_id . '</td>
						<td class="supplier_address">' . $item->article_id . '</td>
						<td class="supplier_address">' . $inventories[$item->inventory_id] . '</td>
						<td class="supplier_address">' . $clients[$item->client_id] . '</td>
						<td class="supplier_address">' . $item->ref . '</td>
						<td class="supplier_address">' . $item->desig . '</td>
						<td class="supplier_address">' . $categories[$item->category_id] . '</td>
						<td class="supplier_address">' . $units[$item->unit_id] . '</td>
						<td class="supplier_address">' . $item->color . '</td>
						<td class="supplier_address">' . $item->price . '</td>
						<td class="supplier_address">' . $item->qty . '</td>
						<td class="supplier_address">' . $item->tva . '%</td>
						<td class="supplier_address">' . $item->product_discount . '%</td>
						<td class="supplier_address">' . $item->client_discount . '%</td>
						<td class="supplier_address">' . $item->total . 'IQD</td>
						<td class="supplier_address">' . $item->total_tva . 'IQD</td>
						<td class="supplier_address">' . $item->total_product_discount . 'IQD</td>
						<td class="supplier_address">' . $item->total_client_discount . 'IQD</td>
						<td class="supplier_address">' . $item->over_all_total . 'IQD</td>
						
					</tr>';
            }
            $rs .="</tbody></table>";
            $totals = $this->SaleDetail->total($filter);
            $rs .= '<span class="total"><label>Total:</label>'. $totals[0]->total .'IQD</span>';
            $rs .= '<span class="total"><label>Total tva:</label>'. $totals[0]->total_tva .'IQD</span>';
            $rs .= '<span class="total"> <label>Overall total:</label>'. $totals[0]->over_all_total .'IQD</span>';

        }
        echo $rs;
    }

}