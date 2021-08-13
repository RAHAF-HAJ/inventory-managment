<?php
    if (isset($_GET['id'])){
        $title = 'Edit user';
    }
    else{
        $title = 'Add a new user';

    }
?>
<section class="content-header">
    <span class="content-title"><i class="fa fa-edit"></i> <?= $title ?></span>
</section>
<section class="content">
    <form method="post" name="form-user-add" id="form-user-add" enctype="multipart/form-data">
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
                    'data-validation-error-msg' => 'User name length should be between 2 and 50.'
                ]
            ); ?>
            <p>Default password</p>
            <p id="default-pwd" class="form-control"></p>
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
                    'data-validation-error-msg' => 'First name length should be between 2 and 50.'
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
            <?= $form->input('function', 'Job title',
                [
                    'type' => 'text',
                    'placeholder' => 'Job title',
                    'data-validation' => 'length',
                    'data-validation-length' => '1-100',
                    'data-validation-optional' => 'true',
                    'data-validation-error-msg' => 'Job title length should be between 2 and 50.'
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
            <?= $form->select('role_id', 'Role', $roles,
                [
                    'data-validation' => 'required',
                    'data-validation-error-msg' => 'Role is required'
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
                    <img class="thumb-preview" src="<?= App::$path ?>img/avatar/<?= isset($user) ? $user->avatar : '0.jpg' ?>">
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
                        'data-validation-error-msg' => 'Image size should be less than 1M'
                    ]); ?>
                </div>
            </div>

        </div>
        <div class="col-lg-12 form-group forum-cmds text-center">
            <hr>
            <button id="btn-user-add" name="btn-user-add" class="btn btn-primary">Save</button>
        </div>
    </form>
</section>
