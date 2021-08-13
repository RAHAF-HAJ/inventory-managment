<?php
namespace App\Controller;

use App;
use Core\HTML\BootstrapForm;
use Core\Upload;
use Core\Restful\RestHandler;


class UserController extends AppController
{
    var $restHandler;
	public function __construct()
	{
		parent::__construct();
		$this->loadModel('User');
		$this->loadModel('Role');
        $this->restHandler = new RestHandler();
	}

	public function index(){
		$users = $this->User->load();
		$form = new bootstrapForm($_POST);

		$this->render('users/index', compact('form', 'users' ));
	}

	public function add(){
		if(!empty($_POST)){
			$avatar = $this->User->max() + 1 . '.jpg';
			$params = [
				'login' => $_POST['login'],
				'pass' => sha1($_POST['login']),
				'email' => $_POST['email'],
				'role_id' => $_POST['role_id'],
				'fname' => $_POST['fname'],
				'lname' => $_POST['lname'],
				'phone' => $_POST['phone'],
				'function' => $_POST['function'],
				'created_by' => $_SESSION['user']->id,
				'updated_by' => $_SESSION['user']->id
			];

			if(isset( $_FILES['avatar']) && ($_FILES['avatar']['error'] == 0)) {
				$params['avatar'] = $avatar;
			}
			$rs = $this->User->create($params);
			if($rs){
				if(isset($_FILES['avatar']) && ($_FILES['avatar']['error'] == 0)) {
					Upload::one(
						$_FILES['avatar'],
						$avatar,
						ROOT.'/public/img/avatar/'
					);
				}
				$this->redirect('user/index');
			}
		}
		$roles = $this->Role->extract('id', 'role_name');
		$form = new bootstrapForm($_POST);
		$this->render('users/edit', compact('form', 'roles'));
	}
	public function edit(){
		$id = $_GET['id'];
		if(!empty($_POST)){
			$avatar = $id . '.jpg';
			$params = [
				'login' => $_POST['login'],
				'pass' => sha1($_POST['login']),
				'email' => $_POST['email'],
				'role_id' => $_POST['role_id'],
                'is_active' => (isset($_POST['is_active'])) ? $_POST['is_active'] : 1,
				'fname' => $_POST['fname'],
				'lname' => $_POST['lname'],
				'phone' => $_POST['phone'],
				'function' => $_POST['function'],
				'updated_by' => $_SESSION['user']->id
			];
			if(isset($_POST['remove_avatar'])){
				$params['avatar'] = '0.jpg';
			}
			elseif(isset( $_FILES['avatar']) && ($_FILES['avatar']['error'] == 0)) {
				$params['avatar'] = $avatar;
			}
			$rs = $this->User->update($id, $params);
			if($rs){
				if(isset($_POST['remove_avatar'])){
					unlink(ROOT.'/public/img/avatar/'.$avatar);
				}
				elseif(isset($_FILES['avatar']) && ($_FILES['avatar']['error'] == 0)) {
					Upload::one(
						$_FILES['avatar'],
						$avatar,
						ROOT.'/public/img/avatar/'
					);
				}
				$this->redirect('user/index');
			}
		}
		$user = $this->User->find($id);
		$roles = $this->Role->extract('id', 'role_name');
		$form = new bootstrapForm($user);
		$this->render('users/edit', compact('form', 'roles', 'user'));
	}
	public function profileedit(){
		$id = $_GET['id'];
		$errors = false;

		if(!empty($_POST)){
			if($_SESSION['user']->pass == sha1($_POST['current_pass'])){
				$avatar = $id . '.jpg';
				$params = [
					'login' => $_POST['login'],
					'pass' => sha1($_POST['new_pass']),
					'email' => $_POST['email'],
					'fname' => $_POST['fname'],
					'lname' => $_POST['lname'],
					'phone' => $_POST['phone'],
					'updated_by' => $_SESSION['user']->id
				];
				if(isset($_POST['remove_avatar'])){
					$params['avatar'] = '0.jpg';
				}
				elseif(isset( $_FILES['avatar']) && ($_FILES['avatar']['error'] == 0)) {
					$params['avatar'] = $avatar;
				}
				$rs = $this->User->update($id, $params);
				if($rs){
					$_SESSION['user']->pass = sha1($_POST['new_pass']);
					if(isset($_POST['remove_avatar'])){
						unlink(ROOT.'/public/img/avatar/'.$avatar);
					}
					elseif(isset($_FILES['avatar']) && ($_FILES['avatar']['error'] == 0)) {
						Upload::one(
							$_FILES['avatar'],
							$avatar,
							ROOT.'/public/img/avatar/'
						);
					}
					$this->redirect('user/index');
				}
			}
			else {
				$errors = true;
			}
		}
		$user = $this->User->find($id);
		$form = new bootstrapForm($user);
		$this->render('users/profileedit', compact('form', 'user', 'errors'));
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
		if(isset($_POST['user_id'])){
			$rs = $this->User->delete($_POST['user_id']);
			if($rs){
				return 1;
			} else {
				return 0;
			}
		}
	}

	public function login(){
	    $rs = null;
        if(!empty($_POST)){
            $login = $_POST['login'];
            $pass = $_POST['pass'];
            $rs = $this->User->login($login, $pass);
        }
        $requestContentType = $_SERVER['HTTP_ACCEPT'];
        if(strpos($requestContentType,'application/json') !== false){
            if(empty($rs)) {
                $statusCode = 401;
                $rs = [
                    'object' => new \stdClass(),
                    'error' => 'Wrong login or password',
                    'code' => 'WRONG_LOGIN_OR_PASS',
                ];
            } else {
                $statusCode = 200;
                $user = $rs;
                $user->token = App\Helpers\JWTHelper::generateJWT($user);
                $rs = [
                    'object' => $user,
                    'error' => '',
                    'code' => '',
                    'session' => $_SESSION
                ];
            }
            $this->restHandler->setHttpHeaders($requestContentType, $statusCode);
            $response = json_encode($rs);
            echo $response;
            exit;
        }
		if(isset($_SESSION['user'])){
			$this->redirect('article/index');
		}
		$errors = false;
		if(!empty($_POST)){
			$login = $_POST['login'];
			$pass = $_POST['pass'];

			$rs = $this->User->login($login, $pass);
		}
        if ($rs){
            $this->redirect('home/index');
        } else {
            $errors = true;
        }
		$form = new bootstrapForm($_POST);
		$this->render('users/login', compact('form', 'errors'));
	}
	public function logout(){
		$_SESSION = array();
		session_destroy();
		unset($_COOKIE['ca_user_id']);
		setcookie('ca_user_id', null, -1, '/');
		$this->redirect('user/login');

	}
	public function profile(){
		$id = $_GET['id'];
		$profile =  $this->User->find($id);
		$this->render('users/profile', compact('profile'));
	}

	public function setactive() {
        $id = $_GET['id'];
        $user = $this->User->find($id);
        $is_active = !$user->is_active;
        $params = [
            'is_active' => $is_active,
        ];
        $rs = $this->User->update($id, $params);
        $this->redirect('user/index');
    }

    public function options() {
        $users = $this->User->all();
        $rs = '';
        foreach($users as $user) {
            $rs .= '<option value="'. $user->id .'">
						'. $user->fname .' '.$user->lname . '
					</option>';
        }
        return $rs;

    }

}