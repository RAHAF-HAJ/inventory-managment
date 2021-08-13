	<section class="content-header">
		<span class="content-title"><i class="fa fa-home"></i> Products</span>
		<ul class="header-btns">
			<?php if(isset($_SESSION['user']) && $_SESSION['user']->add_articles): ?>
			<li>
				<a href="<?= App::$path ?>article/add" class="btn btn-block">
					<i class="fa fa-plus-circle"></i>
					<span class="hidden-xs hidden-sm"> Add</span>
				</a>
			</li>
			<?php endif; ?>
			<li>
				<a href="#" class="btn btn-block btn-primary" onclick="searchToogle('form-search-wrap', event);">
					<i class="fa fa-search"></i>
					<span class="hidden-xs hidden-sm">Search</span>
				</a>
			</li>
			<li>
				<a href="<?= App::$path ?>article/printlist" target="_blank" class="btn btn-block btn-default">
					<i class="fa fa-print"></i>
					<span class="hidden-xs hidden-sm">Print</span>
				</a>
			</li>
		</ul>
	</section>
	<section class="content">
		<div class="row form-search-wrap">
			<div class="box-infos-search">
				<section class="content-header box-infos-header">
					<span class="content-title"><i class="fa fa-home"></i> Search</span>
				</section>
				<div class="box-infos">
					<form method="post" name="form-article-search" id="form-article-search">
				<div class="col-md-4 col-sm-6 col-xs-12">
					<?=  $form->input('ref', 'Product code', [
						'type' => 'text',
						'id' => 'ref',
						'placeholder' => 'Product code',
						'data-validation' => 'length',
						'data-validation-optional' => 'true',
						'data-validation-length' => 'max100',
						'data-validation-error-msg' => 'Product code length should be less than 100'
					]); ?>
				</div>
				<div class="col-md-4 col-sm-6 col-xs-12">
					<?=  $form->input('desig', 'Product name', [
						'type' => 'text',
						'id' => 'desig',
						'placeholder' => 'Product name',
						'data-validation' => 'length',
						'data-validation-optional' => 'true',
						'data-validation-length' => '1-255',
						'data-validation-error-msg' => 'Product name should be between 1 and 255.'
					]); ?>
				</div>
				<div class="col-md-4 col-sm-6 col-xs-12">
					<?=  $form->select('supplier_id', 'Supplier', $suppliers, ['id' => 'supplier_id'], true); ?>
				</div>
				<div class="col-md-4 col-sm-6 col-xs-12">
					<?=  $form->select('category_id', 'Category', $categories, ['id' => 'category_id'], true); ?>
				</div>
				<div class="col-md-4 col-sm-6 col-xs-6">
					<?=  $form->select('unit_id', 'Unit', $units, ['id' => 'unit_id'], true); ?>
				</div>
				<div class="col-md-4 col-sm-6 col-xs-6">
					<?=  $form->select('tva', 'TVA (%)', $tva, ['id' => 'tva'], true); ?>
				</div>
				<div class="col-lg-12 form-group text-center">
					<button type="submit" id="btn-search-article" class="btn btn-primary">search</button>
				</div>
			</form>
				</div>
			</div>
		</div>
		<div class="table-responsive">
			<table class="table main-table rtl_table data-table table-striped table-hover">
			<thead>
			<tr>
				<th>Actions&nbsp;</th>
				<th>ID</th>
				<th>Code</th>
				<th>Name</th>
				<th>Unit</th>
				<th>Category</th>
				<th>TVA</th>
				<th>Supplier</th>
				<th>Color</th>
			</tr>
			</thead>
			<tbody>
			<?php
			foreach($articles as $art): ?>
				<tr>
					<td class="table-actions">
						<a href="<?= App::$path ?>article/show/<?= $art->id ?>" class="btn btn-success btn-xs">View</a>
				<?php if(isset($_SESSION['user']) && $_SESSION['user']->edit_articles): ?>
					<a href="<?= App::$path ?>article/edit/<?= $art->id ?>" class="btn btn-warning btn-xs">Update</a>
                <?php endif; ?>
                <?php if(isset($_SESSION['user']) && $_SESSION['user']->delete_articles): ?>
                    <a href="#" class="btn btn-danger btn-xs" art_id="<?= $art->id ?>" onclick="deleteArt(this, event);">Delete</a>
                <?php endif; ?>
					</td>
					<td><?= $art->id ?></td>
					<td><?= $art->ref ?></td>
					<td><?= $art->desig ?></td>
					<td><?= $art->unit ?></td>
					<td><?= $art->category ?></td>
					<td><?= $art->tva ?></td>
					<td><?= $art->supplier_name ?></td>
					<td><?= $art->color ?></td>

				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		</div>

	</section>
