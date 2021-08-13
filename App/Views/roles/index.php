	<section class="content-header">
		<span class="content-title"><i class="fa fa-home"></i>Roles</span>
		<ul class="header-btns">
			<?php if(isset($_SESSION['user']) && $_SESSION['user']->aed_users_roles): ?>
			<li>
				<a href="<?= App::$path ?>role/add" class="btn btn-block">
					<i class="fa fa-plus-circle"></i>
					<span class="hidden-xs hidden-sm"> Add</span>
				</a>
			</li>
			<?php endif; ?>
		</ul>
	</section>
	<section class="content">
		<div class="table-responsive">
			<table class="table main-table rtl_table data-table table-striped table-hover">
			<tbody>
			<?php
			foreach($roles as $role): ?>
				<tr>
					<td class="table-actions">
				<?php if(isset($_SESSION['user']) && $_SESSION['user']->aed_users_roles): ?>
					<a href="<?= App::$path ?>role/edit/<?= $role->id ?>" class="btn btn-warning btn-xs">Update</a>
						<?php if($role->id > 1){ ?>
						<a href="#" class="btn btn-danger btn-xs" role_id="<?= $role->id ?>" onclick="deleteElement(this, event);">Delete</a>
					<?php } else { ?>
							<span class="badge">Admin</span>
					<?php }  ?>
					<?php endif; ?>
					</td>
					<td>
						<h4><?= $role->role_name ?></h4>
					</td>
					<td class="td-roles">
						<p>
							<span>Clients</span>

                            <?php if($role->add_clients){ ?>
                                <span class="fa-roles-true">
								<i class="fa fa-plus-circle"></i>
							</span>
                            <?php } else { ?>
                                <span class="fa-roles-false">
								<i class="fa fa-plus-circle"></i>
							</span>
                            <?php } ?>

                            <?php if($role->edit_clients){ ?>
                                <span class="fa-roles-true">
								<i class="fa fa-edit"></i>
							</span>
                            <?php } else { ?>
                                <span class="fa-roles-false">
								<i class="fa fa-edit"></i>
							</span>
                            <?php } ?>

                            <?php if($role->delete_clients){ ?>
                                <span class="fa-roles-true">
								<i class="fa fa-remove"></i>
							</span>
                            <?php } else { ?>
                                <span class="fa-roles-false">
								<i class="fa fa-remove"></i>
							</span>
                            <?php } ?>

                            <?php if($role->show_clients){ ?>
                                <span class="fa-roles-true">
								<i class="fa fa-eye"></i>
							</span>
                            <?php } else { ?>
                                <span class="fa-roles-false">
								<i class="fa fa-eye"></i>
							</span>
                            <?php } ?>

						</p>
						<p>
							<span>Supplires</span>

                            <?php if($role->add_suppliers){ ?>
                                <span class="fa-roles-true">
								<i class="fa fa-plus-circle"></i>
							</span>
                            <?php } else { ?>
                                <span class="fa-roles-false">
								<i class="fa fa-plus-circle"></i>
							</span>
                            <?php } ?>

                            <?php if($role->edit_suppliers){ ?>
                                <span class="fa-roles-true">
								<i class="fa fa-edit"></i>
							</span>
                            <?php } else { ?>
                                <span class="fa-roles-false">
								<i class="fa fa-edit"></i>
							</span>
                            <?php } ?>

                            <?php if($role->delete_suppliers){ ?>
                                <span class="fa-roles-true">
								<i class="fa fa-remove"></i>
							</span>
                            <?php } else { ?>
                                <span class="fa-roles-false">
								<i class="fa fa-remove"></i>
							</span>
                            <?php } ?>
                            <?php if($role->show_suppliers){ ?>
                                <span class="fa-roles-true">
								<i class="fa fa-eye"></i>
							</span>
                            <?php } else { ?>
                                <span class="fa-roles-false">
								<i class="fa fa-eye"></i>
							</span>
                            <?php } ?>

                        </p>
						<p>
							<span>Sales : </span>
                            <?php if($role->add_sales){ ?>
                                <span class="fa-roles-true">
								<i class="fa fa-plus-circle"></i>
							</span>
                            <?php } else { ?>
                                <span class="fa-roles-false">
								<i class="fa fa-plus-circle"></i>
							</span>
                            <?php } ?>

                            <?php if($role->edit_sales){ ?>
                                <span class="fa-roles-true">
								<i class="fa fa-edit"></i>
							</span>
                            <?php } else { ?>
                                <span class="fa-roles-false">
								<i class="fa fa-edit"></i>
							</span>
                            <?php } ?>

                            <?php if($role->delete_sales){ ?>
                                <span class="fa-roles-true">
								<i class="fa fa-remove"></i>
							</span>
                            <?php } else { ?>
                                <span class="fa-roles-false">
								<i class="fa fa-remove"></i>
							</span>
                            <?php } ?>

                            <?php if($role->show_sales){ ?>
                                <span class="fa-roles-true">
								<i class="fa fa-eye"></i>
							</span>
                            <?php } else { ?>
                                <span class="fa-roles-false">
								<i class="fa fa-eye"></i>
							</span>
                            <?php } ?>
						</p>
						<p>
							<span>Purchases : </span>
                            <?php if($role->add_purchases){ ?>
                                <span class="fa-roles-true">
								<i class="fa fa-plus-circle"></i>
							</span>
                            <?php } else { ?>
                                <span class="fa-roles-false">
								<i class="fa fa-plus-circle"></i>
							</span>
                            <?php } ?>

                            <?php if($role->edit_purchases){ ?>
                                <span class="fa-roles-true">
								<i class="fa fa-edit"></i>
							</span>
                            <?php } else { ?>
                                <span class="fa-roles-false">
								<i class="fa fa-edit"></i>
							</span>
                            <?php } ?>

                            <?php if($role->delete_purchases){ ?>
                                <span class="fa-roles-true">
								<i class="fa fa-remove"></i>
							</span>
                            <?php } else { ?>
                                <span class="fa-roles-false">
								<i class="fa fa-remove"></i>
							</span>
                            <?php } ?>

                            <?php if($role->show_purchases){ ?>
                                <span class="fa-roles-true">
								<i class="fa fa-eye"></i>
							</span>
                            <?php } else { ?>
                                <span class="fa-roles-false">
								<i class="fa fa-eye"></i>
							</span>
                            <?php } ?>
						</p>
						<p>
							<span>Products : </span>

                            <?php if($role->add_articles){ ?>
                                <span class="fa-roles-true">
								<i class="fa fa-plus-circle"></i>
							</span>
                            <?php } else { ?>
                                <span class="fa-roles-false">
								<i class="fa fa-plus-circle"></i>
							</span>
                            <?php } ?>

                            <?php if($role->edit_articles){ ?>
                                <span class="fa-roles-true">
								<i class="fa fa-edit"></i>
							</span>
                            <?php } else { ?>
                                <span class="fa-roles-false">
								<i class="fa fa-edit"></i>
							</span>
                            <?php } ?>

                            <?php if($role->delete_articles){ ?>
                                <span class="fa-roles-true">
								<i class="fa fa-remove"></i>
							</span>
                            <?php } else { ?>
                                <span class="fa-roles-false">
								<i class="fa fa-remove"></i>
							</span>
                            <?php } ?>

                            <?php if($role->show_articles){ ?>
                                <span class="fa-roles-true">
								<i class="fa fa-eye"></i>
							</span>
                            <?php } else { ?>
                                <span class="fa-roles-false">
								<i class="fa fa-eye"></i>
							</span>
                            <?php } ?>

                        </p>
						<p>
							<span>Inventories : </span>
                            <?php if($role->add_inventories){ ?>
                                <span class="fa-roles-true">
								<i class="fa fa-plus-circle"></i>
							</span>
                            <?php } else { ?>
                                <span class="fa-roles-false">
								<i class="fa fa-plus-circle"></i>
							</span>
                            <?php } ?>

                            <?php if($role->edit_inventories){ ?>
                                <span class="fa-roles-true">
								<i class="fa fa-edit"></i>
							</span>
                            <?php } else { ?>
                                <span class="fa-roles-false">
								<i class="fa fa-edit"></i>
							</span>
                            <?php } ?>

                            <?php if($role->delete_inventories){ ?>
                                <span class="fa-roles-true">
								<i class="fa fa-remove"></i>
							</span>
                            <?php } else { ?>
                                <span class="fa-roles-false">
								<i class="fa fa-remove"></i>
							</span>
                            <?php } ?>

                            <?php if($role->show_inventories){ ?>
                                <span class="fa-roles-true">
								<i class="fa fa-eye"></i>
							</span>
                            <?php } else { ?>
                                <span class="fa-roles-false">
								<i class="fa fa-eye"></i>
							</span>
                            <?php } ?>

                        </p>
						<p>
							<span>Users and roles</span>
							<?php if($role->aed_users_roles){ ?>
								<span class="fa-roles-true">
								<i class="fa fa-plus-circle" title="Adding permission"></i>
								<i class="fa fa-edit"></i>
								<i class="fa fa-remove"></i>
							</span>
							<?php } else { ?>
								<span class="fa-roles-false">
								<i class="fa fa-plus-circle"></i>
								<i class="fa fa-edit"></i>
								<i class="fa fa-remove"></i>
							</span>
							<?php } ?>

							<?php if($role->show_users_roles){ ?>
								<span class="fa-roles-true">
								<i class="fa fa-eye"></i>
							</span>
							<?php } else { ?>
								<span class="fa-roles-false">
								<i class="fa fa-eye"></i>
							</span>
							<?php } ?>
						</p>
					</td>

				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		</div>

	</section>
