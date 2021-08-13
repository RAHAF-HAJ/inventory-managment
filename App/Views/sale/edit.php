<?php
$thumb_name = 'no_thumb.jpg';
?>
<section class="content-header">
    <span class="content-title"><i class="fa fa-edit"></i>Add new Sale</span>
</section>
<section class="content">
    <form method="post" name="form-pureshase-add" id="form-sale-add" enctype="multipart/form-data">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3>Products</h3>
                        <h6><span class="fa fa-info-circle"></span>Choose the inventory to display the available products.</h6>
                    </div>
                    <div class="panel-body">
                        <?php if(empty($items)): ?>
                        <div class="form-group item" index="0">
                            <input type="hidden" name="id[]" value="">
                            <input type="hidden" name="selected_article_id[]" value="">
                            <input type="hidden" name="selected_inventory_id[]" value="">
                            <?=  $form->select('inventory_id[]', 'Inventory', [],
                                [
                                     'onchange' => "loadAvailableArticles(this, event);",
                                    'data-validation' => 'required',
                                    'data-validation-error-msg' => 'Inventory is required'
                                ]
                            ); ?>

                            <?=  $form->select('article_id[]', 'Product', [],
                                [
                                    'data-validation' => 'required',
                                    'onchange' => "addProductConstrains(this, event);",
                                    'data-validation-error-msg' => 'Product is required'
                                ]
                            ); ?>

                            <?=  $form->input('qty[]', 'Quantity', [
                                'type' => 'number',
                                'placeholder' => 'Quantity',
                                'data-validation' => 'number',
                                'data-validation-optional' => 'required',
                                'data-validation-error-msg' => 'Quantity is required'
                            ]); ?>

                            <?=  $form->input('discount[]', 'Item discount(%)', [
                                'type' => 'number',
                                'placeholder' => 'Item discount(%)',
                                'data-validation' => 'number',
                                'data-validation-optional' => 'true',
                            ]); ?>

                            <?=  $form->input('price[]', 'Price(IQD)', [
                                'type' => 'number',
                                'oninput' => 'calcUSD(this, event)',
                                'placeholder' => 'Price(IQD)',
                                'data-validation' => 'number',
                                'data-validation-optional' => 'required',
                                'data-validation-error-msg' => 'Price is required'
                            ]); ?>
                            <?=  $form->input('price_usd[]', 'Price(USD)', [
                                'type' => 'number',
                                'disabled' => 'disabled',
                                'placeholder' => 'Price(USD)',
                            ]); ?>


                            
                        <hr>
                        </div>
                        <?php endif; ?>
                        <?php if(!empty($items)): ?>
                        <?php foreach($items as $key => $item):

                                ?>

                            <div class="form-group item" data-id="<?=$item->id?>" index="<?=$key?>">
                                <input type="hidden" name="selected_inventory_id[]" value="<?=$item->inventory_id?>">
                                <?=  $form->select('inventory_id[]', 'Inventory', [],
                                    [
                                        'onchange' => "loadAvailableArticles(this, event);",
                                        'data-validation' => 'required',
                                        'data-validation-error-msg' => 'Inventory is required'
                                    ]
                                ); ?>


                                <input type="hidden" name="id[]" value="<?=$item->id?>">
                                <input type="hidden" name="selected_article_id[]" value="<?=$item->article_id?>">

                                <div class="form-group">
                                    <label>Product</label>
                                    <select name="article_id[]"
                                          onchange="addProductConstrains(this, event);"
                                          data-validation="required"
                                          data-validation-error-msg="Product is required"
                                          class="form-control previous-added">
                                        <?php
                                        if(isset($inventory_products)){
                                            foreach ($inventory_products as $product) {
                                                if($product->inventory_id == $item->inventory_id) {
                                                    $selected = ($product->article_id == $item->article_id)? 'selected="selected"' : '';
                                                    echo '<option '. $selected .' data-price="'. $product->purchase_maximum_price .'"  data-qty="' . $product->remaining_qty .'" ' .' value="'. $product->article_id .'">'. $product->desig .'</option>';
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <?=  $form->input('qty[]', 'Quantity', [
                                    'type' => 'number',
                                    'placeholder' => 'Quantity',
                                    'data-validation' => 'number',
                                    'data-validation-optional' => 'required',
                                    'data-validation-error-msg' => 'Quantity is required'
                                ], $item->qty); ?>

                                <?=  $form->input('discount[]', 'Item discount(%)', [
                                    'type' => 'number',
                                    'placeholder' => 'Item discount(%)',
                                    'data-validation' => 'number',
                                    'data-validation-optional' => 'true',
                                ], $item->discount); ?>

                                <?=  $form->input('price[]', 'Price(IQD)', [
                                    'type' => 'number',
                                    'placeholder' => 'Price(IQD)',
                                    'oninput' => 'calcUSD(this, event)',
                                    'data-validation' => 'number',
                                    'data-validation-optional' => 'required',
                                    'data-validation-error-msg' => 'Price is required'
                                ],$item->price); ?>

                                <?=  $form->input('price_usd[]', 'Price(USD)', [
                                    'type' => 'number',
                                    'disabled' => 'disabled',
                                    'placeholder' => 'Price(USD)',
                                ], round($item->price * 0.00084)); ?>
                                
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
                <?=  $form->input('number', 'Sale number', [
                    'type' => 'number',
                    'placeholder' => 'Sale number',
                    'data-validation' => 'number',
                    'data-validation-optional' => 'required',
                    'data-validation-error-msg' => 'Sale number is required'
                ]); ?>

                <div class="form-group">
                    <label for="dtp_input2" class="">Date:</label>
                    <div class="main-color">
                        <div class="input-group date form_date col-md-12" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                            <input data-validation="date" data-validation-format="yyyy-mm-dd" data-validation-error-msg="Please make date with the format of dd-mm-yyyy" class="form-control" size="16" type="text" value="<?= (isset($sale->date)? $sale->date : '') ?>" readonly name="date" >
                            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        </div>
                        <input type="hidden" id="dtp_input2" value="" /><br/>
                    </div>
                </div>

                <input type="hidden" name="selected_client_id" value="<?=(isset($sale->client_id))? $sale->client_id : ''?>">
                <?=  $form->select('client_id', 'Client', [],
                    [
                        'data-validation' => 'required',
                        'data-validation-error-msg' => 'Client is required'
                    ]
                ); ?>

                <?=  $form->input('client_discount', 'Client discount(%)', [
                    'type' => 'number',
                    'placeholder' => 'Client discount(%)',
                    'data-validation' => 'number',
                    'data-validation-optional' => 'true',
                ], (isset($sale->discount)? $sale->discount : '')); ?>

                <?=  $form->textarea('subject', 'Subject', [
                    'type' => 'textarea',
                    'id' => 'subject',
                    'placeholder' => 'Subject',
                    'data-validation' => 'length',
                    'data-validation-length' => 'max255',
                    'data-validation-optional' => 'true',
                    'data-validation-error-msg' => 'Subject length should be less than 255'
                ]); ?>

                <?=  $form->textarea('note', 'Note', [
                    'type' => 'textarea',
                    'id' => 'note',
                    'placeholder' => 'Note',
                    'data-validation' => 'length',
                    'data-validation-length' => 'max255',
                    'data-validation-optional' => 'true',
                    'data-validation-error-msg' => 'Note length should be less than 255'
                ]); ?>

            </div>
            <div class="col-lg-12 form-group text-center">
                <button type="submit" id="btn-save-category" class="btn btn-primary">Save</button>
            </div>
        </div>
    </form>
</section>
