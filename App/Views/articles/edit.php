<?php
    if (isset($article) && isset($_GET['id'])){
        $thumb_name = $article->thumb;
    }
    else{
        $thumb_name = 'no_thumb.jpg';
    }
?>
<section class="content-header">
    <span class="content-title"><i class="fa fa-edit"></i>Add new product</span>
</section>
<section class="content">
    <form method="post" name="form-article-add" id="form-article-add" enctype="multipart/form-data">
        <div class="row form-add-top">
            <div class="col-sm-4 col-xs-12">
                <div class="box-infos-search">
                    <section class="content-header box-infos-header">
                    <span class="content-title"><i class="fa fa-image"></i> Photo</span>
                        <a href="#" class="btn btn-default btn-search" onclick="triggerInputFile('thumb', event);">
                            <i class="fa fa-search"></i>
                        </a>

                    </section>
                    <div class="box-infos text-center">
                        <img class="thumb-preview" src="<?= App::$path ?>img/thumbs/articles/<?= $thumb_name ?>">
                        <a href="#" class="badge thumb-reset" onclick="resetThumb( event);">Reset</a>

                        <?=  $form->file('thumb', [
                            'type' => 'file',
                            'id' => 'thumb',
                            'class' => 'hidden-input-file',
                            'onchange' => 'readUrl(this);',
                            'data-validation' => 'required mime size',
                            'data-validation-allowing' => 'jpg',
                            'data-validation-error-msg' => 'Photo image should be less than 1M'
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <?=  $form->input('ref', 'Product code', [
                    'type' => 'text',
                    'placeholder' => 'Product code',
                    'data-validation' => 'length',
                    'data-validation-length' => 'max100',
                    'data-validation-error-msg' => 'Product code length should be less than 100'
                ]); ?>
                <?=  $form->input('desig', 'Product name', [
                    'type' => 'text',
                    'placeholder' => 'Product name',
                    'data-validation' => 'length',
                    'data-validation-length' => '3-255',
                    'data-validation-error-msg' => 'Product name length should be between 3 and 255'
                ]); ?>

                <?=  $form->select('color', 'Colors', [
                    'red' => 'Red',
                    'blue' => 'Blue',
                    'white' => 'White',
                    'black' => 'Black',
                    'orange' => 'Orange',
                    'green' => 'Green',
                    'purple' => 'Purple'
                ]); ?>
                <?=  $form->select('category_id', 'Category', $categories); ?>
                <?=  $form->select('unit_id', 'Unit', $units); ?>
                <input type="hidden" name="selected_supplier_id" value="<?=($article->supplier_id)? $article->supplier_id : ''?>">
                <?=  $form->select('supplier_id', 'Supplier', []); ?>
                <?=  $form->select('tva', 'TVA (%)', $tva); ?>
            </div>
            <div class="col-lg-12 form-group text-center">
                <button type="submit" id="btn-save-article" class="btn btn-primary">Save</button>
            </div>
        </div>
    </form>
</section>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Suppliers</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table rtl_table data-table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>&nbsp;</th>
                            <th>Name</th>
                            <th>City</th>
                            <th>Address</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
