	<section class="content-header">
		<span class="content-title"><i class="fa fa-home"></i> Clients</span>
		<ul class="header-btns">
			<?php if(isset($_SESSION['user']) && $_SESSION['user']->add_clients): ?>
			<li>
				<a href="<?= App::$path ?>client/add" class="btn btn-block">
					<i class="fa fa-plus-circle"></i>
					<span class="hidden-xs hidden-sm">Add</span>
				</a>
			</li>
			<?php endif; ?>
		</ul>
	</section>
	<section class="content">
		<div class="table-responsive">
			<table class="table main-table rtl_table data-table table-striped table-hover">
			<thead>
			<tr>
				<th>Actions&nbsp</th>
				<th>ID</th>
				<th>Name</th>
				<th>Telephone</th>
				<th>Email</th>
				<th>Zip code</th>
				<th>City</th>
				<th>Address</th>
				<th>Is special</th>
			</tr>
			</thead>
			<tbody>
			<?php
			foreach($clients as $client): ?>
				<tr>
					<td class="table-actions">
				<?php if(isset($_SESSION['user']) && $_SESSION['user']->edit_clients): ?>
					<a href="<?= App::$path ?>client/edit/<?= $client->id ?>" class="btn btn-warning btn-xs">Edit</a>
                <?php endif; ?>
                <?php if(isset($_SESSION['user']) && $_SESSION['user']->delete_clients): ?>
                    <a href="#" class="btn btn-danger btn-xs" client_id="<?= $client->id ?>" onclick="deleteElement(this, event);">Delete</a>
                <?php endif; ?>
                <?php if(isset($_SESSION['user']) && $_SESSION['user']->show_articles): ?>
                    <a href="#" class="btn btn-info btn-xs" client_id="<?= $client->id ?>" onclick="loadArticles(this, event);">Load articles</a>
                <?php endif; ?>
					</td>
					<td><?= $client->id ?></td>
					<td><?= $client->name ?></td>
					<td><?= $client->tel ?></td>
					<td><?= $client->email ?></td>
					<td><?= $client->zip_code ?></td>
					<td><?= $client->city ?></td>
					<td><?= $client->address ?></td>
                    <td><?= ($client->is_special)? 'Yes'  : 'NO'?></td>
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
                    <h5 class="modal-title" id="exampleModalLongTitle">Client Soled products</h5>
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
