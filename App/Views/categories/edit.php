<section class="content-header">
    <span class="content-title"><i class="fa fa-edit"></i>Add new category</span>
</section>
<section class="content">
    <form method="post" name="form-category-add" id="form-category-add" enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-12">
                <?=  $form->input('category', 'Category name', [
                    'type' => 'text',
                    'placeholder' => 'Category name',
                    'data-validation' => 'length',
                    'data-validation-length' => '3-255',
                    'data-validation-error-msg' => 'Category name length should be between 3 and 255.'
                ]); ?>

            </div>
            <div class="col-lg-12 form-group text-center">
                <button type="submit" id="btn-save-category" class="btn btn-primary">Save</button>
            </div>
        </div>
    </form>
</section>
