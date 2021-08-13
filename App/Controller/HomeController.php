<?php
namespace App\Controller;



class HomeController extends AppController
{
	public function __construct()
	{
		parent::__construct();
        $this->loadModel('SaleDetail');
        $this->loadModel('Sale');
        $this->loadModel('Purchase');
        $this->loadModel('Inventory');

	}

	public function index(){
		$form = null;
		$sales = count($this->Sale->all());
		$purchases = count($this->Purchase->all());
		$inventories = count($this->Inventory->all());

        $top_articles = $this->SaleDetail->top(5);

		$this->render('home', compact('form', 'top_articles', 'sales', 'purchases', 'inventories'));
	}


}