<?php
namespace App\Controller;

use Core\HTML\BootstrapForm;

class CategoryController extends AppController
{
	public function __construct()
	{
		parent::__construct();
		$this->loadModel('Category');
	}

	public function index(){
		$categories = $this->Category->all();
		$form = new bootstrapForm($_POST);
		$this->render('categories/index', compact('form', 'categories' ));
	}

	public function printlist(){
		$filter = '';
		if (isset($_SESSION['filter'])) {
			$filter = $_SESSION['filter'];
		}
		$categories = $this->Category->load($filter);

		$this->pdf('categories/printlist', compact('categories'));

	}
	public function search(){
		$filter = '';
		$rs = '';
		if(isset($_POST['category']))
			$filter .= " WHERE category like '%{$_POST['category']}%'";

		$_SESSION['filter'] = $filter;


		$categories = $this->Category->load($filter);

		foreach($categories as $cat) {
			$rs .= '<tr>
						<td class="table-actions">
							<a href="<?= App::$path ?>category/edit/' . $cat->id . '" class="btn btn-warning btn-xs">Update</a>';

			if($cat->id > 0){
				$rs .= ' <a href="#" class="btn btn-danger btn-xs" cat_id="' . $cat->id . '" onclick="deleteArt(this, event);">Delete</a>';
			}
			$rs .= '</td>
						<td>' . $cat->category . '</td>
					</tr>';
		}
		return $rs;
	}
	public function delete(){
		if(isset($_POST['cat_id'])){
			$rs = $this->Category->delete($_POST['cat_id']);
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
				'category' => $_POST['category']
			];
			$rs = $this->Category->create($params);
			if($rs){
				$this->redirect('category/index');
			}
		}
		$form = new bootstrapForm($_POST);
		$this->render('categories/edit', compact('form'));
	}
	public function edit(){
		$id = $_GET['id'];
		if(!empty($_POST)){
			$rs = $this->Category->update($id, [
				'category' => $_POST['category']
			]);
			if($rs){
				$this->redirect('category/index');
			}
		}
		$category = $this->Category->find($id);
		$form = new bootstrapForm($category);
		$this->render('categories/edit', compact('form'));
	}

}