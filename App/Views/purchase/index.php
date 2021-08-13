<section class="content-header">
    <span class="content-title"><i class="fa fa-home"></i> Purchases</span>
    <ul class="header-btns">
        <?php if(isset($_SESSION['user']) && $_SESSION['user']->add_purchases): ?>
            <li>
                <a href="<?= App::$path ?>purchase/add" class="btn btn-block">
                    <i class="fa fa-plus-circle"></i>
                    <span class="hidden-xs hidden-sm"> Add</span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</section>
<?php
function strip_tags_content($string) {
    // ----- remove HTML TAGs -----
    $string = preg_replace ('/<[^>]*>/', ' ', $string);
    // ----- remove control characters -----
    $string = str_replace("\r", '', $string);
    $string = str_replace("\n", ' ', $string);
    $string = str_replace("\t", ' ', $string);
    // ----- remove multiple spaces -----
    $string = trim(preg_replace('/ {2,}/', ' ', $string));
    return $string;

}
?>
<section class="content">
    <div class="table-responsive">
        <table class="table main-table rtl_table data-table table-striped table-hover">
            <thead>
            <th>Actions</th>
            <th>Company name</th>
            <th>Car number</th>
            <th>Supplier</th>
            <th>Date</th>
            </thead>
            <tbody>
            <?php
            foreach($purchases as $purchase): ?>
                <tr>
                    <td class="table-actions">
                        <?php if(isset($_SESSION['user']) && $_SESSION['user']->edit_purchases): ?>
                            <a href="<?= App::$path ?>purchase/edit/<?= $purchase->id ?>" class="btn btn-warning btn-xs">Edit</a>
                        <?php endif; ?>

                        <?php if(isset($_SESSION['user']) && $_SESSION['user']->delete_purchases): ?>
                            <?php if($purchase->id > 0): ?>
                                <a href="#" class="btn btn-danger btn-xs" purchase_id="<?= $purchase->id ?>" onclick="deletePureshase(this, event);">Delete</a>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if(isset($_SESSION['user']) && $_SESSION['user']->show_articles): ?>
                            <a href="#" class="btn btn-info btn-xs" purchase_id="<?= $purchase->id ?>" onclick="loadArticles(this, event);">Load articles</a>
                        <?php endif; ?>
                    </td>
                    <td><?= $purchase->company_name ?></td>
                    <td><?= $purchase->car_number ?></td>
                    <td><a href="<?= App::$path ?>supplier/edit/<?= $purchase->supplier_id ?>"> <?= $suppliers[$purchase->supplier_id] ?></a>
                    </td>
                    <td><?= $purchase->date ?></td>

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
                <h5 class="modal-title" id="exampleModalLongTitle">Purchase Products</h5>
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
