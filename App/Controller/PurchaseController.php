<?php
namespace App\Controller;


use Core\HTML\BootstrapForm;

class PurchaseController extends AppController
{
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('Purchase');
        $this->loadModel('PurchaseDetail');
        $this->loadModel('Supplier');
    }

    public function index(){
        $purchases = $this->Purchase->all();
        $suppliers = $this->Supplier->extract('id', 'name');
        $this->render('purchase/index', compact('purchases', 'suppliers'));
    }

    public function add(){

        if(!empty($_POST)){
            $params = [
                'company_name' => $_POST['company_name'],
                'supplier_id' => $_POST['supplier_id'],
                'car_number' => $_POST['car_number'],
                'subject' => $_POST['subject'],
                'note' => $_POST['note'],
                'date' => $_POST['date'],
                'created_by' => $this->User('id'),
                'updated_by' =>$this->User('id')
            ];

            $rs = $this->Purchase->create($params);
            if($rs){
                $id = $this->Purchase->max();
                if(!empty($_POST['article_id'])) {
                    $purchase_detail_params = [];
                    $thumb = [];

                    if(!empty($_FILES['thumb'])) {
                        $max = $this->PurchaseDetail->max();
                        foreach($_FILES['thumb']['name'] as $key => $value) {

                            //Upload photos
                            $names = [];
                            foreach ($value as $k => $v) {
                                echo '<br>';
                                if($_FILES['thumb']['error'][$key][$k] == 0) {
                                    $file_name =  (string)($max + 1) . (string)$key . (string)$k . '.jpg';
                                    $file = ROOT . '/public/img/thumbs/purchase/' . $file_name;
                                    if (file_exists($file)) {
                                        unlink($file); //delete from disk
                                    }
                                    move_uploaded_file($_FILES['thumb']['tmp_name'][$key][$k], $file);
                                    $names[] = $file_name;
                                }
                            }
                            $thumb[$key] = serialize($names);
                        }
                    }
                    foreach ($_POST['article_id'] as $key => $article_id) {
                        $purchase_detail_params = [
                            'purchase_id' => $id,
                            'article_id' => $article_id,
                            'inventory_id' => $_POST['inventory_id'][$key],
                            'expire' => $_POST['expire'][$key],
                            'price' => $_POST['price'][$key],
                            'qty' => $_POST['qty'][$key],
                            'thumb' => isset($thumb[$key])? $thumb[$key] : serialize([]),
                            'created_by' => $this->User('id'),
                            'updated_by' =>$this->User('id')
                        ];
                        $this->PurchaseDetail->create($purchase_detail_params);
                    }
                }
                $this->redirect('purchase/index');
            }
        }
        $form = new bootstrapForm($_POST);
        $this->render('purchase/edit', compact('form'));
    }

    public function edit(){
        $id = $_GET['id'];
        if(!empty($_POST)){
            $params = [
                'company_name' => $_POST['company_name'],
                'supplier_id' => $_POST['supplier_id'],
                'car_number' => $_POST['car_number'],
                'subject' => $_POST['subject'],
                'note' => $_POST['note'],
                'date' => $_POST['date'],
                'updated_by' =>$this->User('id')
            ];

            $rs = $this->Purchase->update($id, $params);
            if($rs){
                if(!empty($_POST['article_id'])) {
                    $purchase_detail_params = [];
                    foreach ($_POST['article_id'] as $key => $article_id) {
                        $purchase_detail_params = [
                            'purchase_id' => $id,
                            'article_id' => $article_id,
                            'inventory_id' => $_POST['inventory_id'][$key],
                            'expire' => $_POST['expire'][$key],
                            'price' => $_POST['price'][$key],
                            'qty' => $_POST['qty'][$key],
                            'updated_by' =>$this->User('id')
                        ];
                        if(empty($_POST['id'][$key]))
                            $this->PurchaseDetail->create($purchase_detail_params);
                        else
                            $this->PurchaseDetail->Update($_POST['id'][$key], $purchase_detail_params);
                    }
                }
                $this->redirect('purchase/index');
            }
        }
        $purchase = $this->Purchase->find($id);
        $items = $this->PurchaseDetail->load(' `purchase_id` = ' . (int)$id);
        if(!empty($items)) {
            foreach ($items as $key => $item) {
                //Call remaining qty
                $items[$key]->remaining_qty = $this->PurchaseDetail->remaining_qty($item->article_id)[0]->remaining_qty;
            }
        }
        $form = new bootstrapForm($purchase);
        $this->render('purchase/edit', compact('form', 'purchase', 'items'));
    }

    public function delete(){
        //Check if there is any client has bought any item from this one and prevent deleting
        if(isset($_POST['purchase_id'])){
            $id = $_POST['purchase_id'];
            //First delete all the items related to this table
            $items = $this->PurchaseDetail->load(' `purchase_id` = ' . (int)$id);
            if(!empty($items)) {
                foreach ($items as $item) {
                    $this->PurchaseDetail->delete($item->id);
                }
            }
            $rs = $this->Purchase->delete($_POST['purchase_id']);
            if($rs){
                return 1;
            } else {
                return 0;
            }
        }
    }

}