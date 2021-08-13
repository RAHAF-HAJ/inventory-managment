<?php
namespace App\Controller;


use Core\HTML\BootstrapForm;

class RoleController extends AppController
{
	public function __construct()
	{
		parent::__construct();
		$this->loadModel('Role');
		$this->loadModel('Permission');
		$this->loadModel('RolePermission');
	}

	public function index(){
		$roles = $this->Role->all();
		$this->render('roles/index', compact('roles'));
	}

	public function add(){
		if(!empty($_POST)){
			$params = [
                'show_clients' => $_POST['show_clients'],
                'edit_clients' => $_POST['edit_clients'],
                'add_clients' => $_POST['add_clients'],
                'delete_clients' => $_POST['delete_clients'],

                'show_suppliers' => $_POST['show_suppliers'],
                'add_suppliers' => $_POST['add_suppliers'],
                'edit_suppliers' => $_POST['edit_suppliers'],
                'delete_suppliers' => $_POST['delete_suppliers'],

                'show_sales' => $_POST['show_sales'],
                'add_sales' => $_POST['add_sales'],
                'edit_sales' => $_POST['edit_sales'],
                'delete_sales' => $_POST['delete_sales'],

                'show_purchases' => $_POST['show_purchases'],
                'add_purchases' => $_POST['add_purchases'],
                'edit_purchases' => $_POST['edit_purchases'],
                'delete_purchases' => $_POST['delete_purchases'],

                'show_articles' => $_POST['show_articles'],
                'add_articles' => $_POST['add_articles'],
                'edit_articles' => $_POST['edit_articles'],
                'delete_articles' => $_POST['delete_articles'],

                'show_inventories' => $_POST['show_inventories'],
                'add_inventories' => $_POST['add_inventories'],
                'edit_inventories' => $_POST['edit_inventories'],
                'delete_inventories' => $_POST['delete_inventories'],

                'show_users_roles' => $_POST['show_users_roles'],
                'aed_users_roles' => $_POST['aed_users_roles'],
                'show_inactive_users' =>isset( $_POST['show_inactive_users']) ?  $_POST['show_inactive_users'] : 0,
                'show_logs' => $_POST['show_logs'],
                'sale_all_inventories' =>$_POST['sale_all_inventories'],
			];

			$role_params = [
                'role_name' => $_POST['role_name'],
            ];
			$rs = $this->Role->create($role_params);
			$id = $this->Role->max();
			foreach ($params as $perm_name=>$perm_value) {
			    $perm = $this->Permission->load($perm_name);
			    $role_perm_params = [
			        'role_id' =>$id,
                    'permission_id' => $perm[0]->id,
                    'value' =>$perm_value
                ];
			    $this->RolePermission->create($role_perm_params);
            }
//			exit();

			if($rs){
				$this->redirect('role/index');
			}
		}
		$form = new bootstrapForm($_POST);
		$this->render('roles/edit', compact('form'));
	}
	
	public function edit(){
		$id = $_GET['id'];
		if(!empty($_POST)){
			$params = [
                'show_clients' => $_POST['show_clients'],
                'edit_clients' => $_POST['edit_clients'],
                'add_clients' => $_POST['add_clients'],
                'delete_clients' => $_POST['delete_clients'],

                'show_suppliers' => $_POST['show_suppliers'],
                'add_suppliers' => $_POST['add_suppliers'],
                'edit_suppliers' => $_POST['edit_suppliers'],
                'delete_suppliers' => $_POST['delete_suppliers'],

                'show_sales' => $_POST['show_sales'],
                'add_sales' => $_POST['add_sales'],
                'edit_sales' => $_POST['edit_sales'],
                'delete_sales' => $_POST['delete_sales'],

                'show_purchases' => $_POST['show_purchases'],
                'add_purchases' => $_POST['add_purchases'],
                'edit_purchases' => $_POST['edit_purchases'],
                'delete_purchases' => $_POST['delete_purchases'],

                'show_articles' => $_POST['show_articles'],
                'add_articles' => $_POST['add_articles'],
                'edit_articles' => $_POST['edit_articles'],
                'delete_articles' => $_POST['delete_articles'],

                'show_inventories' => $_POST['show_inventories'],
                'add_inventories' => $_POST['add_inventories'],
                'edit_inventories' => $_POST['edit_inventories'],
                'delete_inventories' => $_POST['delete_inventories'],

                'show_users_roles' => $_POST['show_users_roles'],
                'aed_users_roles' => $_POST['aed_users_roles'],
                'show_inactive_users' =>isset( $_POST['show_inactive_users']) ?  $_POST['show_inactive_users'] : 0,
                'show_logs' => $_POST['show_logs'],
                'sale_all_inventories' =>$_POST['sale_all_inventories'],
            ];
            $role_params = [
                'role_name' => $_POST['role_name'],
            ];
			$rs = $this->Role->update($id, $role_params);
			if($rs){
                foreach ($params as $perm_name=>$perm_value) {
                    $perm = $this->Permission->load($perm_name);
                    $role_perm_params = [
                        'role_id' =>$id,
                        'permission_id' => $perm[0]->id,
                        'value' =>$perm_value
                    ];
                    //Update permission if exists

                    $role_perm_id = $this->RolePermission->load(' role_id = "'. $id .'" AND permission_id = "'. $perm_name .'"');
                    if(empty($role_perm_id)) {
                        $this->RolePermission->create($role_perm_params);
                    }
                    else {
                        $this->RolePermission->update($role_perm_id, $role_perm_params);
                    }
                }
				$this->redirect('role/index');
			}
		}
		$role = $this->Role->find($id);
		$form = new bootstrapForm($role);
		$this->render('roles/edit', compact('form', 'role'));
	}
	
	public function delete(){
		if(isset($_POST['role_id'])){
			$rs = $this->Role->delete($_POST['role_id']);
			if($rs){
				return 1;
			} else {
				return 0;
			}
		}
	}


}