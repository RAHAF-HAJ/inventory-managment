
<section class="content-header">
    <span class="content-title"><i class="fa fa-edit"></i>Edit Supplier</span>
</section>
<section class="content">
    <form method="post" name="form-supplier-add" id="form-supplier-add" enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-12">
                <?=  $form->input('name', 'Supplier name', [
                    'type' => 'text',
                    'placeholder' => 'Supplier name',
                    'data-validation' => 'length',
                    'data-validation-length' => '1-255',
                    'data-validation-error-msg' => 'Supplier name is required'
                ]); ?>
                <?=  $form->input('tel', 'Telephone', [
                    'type' => 'text',
                    'placeholder' => 'Telephone',
                    'data-validation' => 'length',
                    'data-validation-length' => '1-255',
                    'data-validation-error-msg' => 'Telephone is required'
                ]); ?>
                <?=  $form->input('email', 'Email', [
                    'type' => 'email',
                    'placeholder' => 'Email',
                    'data-validation' => 'email',
                    'data-validation-error-msg' => 'Email is required'
                ]); ?>
                <?=  $form->input('zip_code', 'Zip code', [
                    'type' => 'text',
                    'placeholder' => 'Zip code',
                    'data-validation' => 'number',
                    'data-validation-optional' => 'true',
                    'data-validation-error-msg' => 'Zip code should be number'
                ]); ?>
                <?=  $form->input('city', 'City name', [
                    'type' => 'text',
                    'placeholder' => 'City name',
                    'data-validation' => 'length',
                    'data-validation-length' => '1-255',
                    'data-validation-error-msg' => 'City name is required'
                ]); ?>
                <?=  $form->input('address', 'Address', [
                    'type' => 'text',
                    'placeholder' => 'Address',
                    'data-validation' => 'length',
                    'data-validation-length' => '1-255',
                    'data-validation-error-msg' => 'Address is required'
                ]); ?>

                <div class="form-group">
                    <label>Is special </label>
                    <select name="is_special" class="form-control"
                            data-validation="required"
                            data-validation-error-msg="Role is required">
                        <?php if(isset($supplier) && ($supplier->is_special)) { ?>
                            <option value="0">No</option>
                            <option value="1" selected>Yes</option>
                        <?php } else { ?>
                            <option value="0" selected>No</option>
                            <option value="1">Yes</option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-12 form-group text-center">
                <hr>
                <button type="submit" id="btn-save-supplier" class="btn btn-primary">Save</button>
            </div>
        </div>
    </form>
</section>
