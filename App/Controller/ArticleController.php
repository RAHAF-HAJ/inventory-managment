<?php
namespace App\Controller;

use Core\HTML\BootstrapForm;
use Core\Upload;


class ArticleController extends AppController
{
	public function __construct()
	{
		parent::__construct();
		$this->loadModel('Article');
		$this->loadModel('Category');
		$this->loadModel('Unit');
		$this->loadModel('Tva');
		$this->loadModel('Supplier');
	}

	public function index(){
		$articles = $this->Article->load();
		$categories = $this->Category->extract('id', 'category');
		$units = $this->Unit->extract('id', 'unit');
		$tva = $this->Tva->extract('tva', 'tva');
		$suppliers = $this->Supplier->extract('id', 'name');
		$form = new bootstrapForm($_POST);

		$this->render('articles/index', compact('form', 'articles', 'categories', 'units', 'tva','suppliers' ));
	}
	public function modal(){

		$articles = $this->Article->load();
		$rs = '';
		foreach($articles as $article) {
			$rs .= '<tr>
						<td class="table-actions">
							<a href="#" class="btn btn-success btn-xs btn-select-supplier" article_id="' . $article->id . '" onclick="selectArticle(this, event);">اختر</a>
						</td>
						<td class="article_id">' . $article->id . '</td>
						<td class="article_ref">' . $article->ref . '</td>
						<td class="article_desig">' . $article->desig . '</td>
						<td>'. $article->unit .'</td>
						<td>'. $article->category .'</td>
						<td>'. $article->tva .'</td>
						<td>'. $article->supplier_name .'</td>

					</tr>';
		}
		return $rs;
	}

	public function options() {
        $articles = $this->Article->all();
        $rs = '';
        foreach($articles as $article) {
            $rs .= '<option value="'. $article->id .'">
						'. $article->desig .'
					</option>';
        }
        return $rs;
    }

	public function printlist(){
		$filter = '';
		if (isset($_SESSION['filter'])) {
			$filter = $_SESSION['filter'];
		}
		$articles = $this->Article->load($filter);

		$this->pdf('articles/printlist', compact('articles'));

	}
	public function search(){
		$filter = '';
		$rs = '';
		if(isset($_POST['ref']))
			$filter .= " AND ref like '%{$_POST['ref']}%'";

		if(isset($_POST['desig']))
			$filter .= " AND desig like '%{$_POST['desig']}%'";

		if(isset($_POST['supplier_id']) && $_POST['supplier_id'] !='')
			$filter .= " AND supplier_id = {$_POST['supplier_id']}";

		if(isset($_POST['category_id']) && $_POST['category_id'] !='')
			$filter .= " AND category_id = {$_POST['category_id']}";

		if(isset($_POST['unit_id']) && $_POST['unit_id'] !='')
			$filter .= " AND unit_id = {$_POST['unit_id']}";

		if(isset($_POST['tva']) && $_POST['tva'] !='')
			$filter .= " AND tva = {$_POST['tva']}";


		$_SESSION['filter'] = $filter;


		$articles = $this->Article->load($filter);

		foreach($articles as $art) {
			$rs .= '<tr>
						<td class="table-actions">
							<a href="" class="btn btn-success btn-xs">View</a>
							<a href="<?= App::$path ?>article/edit/' . $art->id . '" class="btn btn-warning btn-xs">Update</a>
							<a href="#" class="btn btn-danger btn-xs" art_id="' . $art->id . '" onclick="deleteArt(this, event);">Delete</a>
						</td>
						<td>' . $art->id . '</td>
						<td>' . $art->ref . '</td>
						<td>' . $art->desig . '</td>
						<td>' . $art->unit . '</td>
						<td>' . $art->category . '</td>
						<td>' . $art->tva . '</td>
						<td>' . $art->supplier_name . '</td>
					</tr>';
		}
		return $rs;
	}
	public function delete(){
		if(isset($_POST['art_id'])){
			$rs = $this->Article->delete($_POST['art_id']);
			if($rs){
				return 1;
			} else {
				return 0;
			}
		}
	}

	public function add(){
		//var_dump($_POST, $_FILES);
		if(!empty($_POST)){
			$thumb_name = $this->Article->max() + 1 . '.jpg';
			$params = [
				'ref' => $_POST['ref'],
				'desig' => $_POST['desig'],
				'category_id' => $_POST['category_id'],
				'unit_id' => $_POST['unit_id'],
				'tva' => $_POST['tva'],
				'supplier_id' => $_POST['box-infos-id'],
				'created_by' => 1,
				'updated_by' => 1
			];

			if(isset( $_FILES['thumb']) && ($_FILES['thumb']['error'] == 0)) {
				$params['thumb'] = $thumb_name;
			}
			$rs = $this->Article->create($params);
			if($rs){
				if(isset($_FILES['thumb']) && ($_FILES['thumb']['error'] == 0)) {
					Upload::one(
						$_FILES['thumb'],
						$thumb_name,
						ROOT.'/public/img/thumbs/articles/'
					);
				}
				$this->redirect('article/index');
			}
		}
		$categories = $this->Category->extract('id', 'category');
		$units = $this->Unit->extract('id', 'unit');
		$tva = $this->Tva->extract('tva', 'tva');
		$form = new bootstrapForm($_POST);
		$this->render('articles/edit', compact('form', 'categories', 'units', 'tva'));
	}
	public function edit(){
		$id = $_GET['id'];
		if(!empty($_POST) && (!empty($_FILES))){
			$thumb_name = $id . '.jpg';

			$params = [
				'ref' => $_POST['ref'],
				'desig' => $_POST['desig'],
				'category_id' => $_POST['category_id'],
				'unit_id' => $_POST['unit_id'],
				'tva' => $_POST['tva'],
				'supplier_id' => $_POST['box-infos-id'],
				'created_by' => 1,
				'updated_by' => 1
			];
			if(isset( $_FILES['thumb']) && ($_FILES['thumb']['error'] == 0)) {
				$params['thumb'] = $thumb_name;
			}
			$rs = $this->Article->update($id, $params);
			if($rs){
				if(isset($_FILES['thumb']) && ($_FILES['thumb']['error'] == 0)) {
					Upload::one(
						$_FILES['thumb'],
						$thumb_name,
						ROOT.'/public/img/thumbs/articles/'
					);
				}
				$this->redirect('article/index');
			}
		}
		$categories = $this->Category->extract('id', 'category');
		$units = $this->Unit->extract('id', 'unit');
		$tva = $this->Tva->extract('tva', 'tva');
		$article = $this->Article->find($id);
		$form = new bootstrapForm($article);
		$this->render('articles/edit', compact('form', 'article', 'categories', 'units', 'tva'));
	}
	public function show(){
		$id = $_GET['id'];
		$article = $this->Article->find($id);
		$this->render('articles/show', compact('article'));
	}
	public function printinfos(){
		$id = $_GET['id'];
		$article = $this->Article->find($id);
		$this->pdf('articles/printinfos', compact('article'));
	}

}