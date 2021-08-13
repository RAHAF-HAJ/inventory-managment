<section class="content-header">
    <span class="content-title"><i class="fa fa-edit"></i> تسجيل الدخول</span>
</section>
<section class="content flex-horiz-center">
    <div class="col-md-4 col-sm-8">
        <?php if($errors): ?>
        <div class="form-error alert alert-danger">
            <span>Username and password are not identical</span>
        </div>
        <?php endif; ?>
        <form method="post" name="form-user-login" id="form-user-login" enctype="multipart/form-data">

        <div class="login-panel panel panel-primary">
            <div class="panel-heading login-header">
                <h1 class="main-color">INVENTORY</h1>
                <h3 class="main-color sub-header-spacing">LOGIN</h3>
            </div>
            <div class="panel-body">
                <?=  $form->input('login', 'USERNAME', [
                    'type' => 'text',
                    'placeholder' => 'Username',
                    'label' => 'Username',
                    'data-validation' => 'custom',
                    'data-validation-regexp' => '^([a-zA-Z0-9]+)$',
                    'data-validation-length' => 'max100',
                    'data-validation-error-msg' => 'Username should be only letters and numbers'
                ]); ?>
                <?=  $form->input('pass', 'PASSWORD', [
                    'type' => 'password',
                    'placeholder' => 'Password',
                    'data-validation' => 'length',
                    'data-validation-length' => '3-255',
                    'data-validation-error-msg' => 'Password should be between 3 and 255'
                ]); ?>
                <div class="form-group"></div>
                <div class="form-group text-center">
                    <?=  $form->submit('btn-user-login', 'LOGIN', [
                        'id' => 'btn-user-login',
                    ]);
                    ?>
                </div>
        </div>
        </div>
        </form>
    </div>

</section>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">الموردين</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table rtl_table data-table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>&nbsp;</th>
                            <th>الإسم</th>
                            <th>المدينة</th>
                            <th>العنوان</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>
