<section class="content-header">
    <span class="content-title"><i class="fa fa-home"></i> Inventories</span>
    <ul class="header-btns">
        <?php if(isset($_SESSION['user']) && $_SESSION['user']->show_inventories): ?>
            <li>
                <a href="<?= App::$path ?>inventory/add" class="btn btn-block">
                    <i class="fa fa-plus-circle"></i>
                    <span class="hidden-xs hidden-sm"> Add</span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</section>
<?php

?>
<section class="content">
    <div class="table-responsive">
        <table class="table main-table rtl_table data-table table-striped table-hover">
            <thead>
                <th>Actions</th>
                <th>Name</th>
                <th>Manager</th>
                <th>Address</th>
            </thead>
            <tbody>
            <?php
            foreach($inventories as $inventory): ?>
                <tr>
                    <td class="table-actions">
                        <?php if(isset($_SESSION['user']) && $_SESSION['user']->edit_inventories): ?>
                            <a href="<?= App::$path ?>inventory/edit/<?= $inventory->id ?>" class="btn btn-warning btn-xs">Edit</a>
                        <?php endif; ?>

                        <?php if(isset($_SESSION['user']) && $_SESSION['user']->delete_inventories): ?>
                            <?php if($inventory->id > 0): ?>
                                <a href="#" class="btn btn-danger btn-xs" inventory_id="<?= $inventory->id ?>" onclick="deleteInventory(this, event);">Delete</a>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if(isset($_SESSION['user']) && $_SESSION['user']->show_articles): ?>
                            <a href="#" class="btn btn-info btn-xs" inventory_id="<?= $inventory->id ?>" onclick="loadArticles(this, event);">Load articles</a>
                        <?php endif; ?>

                    </td>
                    <td><?= $inventory->name ?></td>
                    <td><?= $users[$inventory->manager] ?></td>
                    <td><?= $inventory->address ?></td>

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
                <h5 class="modal-title" id="exampleModalLongTitle">Inventory Products</h5>
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
