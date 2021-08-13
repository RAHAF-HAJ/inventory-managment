<?php
namespace App\Controller;

use Core\HTML\BootstrapForm;

class UnitController extends AppController
{
	public function __construct()
	{
		parent::__construct();
		$this->loadModel('Unit');
	}

	public function index(){
		$units = $this->Unit->all();
		$form = new bootstrapForm($_POST);
		$this->render('units/index', compact('form', 'units' ));
	}

	public function printlist(){
		$filter = '';
		if (isset($_SESSION['filter'])) {
			$filter = $_SESSION['filter'];
		}
		$units = $this->Unit->load($filter);

		$this->pdf('units/printlist', compact('units'));

	}
	public function search(){
		$filter = '';
		$rs = '';
		if(isset($_POST['unit']))
			$filter .= " WHERE unit like '%{$_POST['unit']}%'";

		$_SESSION['filter'] = $filter;


		$units = $this->Unit->load($filter);

		foreach($units as $unit) {
			$rs .= '<tr>
						<td class="table-actions">
							<a href="<?= App::$path ?>unit/edit/' . $unit->id . '" class="btn btn-warning btn-xs">Update</a>';

			if($unit->id > 0){
				$rs .= ' <a href="#" class="btn btn-danger btn-xs" unit_id="' . $unit->id . '" onclick="deleteArt(this, event);">Delete</a>';
			}
			$rs .= '</td>
						<td>' . $unit->unit . '</td>
					</tr>';
		}
		return $rs;
	}
	public function delete(){
		if(isset($_POST['unit_id'])){
			$rs = $this->Unit->delete($_POST['unit_id']);
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
				'unit' => $_POST['unit']
			];
			$rs = $this->Unit->create($params);
			if($rs){
				$this->redirect('unit/index');
			}
		}
		$form = new bootstrapForm($_POST);
		$this->render('units/edit', compact('form'));
	}
	public function edit(){
		$id = $_GET['id'];
		if(!empty($_POST)){
			$rs = $this->Unit->update($id, [
				'unit' => $_POST['unit']
			]);
			if($rs){
				$this->redirect('unit/index');
			}
		}
		$unit = $this->Unit->find($id);
		$form = new bootstrapForm($unit);
		$this->render('units/edit', compact('form'));
	}

}