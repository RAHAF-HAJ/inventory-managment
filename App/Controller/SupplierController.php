<?php
namespace App\Controller;


use Core\HTML\BootstrapForm;
use Core\Restful\RestHandler;

class SupplierController extends AppController
{
    var $restHandler;
	public function __construct()
	{
		parent::__construct();
		$this->loadModel('Supplier');
        $this->restHandler = new RestHandler();
	}

	public function index(){
	    //Check permission
	    if(!$this->CurrentUser()->show_suppliers) {
            $this->render('template/403');
        }

		$suppliers = $this->Supplier->load();
        if(empty($suppliers)) {
            $statusCode = 404;
            $suppliers = array('error' => 'No Suppliers found!');
        } else {
            $statusCode = 200;
        }
        if($this->restHandler->getAcceptedType() == 'json'){
            $this->restHandler->sendJsonResponse($statusCode, $suppliers, '', '');

        } else {
            $add_form = new bootstrapForm();
            $this->render('suppliers/index', compact('suppliers', 'add_form'));
        }

	}
	public function modal(){

		$suppliers = $this->Supplier->all();
		$rs = '';
		foreach($suppliers as $supplier) {
			$rs .= '<tr>
						<td class="table-actions">
							<a href="#" class="btn btn-success btn-xs btn-select-supplier" supplier_id="' . $supplier->id . '" onclick="selectSupplier(this, event);">اختر</a>
						</td>
						<td class="supplier_name">' . $supplier->name . '</td>
						<td class="supplier_city">' . $supplier->city . '</td>
						<td class="supplier_address">' . $supplier->address . '</td>
					</tr>';
		}
		return $rs;
	}

    public function options(){

        $suppliers = $this->Supplier->all();
        $rs = '';
        foreach($suppliers as $supplier) {
            $rs .= '<option value="'. $supplier->id .'">
						'. $supplier->name .', '.$supplier->city . '
					</option>';
        }
        return $rs;
    }

	public function add(){
	    $can_user = $this->canUser('add_suppliers');

	    if(!$can_user) {
	        return $can_user;
        }

        if(!empty($_POST)){
			$params = [
				'name' => $_POST['name'],
				'tel' => $_POST['tel'],
				'email' => $_POST['email'],
				'zip_code' => $_POST['zip_code'],
				'city' => $_POST['city'],
				'address' => $_POST['address'],
                'is_special' => $_POST['is_special'],
				'created_by' => $this->CurrentUser()->id,
				'updated_by' => $this->CurrentUser()->id
			];

			$rs = $this->Supplier->create($params);
            $error = '';
            $code = '';
            if(empty($rs)) {
                $statusCode = 404;
                $error = 'Something went wrong';
                $code = 'DB_ERRPR';
            } else {
                $statusCode = 200;
            }

            if($this->restHandler->getAcceptedType() == 'json' || isset($_POST['ajax_action'])){
                $this->restHandler->sendJsonResponse($statusCode, ['is_added' => $rs], $error, $code );
            }
            $this->redirect('supplier/index');
		}

		$form = new bootstrapForm($_POST);
		$this->render('suppliers/edit', compact('form'));
	}
	public function edit(){
		$id = $_GET['id'];
		if(!empty($_POST)){
			$params = [
				'name' => $_POST['name'],
				'tel' => $_POST['tel'],
				'email' => $_POST['email'],
				'zip_code' => $_POST['zip_code'],
				'city' => $_POST['city'],
				'address' => $_POST['address'],
                'is_special' => $_POST['is_special'],
				'created_by' => $_SESSION['user']->id,
				'updated_by' => $_SESSION['user']->id
			];

			$rs = $this->Supplier->update($id, $params);
			if($rs){
				$this->redirect('supplier/index');
			}
		}
		$supplier = $this->Supplier->find($id);
		$form = new bootstrapForm($supplier);
		$this->render('suppliers/edit', compact('form', 'supplier'));
	}

	public function delete(){
		if(isset($_POST['supplier_id'])){
			$rs = $this->Supplier->delete($_POST['supplier_id']);
			if($rs){
				return 1;
			} else {
				return 0;
			}
		}
	}

    public function printlist(){
        $filter = '';
        if (isset($_SESSION['filter'])) {
            $filter = $_SESSION['filter'];
        }
        $articles = $this->Supplier->load();

        $this->pdf('support/printlist', compact('articles'));

    }


}