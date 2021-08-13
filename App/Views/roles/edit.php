<?php
    if (isset($_GET['id'])){
        $title = 'Edit role';
    }
    else{
        $title = 'Add new role';

    }
?>
<section class="content-header">
    <span class="content-title"><i class="fa fa-edit"></i> <?= $title ?></span>
</section>
<section class="content">
    <form method="post" name="form-role-add" id="form-role-add" enctype="multipart/form-data">
        <div class="col-sm-12">
            <?= $form->input('role_name', 'Role name',
                [
                    'type' => 'text',
                    'placeholder' => 'Role name',
                    'data-validation' => 'length',
                    'data-validation-length' => '1-100',
                    'data-validation-error-msg' => 'Role name should be between 1 and 100'
                ]
            ); ?>
        </div>
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Clients</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label>View : </label>
                        <select name="show_clients" class="form-control"
                        data-validation="required"
                        data-validation-error-msg="Role is required">
                            <?php if(isset($role) && ($role->show_clients)) { ?>
                                <option value="0">No</option>
                                <option value="1" selected>Yes</option>
                            <?php } else { ?>
                                <option value="0" selected>No</option>
                                <option value="1">Yes</option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Add : </label>
                        <select name="add_clients" class="form-control"
                                data-validation="required"
                                data-validation-error-msg="Role is required">
                            <?php if(isset($role) && ($role->add_clients)) { ?>
                                <option value="0">No</option>
                                <option value="1" selected>Yes</option>
                            <?php } else { ?>
                                <option value="0" selected>No</option>
                                <option value="1">Yes</option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Edit : </label>
                        <select name="edit_clients" class="form-control"
                                data-validation="required"
                                data-validation-error-msg="Role is required">
                            <?php if(isset($role) && ($role->edit_clients)) { ?>
                                <option value="0">No</option>
                                <option value="1" selected>Yes</option>
                            <?php } else { ?>
                                <option value="0" selected>No</option>
                                <option value="1">Yes</option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Delete </label>
                        <select name="delete_clients" class="form-control"
                                data-validation="required"
                                data-validation-error-msg="Role is required">
                            <?php if(isset($role) && ($role->delete_clients)) { ?>
                                <option value="0">No</option>
                                <option value="1" selected>Yes</option>
                            <?php } else { ?>
                                <option value="0" selected>No</option>
                                <option value="1">Yes</option>
                            <?php } ?>
                        </select>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Suppliers</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label>View : </label>
                        <select name="show_suppliers" class="form-control"
                        data-validation="required"
                        data-validation-error-msg="Role name is required">
                            <?php if(isset($role) && ($role->show_suppliers)) { ?>
                                <option value="0">No</option>
                                <option value="1" selected>Yes</option>
                            <?php } else { ?>
                                <option value="0" selected>No</option>
                                <option value="1">Yes</option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Add : </label>
                        <select name="add_suppliers" class="form-control"
                                data-validation="required"
                                data-validation-error-msg="Role is required">
                            <?php if(isset($role) && ($role->add_suppliers)) { ?>
                                <option value="0">No</option>
                                <option value="1" selected>Yes</option>
                            <?php } else { ?>
                                <option value="0" selected>No</option>
                                <option value="1">Yes</option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Edit : </label>
                        <select name="edit_suppliers" class="form-control"
                                data-validation="required"
                                data-validation-error-msg="Role is required">
                            <?php if(isset($role) && ($role->edit_suppliers)) { ?>
                                <option value="0">No</option>
                                <option value="1" selected>Yes</option>
                            <?php } else { ?>
                                <option value="0" selected>No</option>
                                <option value="1">Yes</option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Delete : </label>
                        <select name="delete_suppliers" class="form-control"
                                data-validation="required"
                                data-validation-error-msg="Role is required">
                            <?php if(isset($role) && ($role->delete_suppliers)) { ?>
                                <option value="0">No</option>
                                <option value="1" selected>Yes</option>
                            <?php } else { ?>
                                <option value="0" selected>No</option>
                                <option value="1">Yes</option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Sales</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label>View : </label>
                        <select name="show_sales" class="form-control"
                        data-validation="required"
                        data-validation-error-msg="Role name is required">
                            <?php if(isset($role) && ($role->show_sales)) { ?>
                                <option value="0">No</option>
                                <option value="1" selected>Yes</option>
                            <?php } else { ?>
                                <option value="0" selected>No</option>
                                <option value="1">Yes</option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Add : </label>
                        <select name="add_sales" class="form-control"
                                data-validation="required"
                                data-validation-error-msg="Role is required">
                            <?php if(isset($role) && ($role->add_sales)) { ?>
                                <option value="0">No</option>
                                <option value="1" selected>Yes</option>
                            <?php } else { ?>
                                <option value="0" selected>No</option>
                                <option value="1">Yes</option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Edit : </label>
                        <select name="edit_sales" class="form-control"
                                data-validation="required"
                                data-validation-error-msg="Role is required">
                            <?php if(isset($role) && ($role->edit_sales)) { ?>
                                <option value="0">No</option>
                                <option value="1" selected>Yes</option>
                            <?php } else { ?>
                                <option value="0" selected>No</option>
                                <option value="1">Yes</option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Delete : </label>
                        <select name="delete_sales" class="form-control"
                                data-validation="required"
                                data-validation-error-msg="Role is required">
                            <?php if(isset($role) && ($role->delete_sales)) { ?>
                                <option value="0">No</option>
                                <option value="1" selected>Yes</option>
                            <?php } else { ?>
                                <option value="0" selected>No</option>
                                <option value="1">Yes</option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Purchases</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label>View : </label>
                        <select name="show_purchases" class="form-control"
                                data-validation="required"
                                data-validation-error-msg="Role name is required">
                            <?php if(isset($role) && ($role->show_purchases)) { ?>
                                <option value="0">No</option>
                                <option value="1" selected>Yes</option>
                            <?php } else { ?>
                                <option value="0" selected>No</option>
                                <option value="1">Yes</option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Add : </label>
                        <select name="add_purchases" class="form-control"
                                data-validation="required"
                                data-validation-error-msg="Role is required">
                            <?php if(isset($role) && ($role->add_purchases)) { ?>
                                <option value="0">No</option>
                                <option value="1" selected>Yes</option>
                            <?php } else { ?>
                                <option value="0" selected>No</option>
                                <option value="1">Yes</option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Edit : </label>
                        <select name="edit_purchases" class="form-control"
                                data-validation="required"
                                data-validation-error-msg="Role is required">
                            <?php if(isset($role) && ($role->edit_purchases)) { ?>
                                <option value="0">No</option>
                                <option value="1" selected>Yes</option>
                            <?php } else { ?>
                                <option value="0" selected>No</option>
                                <option value="1">Yes</option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Delete : </label>
                        <select name="delete_purchases" class="form-control"
                                data-validation="required"
                                data-validation-error-msg="Role is required">
                            <?php if(isset($role) && ($role->delete_purchases)) { ?>
                                <option value="0">No</option>
                                <option value="1" selected>Yes</option>
                            <?php } else { ?>
                                <option value="0" selected>No</option>
                                <option value="1">Yes</option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Products</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label>View : </label>
                        <select name="show_articles" class="form-control"
                                data-validation="required"
                                data-validation-error-msg="Role name is required">
                            <?php if(isset($role) && ($role->show_articles)) { ?>
                                <option value="0">No</option>
                                <option value="1" selected>Yes</option>
                            <?php } else { ?>
                                <option value="0" selected>No</option>
                                <option value="1">Yes</option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Add : </label>
                        <select name="add_articles" class="form-control"
                                data-validation="required"
                                data-validation-error-msg="Role is required">
                            <?php if(isset($role) && ($role->add_articles)) { ?>
                                <option value="0">No</option>
                                <option value="1" selected>Yes</option>
                            <?php } else { ?>
                                <option value="0" selected>No</option>
                                <option value="1">Yes</option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Edit : </label>
                        <select name="edit_articles" class="form-control"
                                data-validation="required"
                                data-validation-error-msg="Role is required">
                            <?php if(isset($role) && ($role->edit_articles)) { ?>
                                <option value="0">No</option>
                                <option value="1" selected>Yes</option>
                            <?php } else { ?>
                                <option value="0" selected>No</option>
                                <option value="1">Yes</option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Delete : </label>
                        <select name="delete_articles" class="form-control"
                                data-validation="required"
                                data-validation-error-msg="Role is required">
                            <?php if(isset($role) && ($role->delete_articles)) { ?>
                                <option value="0">No</option>
                                <option value="1" selected>Yes</option>
                            <?php } else { ?>
                                <option value="0" selected>No</option>
                                <option value="1">Yes</option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Inventors</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label>View : </label>
                        <select name="show_inventories" class="form-control"
                                data-validation="required"
                                data-validation-error-msg="Role name is required">
                            <?php if(isset($role) && ($role->show_inventors)) { ?>
                                <option value="0">No</option>
                                <option value="1" selected>Yes</option>
                            <?php } else { ?>
                                <option value="0" selected>No</option>
                                <option value="1">Yes</option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Add : </label>
                        <select name="add_inventories" class="form-control"
                                data-validation="required"
                                data-validation-error-msg="Role is required">
                            <?php if(isset($role) && ($role->add_inventories)) { ?>
                                <option value="0">No</option>
                                <option value="1" selected>Yes</option>
                            <?php } else { ?>
                                <option value="0" selected>No</option>
                                <option value="1">Yes</option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Edit : </label>
                        <select name="edit_inventories" class="form-control"
                                data-validation="required"
                                data-validation-error-msg="Role is required">
                            <?php if(isset($role) && ($role->edit_inventories)) { ?>
                                <option value="0">No</option>
                                <option value="1" selected>Yes</option>
                            <?php } else { ?>
                                <option value="0" selected>No</option>
                                <option value="1">Yes</option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Delete : </label>
                        <select name="delete_inventories" class="form-control"
                                data-validation="required"
                                data-validation-error-msg="Role is required">
                            <?php if(isset($role) && ($role->delete_inventories)) { ?>
                                <option value="0">No</option>
                                <option value="1" selected>Yes</option>
                            <?php } else { ?>
                                <option value="0" selected>No</option>
                                <option value="1">Yes</option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Other permissions</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label>Show inactive users : </label>
                        <select name="show_inactive_users" class="form-control"
                                data-validation="required"
                                data-validation-error-msg="Role name is required">
                            <?php if(isset($role) && ($role->show_inactive_users)) { ?>
                                <option value="0">No</option>
                                <option value="1" selected>Yes</option>
                            <?php } else { ?>
                                <option value="0" selected>No</option>
                                <option value="1">Yes</option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Show Logs page : </label>
                        <select name="show_logs" class="form-control"
                                data-validation="required"
                                data-validation-error-msg="Role name is required">
                            <?php if(isset($role) && ($role->show_logs)) { ?>
                                <option value="0">No</option>
                                <option value="1" selected>Yes</option>
                            <?php } else { ?>
                                <option value="0" selected>No</option>
                                <option value="1">Yes</option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Sell from all inventories : </label>
                        <select name="sale_all_inventories" class="form-control"
                                data-validation="required"
                                data-validation-error-msg="Role name is required">
                            <?php if(isset($role) && ($role->sale_all_inventories)) { ?>
                                <option value="0">No</option>
                                <option value="1" selected>Yes</option>
                            <?php } else { ?>
                                <option value="0" selected>No</option>
                                <option value="1">Yes</option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Users and roles</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label>View : </label>
                        <select name="show_users_roles" class="form-control"
                                data-validation="required"
                                data-validation-error-msg="Role name is required">
                            <?php if(isset($role) && ($role->show_users_roles)) { ?>
                                <option value="0">No</option>
                                <option value="1" selected>Yes</option>
                            <?php } else { ?>
                                <option value="0" selected>No</option>
                                <option value="1">Yes</option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Add, Edit and delete</label>
                        <select name="aed_users_roles" class="form-control"
                                data-validation="required"
                                data-validation-error-msg="Role name is required">
                            <?php if(isset($role) && ($role->aed_users_roles)) { ?>
                                <option value="0">No</option>
                                <option value="1" selected>Yes</option>
                            <?php } else { ?>
                                <option value="0" selected>No</option>
                                <option value="1">Yes</option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 form-group text-center">
            <button id="btn-role-add" name="btn-role-add" class="btn btn-primary">Save</button>
        </div>
    </form>
</section>
