<?php
namespace App\Controller;


use Core\HTML\BootstrapForm;

class ClientController extends AppController
{
	public function __construct()
	{
		parent::__construct();
		$this->loadModel('Client');
	}

	public function index(){
		$clients = $this->Client->load();
		$this->render('clients/index', compact('clients'));
	}
	public function modal(){

		$clients = $this->Client->all();
		$rs = '';
		foreach($clients as $client) {
			$rs .= '<tr>
						<td class="table-actions">
							<a href="#" class="btn btn-success btn-xs btn-select-client" client_id="' . $client->id . '" onclick="selectClient(this, event);">اختر</a>
						</td>
						<td class="client_name">' . $client->name . '</td>
						<td class="client_city">' . $client->city . '</td>
						<td class="client_address">' . $client->address . '</td>
					</tr>';
		}
		return $rs;
	}

	public function add(){
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

			$rs = $this->Client->create($params);
			if($rs){
				$this->redirect('client/index');
			}
		}
		$form = new bootstrapForm($_POST);
		$this->render('clients/edit', compact('form'));
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

			$rs = $this->Client->update($id, $params);
			if($rs){
				$this->redirect('client/index');
			}
		}
		$client = $this->Client->find($id);
		$form = new bootstrapForm($client);
		$this->render('clients/edit', compact('form', 'client'));
	}

	public function delete(){
		if(isset($_POST['client_id'])){
			$rs = $this->Client->delete($_POST['client_id']);
			if($rs){
				return 1;
			} else {
				return 0;
			}
		}
	}

    public function options(){

        $clients = $this->Client->all();
        $rs = '';
        foreach($clients as $client) {
            $rs .= '<option value="'. $client->id .'">
						'. $client->name .', '.$client->city . '
					</option>';
        }
        return $rs;
    }


}