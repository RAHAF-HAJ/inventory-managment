<section class="content-header">
    <span class="content-title"><i class="fa fa-edit"></i>Add new Inventory</span>
</section>
<section class="content">
    <form method="post" name="form-inventory-add" id="form-inventory-add" enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-12">
                <?=  $form->input('name', 'Inventory name', [
                    'type' => 'text',
                    'placeholder' => 'Inventory name',
                    'data-validation' => 'length',
                    'data-validation-length' => '3-255',
                    'data-validation-error-msg' => 'Inventory name length should be between 3 and 255.'
                ]); ?>
                <?=  $form->input('address', 'Address', [
                    'type' => 'text',
                    'placeholder' => 'Address',
                    'data-validation' => 'length',
                    'data-validation-length' => '1-255',
                    'data-validation-error-msg' => 'Address is required'
                ]); ?>
                <input type="hidden" name="selected_manager_id" value="<?=(isset($inventory->manager))? $inventory->manager : ''?>">
                <?=  $form->select('manager', 'Manager', []); ?>


            </div>
            <div class="col-lg-12 form-group text-center">
                <button type="submit" id="btn-save-category" class="btn btn-primary">Save</button>
            </div>
        </div>
    </form>
</section>
