	<section class="content-header">
		<span class="content-title"></i> ٍSuppliers</span>
		<ul class="header-btns">
			<?php if(isset($_SESSION['user']) && $_SESSION['user']->add_suppliers): ?>
			<li>
				<a class="btn btn-block" data-toggle="modal" data-target="#add-modal">
					<i class="fa fa-plus-circle hidden-md hidden-lg"></i>
					<span class="hidden-xs hidden-sm">Add</span>
				</a>
			</li>
            <!-- Modal -->
            <div class="modal fade" id="add-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Add Supplier</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" name="form-supplier-add" id="form-supplier-add" enctype="multipart/form-data" onsubmit="AddSupplier(this);">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <?=  $add_form->input('name', 'Name', [
                                            'type' => 'text',
                                            'placeholder' => 'Supplier name',
                                            'data-validation' => 'length',
                                            'data-validation-length' => '1-255',
                                            'data-validation-error-msg' => 'Supplier name is required'
                                        ]); ?>
                                        <?=  $add_form->input('tel', 'Telephone', [
                                            'type' => 'text',
                                            'placeholder' => 'Telephone',
                                            'data-validation' => 'length',
                                            'data-validation-length' => '1-255',
                                            'data-validation-error-msg' => 'Telephone is required'
                                        ]); ?>
                                        <?=  $add_form->input('email', 'Email', [
                                            'type' => 'text',
                                            'placeholder' => 'Email',
                                            'data-validation' => 'email',
                                            'data-validation-error-msg' => 'Email is required'
                                        ]); ?>
                                        <?=  $add_form->input('zip_code', 'Zip code', [
                                            'type' => 'text',
                                            'placeholder' => 'Zip code',
                                            'data-validation' => 'number',
                                            'data-validation-optional' => 'true',
                                            'data-validation-error-msg' => 'Zip code should be numbers'
                                        ]); ?>
                                        <?=  $add_form->input('city', 'City name', [
                                            'type' => 'text',
                                            'placeholder' => 'City name',
                                            'data-validation' => 'length',
                                            'data-validation-length' => '1-255',
                                            'data-validation-error-msg' => 'City name is required'
                                        ]); ?>
                                        <?=  $add_form->input('address', 'Address', [
                                            'type' => 'text',
                                            'placeholder' => 'Address',
                                            'data-validation' => 'length',
                                            'data-validation-length' => '1-255',
                                            'data-validation-error-msg' => 'Address is required'
                                        ]); ?>
                                    </div>
                                    <div class="col-lg-12 form-group text-center">
                                        <button type="submit" id="btn-save-supplier" class="btn btn-danger btn-lg">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
<!--                        <div class="modal-footer">-->
<!--                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
<!--                            <button type="button" class="btn btn-primary">Save changes</button>-->
<!--                        </div>-->
                    </div>
                </div>
            </div>
			<?php endif; ?>
		</ul>
	</section>
	<section class="content">
		<div class="table-responsive">
			<table class="table main-table data-table table-hover">
			<thead>
			<tr>
				<th>Actions</th>
				<th>ID</th>
				<th>Name</th>
				<th>Mobile</th>
				<th>Email</th>
				<th>Postal Code</th>
				<th>City</th>
				<th>Address</th>
				<th>Is special</th>
			</tr>
			</thead>
			<tbody>
			<?php
			foreach($suppliers as $supplier): ?>
				<tr>
					<td class="table-actions">
				<?php if(isset($_SESSION['user']) && $_SESSION['user']->edit_suppliers): ?>
					<a href="<?= App::$path ?>supplier/edit/<?= $supplier->id ?>" class="btn btn-warning btn-xs">Edit</a>
                <?php endif; ?>
                <?php if(isset($_SESSION['user']) && $_SESSION['user']->delete_suppliers): ?>
                    <a href="#" class="btn btn-danger btn-xs" supplier_id="<?= $supplier->id ?>" onclick="deleteElement(this, event);">Delete</a>
                <?php endif; ?>
                <?php if(isset($_SESSION['user']) && $_SESSION['user']->show_articles): ?>
                    <a href="#" class="btn btn-info btn-xs" supplier_id="<?= $supplier->id ?>" onclick="loadArticles(this, event);">Load articles</a>
                <?php endif; ?>
					</td>
					<td><?= $supplier->id ?></td>
					<td><?= $supplier->name ?></td>
					<td><?= $supplier->tel ?></td>
					<td><?= $supplier->email ?></td>
					<td><?= $supplier->zip_code ?></td>
					<td><?= $supplier->city ?></td>
					<td><?= $supplier->address ?></td>
					<td><?= ($supplier->is_special)? 'Yes'  : 'NO'?></td>

				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		</div>

	</section>

    <div  class="modal fade" id="articles-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document" style="width: 85%;background: #fff;overflow-x: scroll">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Supplier purchased products</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
