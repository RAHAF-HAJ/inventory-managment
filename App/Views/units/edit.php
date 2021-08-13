<section class="content-header">
    <span class="content-title"><i class="fa fa-edit"></i>Add new unit</span>
</section>
<section class="content">
    <form method="post" name="form-unit-add" id="form-unit-add" enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-12">
                <?=  $form->input('unit', 'Unit name', [
                    'type' => 'text',
                    'placeholder' => 'Unit name',
                    'data-validation' => 'length',
                    'data-validation-length' => '1-20',
                    'data-validation-error-msg' => 'Unit name length should be between 1 and 20.'
                ]); ?>

            </div>
            <div class="col-lg-12 form-group text-center">
                <hr>
                <button type="submit" id="btn-save-unit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </form>
</section>
