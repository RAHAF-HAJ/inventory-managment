	<section class="content-header">
		<span class="content-title"><i class="fa fa-home"></i> Categories</span>
		<ul class="header-btns">
			<?php if(isset($_SESSION['user']) && $_SESSION['user']->add_articles): ?>
			<li>
				<a href="<?= App::$path ?>category/add" class="btn btn-success">
					<i class="fa fa-plus-circle"></i>
					<span class="hidden-xs hidden-sm"> Add</span>
				</a>
			</li>
			<?php endif; ?>
			<li>
				<a href="<?= App::$path ?>category/printlist" target="_blank" class="btn btn-default">
					<i class="fa fa-print"></i>
					<span class="hidden-xs hidden-sm"> Print</span>
				</a>
			</li>
		</ul>
	</section>
	<section class="content">
		<div class="table-responsive">
			<table class="table main-table rtl_table data-table table-striped table-hover">
			<tbody>
			<?php
			foreach($categories as $cat): ?>
				<tr>
					<td class="table-actions">
						<?php if(isset($_SESSION['user']) && $_SESSION['user']->edit_articles): ?>
						<a href="<?= App::$path ?>category/edit/<?= $cat->id ?>" class="btn btn-warning btn-xs">Update</a>
						<?php if($cat->id > 0): ?>
						<a href="#" class="btn btn-danger btn-xs" cat_id="<?= $cat->id ?>" onclick="deleteElement(this, event);">Delete</a>
					<?php endif; ?>
					<?php endif; ?>
						</td>
					<td><?= $cat->category ?></td>

				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		</div>

	</section>
