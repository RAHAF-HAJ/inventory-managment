<?php
namespace App\Controller;


use Core\HTML\BootstrapForm;
use Core\Restful\RestHandler;

class SaleController extends AppController
{
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('Sale');
        $this->loadModel('SaleDetail');
        $this->loadModel('Client');
        $this->loadModel('Inventory');
        $this->restHandler = new RestHandler();
    }

    public function index(){
        $sales = $this->Sale->all();
        $clients = $this->Client->extract('id', 'name');
        $this->render('sale/index', compact('sales', 'clients'));
    }

    public function add(){

        if(!empty($_POST)){
            $params = [
                'client_id' => $_POST['client_id'],
                'number' => $_POST['number'],
                'subject' => $_POST['subject'],
                'note' => $_POST['note'],
                'date' => $_POST['date'],
                'discount' => (!empty($_POST['client_discount'])) ? $_POST['client_discount'] : 0,
                'created_by' => $this->User('id'),
                'updated_by' =>$this->User('id')
            ];


            $rs = $this->Sale->create($params);
            if($rs){
                $id = $this->Sale->max();
                if(!empty($_POST['article_id'])) {
                    $sale_detail_params = [];
                    foreach ($_POST['article_id'] as $key => $article_id) {
                        $sale_detail_params = [
                            'sale_id' => $id,
                            'article_id' => $article_id,
                            'price' => $_POST['price'][$key],
                            'qty' => $_POST['qty'][$key],
                            'discount' => (!empty($_POST['discount'][$key])) ? $_POST['discount'][$key] : 0,
                            'inventory_id' => $_POST['inventory_id'][$key],
                            'created_by' => $this->User('id'),
                            'updated_by' =>$this->User('id')
                        ];
                        $this->SaleDetail->create($sale_detail_params);
                    }
                }
                $this->redirect('sale/index');
            }
        }
        $form = new bootstrapForm($_POST);
        $this->render('sale/edit', compact('form'));
    }

    public function edit(){
//        print_r($_POST);
//        exit();
        $id = $_GET['id'];
        if(!empty($_POST)){
            $params = [
                'client_id' => $_POST['client_id'],
                'number' => $_POST['number'],
                'subject' => $_POST['subject'],
                'note' => $_POST['note'],
                'date' => $_POST['date'],
                'discount' => (!empty($_POST['client_discount'])) ? $_POST['client_discount'] : 0,
                'updated_by' =>$this->User('id')
            ];

            $rs = $this->Sale->update($id, $params);
            if($rs){
                if(!empty($_POST['article_id'])) {
                    $sale_detail_params = [];
                    foreach ($_POST['article_id'] as $key => $article_id) {
                        $sale_detail_params = [
                            'sale_id' => $id,
                            'article_id' => $article_id,
                            'price' => $_POST['price'][$key],
                            'inventory_id' => $_POST['inventory_id'][$key],
                            'qty' => $_POST['qty'][$key],
                            'discount' => (!empty($_POST['discount'][$key])) ? $_POST['discount'][$key] : 0,
                            'updated_by' =>$this->User('id')
                        ];
                        if(empty($_POST['id'][$key]))
                            $this->SaleDetail->create($sale_detail_params);
                        else
                            $this->SaleDetail->Update($_POST['id'][$key], $sale_detail_params);
                    }
                }
                $this->redirect('sale/index');
            }
        }
        $sale = $this->Sale->find($id);
        $items = $this->SaleDetail->load(' `sale_id` = ' . (int)$id);
        $form = new bootstrapForm($sale);
        $inventory_products = $this->Inventory->articles(' 1 ', 'group by purchase_details_articles_join.article_id', ' HAVING  (SUM(purchase_details_articles_join.qty) - COALESCE(SUM(sale_details_articles_join.qty), 0)) > 0');
        $this->render('sale/edit', compact('form', 'sale', 'items', 'inventory_products'));
    }

    public function delete(){
        if(isset($_POST['sale_id'])){
            $id = $_POST['sale_id'];
            //First delete all the items related to this table
            $items = $this->SaleDetail->load(' `sale_id` = ' . (int)$id);
//            $items = $this->SaleDetail->load(' `sale_id` = ' . (int)$id);
            if(!empty($items)) {
                foreach ($items as $item) {
                    $this->SaleDetail->delete($item->id);
                }
            }
            $rs = $this->Sale->delete($_POST['sale_id']);
            if($rs){
                return 1;
            } else {
                return 0;
            }
        }
    }

    /**
     * Get the top X selles
     * @return mixed
     */
    public function top() {
        $show_sales = $this->canUser('show_sales');
        if($show_sales) {
            $limit = (isset($_GET['id']) && $_GET['id'] > 0) ? $_GET['id'] : 5;
            $top_articles = $this->SaleDetail->top($limit);
            if(!empty($top_articles)) {
                foreach ($top_articles as $key => $top_article) {
                    $top_articles[$key]->article_id = (int)$top_article->article_id;
                    $top_articles[$key]->qty = (int)$top_article->qty;
                }
            }
            if($this->restHandler->getAcceptedType() == 'json') {
                $this->restHandler->sendJsonResponse(200, $top_articles);
            }
            return $top_articles;
        }
        return [];
    }
}