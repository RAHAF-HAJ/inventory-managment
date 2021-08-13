	<section class="content-header">
		<span class="content-title"><i class="fa fa-home"></i> Users</span>
		<ul class="header-btns">
			<?php if(isset($_SESSION['user']) && $_SESSION['user']->aed_users_roles): ?>
			<li>
				<a href="<?= App::$path ?>user/add" class="btn btn-block">
					<i class="fa fa-plus-circle"></i>
					<span class="hidden-xs hidden-sm"> Add</span>
				</a>
			</li>
			<?php endif; ?>
		</ul>
	</section>
	<section class="content">

		<div class="table-responsive">
			<table class="table main-table data-table table-striped table-hover">
            <thead>
                <th>Actions</th>
                <th>Username</th>

                <th>Photo</th>
                <th>Full name</th>
                <th>Job title</th>
                <th>Role</th>
                <th>Telephone</th>
                <th>Email</th>
            </thead>
			<tbody>
			<?php
			foreach($users as $user): ?>
				<tr>
					<td class="table-actions">
				<?php if(isset($_SESSION['user']) && $_SESSION['user']->aed_users_roles): ?>
					<a href="<?= App::$path ?>user/edit/<?= $user->id ?>" class="btn btn-warning btn-xs">Update</a>
					<a href="<?= App::$path ?>user/setactive/<?= $user->id ?>?is_active=<?= (!$user->is_active)? '1' : '0' ?>" class="btn btn-warning btn-xs">
                        <?php
                            if($user->is_active)
                                echo 'Active';
                            else
                                echo 'Deactive';
                        ?>
                    </a>
						<?php if($user->id > 1){ ?>
						<a href="#" class="btn btn-danger btn-xs" user_id="<?= $user->id ?>" onclick="deleteElement(this, event);">Delete</a>
					<?php } else { ?>
							<span class="badge">Admin</span>
					<?php }  ?>
					<?php endif; ?>
                    </td>
                    <td>
                        <?= $user->login ?>
                    </td>
					<td>
						<a href="<?= $user->url ?>">
							<img class="avatar" src="<?= App::$path ?>img/avatar/<?= $user->avatar ?>">
						</a>
					</td>
					<td>
						<a href="<?= App::$path ?>user/profile/<?= $user->id ?>"><?= $user->fname.' '. $user->lname ?></a>
					</td>
					<td>
						<?= $user->function ?>
					</td>
                    <td>
                        <?= $user->role_name ?>
                    </td>
					<td>
						<p><?= $user->phone ?></p>
					</td>
                    <td>
                        <p><?= $user->email ?></p>
                    </td>

				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		</div>

	</section>
