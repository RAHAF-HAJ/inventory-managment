
<section class="content-header">
    <span class="content-title"><i class="fa fa-edit"></i>Profile edit</span>
</section>
<section class="content">
    <?php if($errors): ?>
        <div class="form-error alert alert-danger">
            <span>Username and password are not identical</span>
        </div>
    <?php endif; ?>

    <form method="post" name="form-profile-edit" id="form-profile-edit" enctype="multipart/form-data">

        <div class="col-sm-9">
            <?= $form->input('login', 'User name',
                [
                    'type' => 'text',
                    'id' => 'login',
                    'autofocus' => 'autofocus',
                    'placeholder' => 'User name',
                    'data-validation' => 'custom',
                    'data-validation-regexp' => '^([a-zA-Z0-9]+)$',
                    'data-validation-length' => '2-50',
                    'data-validation-error-msg' => 'Username should be between 2 and 50.'
                ]
            ); ?>
            <?= $form->input('email', 'Email',
                [
                    'type' => 'text',
                    'placeholder' => 'Email',
                    'data-validation' => 'email',
                    'data-validation-optional' => 'true',
                    'data-validation-error-msg' => 'Email is invalid'
                ]
            ); ?>
            <?= $form->input('fname', 'First name',
                [
                    'type' => 'text',
                    'placeholder' => 'First name',
                    'data-validation' => 'length',
                    'data-validation-length' => '2-50',
                    'data-validation-error-msg' => 'First name should be between 2 and 50.'
                ]
            ); ?>
            <?= $form->input('lname', 'Last name',
                [
                    'type' => 'text',
                    'placeholder' => 'Last name',
                    'data-validation' => 'length',
                    'data-validation-length' => '2-50',
                    'data-validation-error-msg' => 'Last name should be between 2 and 50.'
                ]
            ); ?>
            <?= $form->input('phone', 'Telephone',
                [
                    'type' => 'text',
                    'placeholder' => 'Telephone',
                    'data-validation' => 'length',
                    'data-validation-length' => '2-50',
                    'data-validation-optional' => 'true',
                    'data-validation-error-msg' => 'Telephone is invalid'
                ]
            ); ?>
            <hr>
            <?= $form->input('current_pass', 'Current password',
                [
                    'type' => 'password',
                    'id' => 'current_pass',
                    'placeholder' => 'Current password',
                    'data-validation' => 'length',
                    'data-validation-length' => '3-100',
                    'data-validation-error-msg' => 'Password length should be between 3 and 100.'
                ]
            ); ?>
            <?= $form->input('new_pass_confirmation', 'New password',
                [
                    'type' => 'password',
                    'id' => 'new_pass_confirmation',
                    'placeholder' => 'New password',
                    'data-validation' => 'length',
                    'data-validation-length' => '3-100',
                    'data-validation-error-msg' => 'Password length should be between 3 and 100.'
                ]
            ); ?>
            <?= $form->input('new_pass', 'Confirm password',
                [
                    'type' => 'password',
                    'id' => 'new_pass',
                    'placeholder' => 'Confirm password',
                    'data-validation' => 'confirmation',
                    'data-validation-error-msg' => 'Passwords are not identical'
                ]
            ); ?>

        </div>
        <div class="col-sm-3">
            <div class="box-infos-search">
                <section class="content-header box-infos-header">
                    <span class="content-title"><i class="fa fa-image"></i> Photo</span>
                    <a href="#" class="btn btn-default btn-search" onclick="triggerInputFile('avatar', event);">
                        <i class="fa fa-search"></i>
                    </a>

                </section>
                <div class="box-infos text-center">
                    <img class="thumb-preview" src="img/avatar/<?= isset($user) ? $user->avatar : '0.jpg' ?>">
                    <a href="#" class="badge thumb-reset" <?php
                    if(isset($user) && ($user->avatar != '0.jpg')) {
                        echo 'style="display: inline-block;"';
                    }
                    ?> onclick="resetAvatar(this,  event);">Reset</a>

                    <?=  $form->file('avatar', [
                        'type' => 'file',
                        'id' => 'avatar',
                        'class' => 'hidden-input-file',
                        'onchange' => 'readUrl(this);',
                        'data-validation' => 'required mime size',
                        'data-validation-allowing' => 'jpg',
                        'data-validation-error-msg' => 'Photo image should be less than 1M'
                    ]); ?>
                </div>
            </div>

        </div>
        <div class="col-lg-12 form-group text-center">
            <hr>
            <button id="btn-profile-edit" name="btn-profile-edit" class="btn btn-primary">Save</button>
        </div>
    </form>
</section>
