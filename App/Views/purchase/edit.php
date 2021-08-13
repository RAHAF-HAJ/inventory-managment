<?php
$thumb_name = 'no_thumb.jpg';

?>
<section class="content-header">
    <span class="content-title"><i class="fa fa-edit"></i>Add new Purchase</span>
</section>
<section class="content">
    <form method="post" name="form-pureshase-add" id="form-pureshase-add" enctype="multipart/form-data">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3>Products</h3>
                    </div>
                    <div class="panel-body">
                        <?php if(empty($items)): ?>
                        <div class="form-group item" index="0">
                            <input type="hidden" name="id[]" value="">
                            <input type="hidden" name="selected_article_id[]" value="">
                            <?=  $form->select('article_id[]', 'Product', [],
                                [
                                    'data-validation' => 'required',
                                    'data-validation-error-msg' => 'Product is required'
                                ]
                            ); ?>

                            <input type="hidden" name="selected_inventory_id[]" value="">
                            <?=  $form->select('inventory_id[]', 'Inventory', [],
                                [
                                    'data-validation' => 'required',
                                    'data-validation-error-msg' => 'Inventory is required'
                                ]
                            ); ?>

                            <?=  $form->input('qty[]', 'Quantity', [
                                'type' => 'number',
                                'placeholder' => 'Quantity',
                                'data-validation' => 'number',
                                'data-validation-optional' => 'false',
                                'data-validation-error-msg' => 'Quantity is required'
                            ]); ?>

                            <?=  $form->input('price[]', 'Price(IQD)', [
                                'type' => 'number',
                                'placeholder' => 'Price(IQD)',
                                'data-validation' => 'number',
                                'data-validation-optional' => 'false',
                                'data-validation-error-msg' => 'Price is required'
                            ]); ?>

                            <div class="form-group expire">
                                <label for="dtp_input0" class="">Expiry date:</label>
                                <div class="main-color">
                                    <div class="input-group date form_date col-md-12" data-link-field="dtp_input0" data-link-format="yyyy-mm-dd">
                                        <input class="form-control" size="16" type="text" value="" readonly name="expire[]" required>
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                    </div>
                                    <input type="hidden" id="dtp_input0" value="" /><br/>
                                </div>
                            </div>
                            <div class="files">

                            </div>

                            <div style="clear: both"><button class="clone-file" data-id="0" onclick="generateUploadFiles(this, event)">Add image</button></div>
                        <hr>
                        </div>
                        <?php endif; ?>

                        <?php if(!empty($items)): ?>
                        <?php foreach($items as $key => $item):
                            ?>

                            <div class="form-group item" data-id="<?=$item->id?>" index="<?=$key?>">
                                <input type="hidden" name="id[]" value="<?=$item->id?>">
                                <input type="hidden" name="selected_article_id[]" value="<?=$item->article_id?>">
                                <?php
                                    if($item->remaining_qty < $item->qty) {
                                        echo "<p><span class='fa fa-info-circle'></span>A sale order has been created from this item, You wont be allowed to edit it to maintain data consistency!</p>";
                                    }
                                ?>
                                <?=  $form->select('article_id[]', 'Product', [],
                                    [
                                        ($item->remaining_qty < $item->qty) ? 'disabled' : 'edit' => ($item->remaining_qty < $item->qty) ? 'disabled' : 'true',
                                        'data-validation' => 'required',
                                        'data-validation-error-msg' => 'Product is required'
                                    ]
                                ); ?>

                                <input type="hidden" name="selected_inventory_id[]" value="<?=$item->inventory_id?>">
                                <?=  $form->select('inventory_id[]', 'Inventory', [],
                                    [
                                        ($item->remaining_qty < $item->qty) ? 'disabled' : 'edit' => ($item->remaining_qty < $item->qty) ? 'disabled' : 'true',
                                        'data-validation' => 'required',
                                        'data-validation-error-msg' => 'Inventory is required'
                                    ]
                                ); ?>
                                <?php
                                if($item->remaining_qty > $item->qty) {
                                    echo "<p><span class='fa fa-info-circle'></span>The maximum remaining quantity is ". $item->remaining_qty .", Please note that you can't put higher than this number</p>";
                                }
                                ?>
                                <?=  $form->input('qty[]', 'Quantity', [
                                    'type' => 'number',
                                    ($item->remaining_qty < $item->qty) ? 'disabled' : 'edit' => ($item->remaining_qty < $item->qty) ? 'disabled' : 'true',
                                    ($item->remaining_qty >= $item->qty) ? 'max' : 'edit' => ($item->remaining_qty >= $item->qty) ? $item->remaining_qty : 'true',
                                    'placeholder' => 'Quantity',
                                    'data-validation' => 'number',
                                    'data-validation-optional' => 'required',
                                    'data-validation-error-msg' => 'Quantity is required'
                                ], $item->qty); ?>

                                <?=  $form->input('price[]', 'Price(IQD)', [
                                    'type' => 'number',
                                    ($item->remaining_qty < $item->qty) ? 'disabled' : 'edit' => ($item->remaining_qty < $item->qty) ? 'disabled' : 'true',
                                    'placeholder' => 'Price(IQD)',
                                    'data-validation' => 'number',
                                    'data-validation-optional' => 'required',
                                    'data-validation-error-msg' => 'Price is required'
                                ],$item->price); ?>

                                <div class="form-group expire">
                                    <label for="dtp_input<?=$key?>" class="">Expiry date:</label>
                                    <div class="main-color">
                                        <div class="input-group date form_date col-md-12" data-link-field="dtp_input<?=$key?>" data-link-format="yyyy-mm-dd">
                                            <input class="form-control" size="16" type="text" value="<?=(isset($item->expire)) ? $item->expire : ''?>" readonly name="expire[]" required>
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                        </div>
                                        <input type="hidden" id="dtp_input<?=$key?>" value="" /><br/>
                                    </div>
                                </div>
                                <div class="files">
                                    <?php
                                        if(!empty($item->thumb)) {
                                            $thumbs = unserialize($item->thumb);
                                            foreach ($thumbs as $k => $thumb) {
                                                $file_id = (string)$key . (string)$k;
                                                ?>
                                                <div class="col-sm-2 col-xs-12 upload-file" data-id="">
                                                    <div class="box-infos-search">
                                                        <section class="content-header box-infos-header">
                                                            <span class="content-title"><i class="fa fa-image"></i> Photo</span>
                                                            <a href="#" class="btn btn-default btn-search" onclick="triggerInputFile('thumb<?=$file_id?>', event);">
                                                                <i class="fa fa-search"></i>
                                                            </a>
                                                        </section>
                                                        <div class="box-infos text-center">
                                                            <img class="thumb-preview" src="<?= App::$path ?>img/thumbs/purchase/<?= $thumb?>">
                                                            <a href="#" class="badge thumb-reset" onclick="resetThumb( event);">Reset</a>

                                                            <?=  $form->file('thumb['. $key .'][]', [
                                                                'type' => 'file',
                                                                'id' => 'thumb' . $file_id,
                                                                'class' => 'hidden-input-file',
                                                                'onchange' => 'readUrlToPreview(this);',
                                                                'data-validation' => 'mime size',
                                                                'data-validation-allowing' => 'jpg',
                                                                'data-validation-error-msg' => 'Photo image should be less than 1M'
                                                            ]); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                    ?>
                                </div>

                                <div style="clear: both"><button class="clone-file" data-id="<?=count($thumbs)?>" onclick="generateUploadFiles(this, event)">Add image</button></div>
                                <hr>
                            </div>
                        <?php endforeach; ?>
                        <?php endif; ?>

                        <div class="row">
                            <div class="col-sm-2" style="float: right; clear: both">
                                <button class="btn btn-block" id="clone" target=".item">Add item</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <?=  $form->input('company_name', 'Company name', [
                    'type' => 'text',
                    'placeholder' => 'Company name',
                    'data-validation' => 'length',
                    'data-validation-length' => '3-255',
                    'data-validation-error-msg' => 'Company name length should be between 3 and 255.'
                ]); ?>

                <?=  $form->input('car_number', 'Car number', [
                    'type' => 'text',
                    'placeholder' => 'Car number',
                    'data-validation' => 'length',
                    'data-validation-length' => '3-255',
                    'data-validation-error-msg' => 'Car number length should be between 3 and 255.'
                ]); ?>

                <div class="form-group">
                    <label for="dtp_input2" class="">Date:</label>
                    <div class="main-color">
                        <div class="input-group date form_date col-md-12" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                            <input data-validation="date" data-validation-format="yyyy-mm-dd" data-validation-error-msg="Please make date with the format of dd-mm-yyyy" class="form-control" size="16" type="text" value="<?= (isset($purchase->date))? $purchase->date : '' ?>" readonly name="date" required>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                        <input type="hidden" id="dtp_input2" value="" /><br/>
                    </div>
                </div>

                <input type="hidden" name="selected_supplier_id" value="<?=(isset($purchase->supplier_id))? $purchase->supplier_id : ''?>">
                <?=  $form->select('supplier_id', 'Supplier', [],
                    [
                        'data-validation' => 'required',
                        'data-validation-error-msg' => 'Supplier is required'
                    ]
                ); ?>

                <?=  $form->textarea('subject', 'Subject', [
                    'type' => 'text',
                    'placeholder' => 'Subject',
                    'id' => 'subject',
                    'data-validation' => 'length',
                    'data-validation-length' => 'max255',
                    'data-validation-optional' => 'true',
                    'data-validation-error-msg' => 'Subject length should be less than 255'
                ]); ?>

                <?=  $form->textarea('note', 'Note', [
                    'type' => 'text',
                    'placeholder' => 'Note',
                    'id' => 'note',
                    'data-validation' => 'length',
                    'data-validation-length' => 'max255',
                    'data-validation-error-msg' => 'Note length should be less than 255'
                ]); ?>

            </div>
            <div class="col-lg-12 form-group text-center">
                <button type="submit" id="btn-save-category" class="btn btn-primary">Save</button>
            </div>
        </div>
    </form>
</section>
<?php


