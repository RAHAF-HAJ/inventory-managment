<!doctype html>
<html>
<head>
    <title>Inventory Managment System</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?= App::$path ?>css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= App::$path ?>css/bootstrap-datetimepicker.min.css" />
    <link rel="stylesheet" href="<?= App::$path ?>css/datatables.min.css" />
    <link rel="stylesheet" href="<?= App::$path ?>css/slick_dtp.css" />
    <link rel="stylesheet" href="<?= App::$path ?>css/select2.min.css" />
    <link rel="stylesheet" href="<?= App::$path ?>css/style.css" />
    <link rel="stylesheet" href="<?= App::$path ?>css/responsive.css" />
    <link rel="stylesheet" href="<?= App::$path ?>css/font-awesome.min.css" />

</head>
<?php
$login_class = 'not-logged';
if(isset($_SESSION['user']))  {
    $login_class = 'logged';
}?>
<body class="<?=$login_class?>">

<div id="wrap" class="wrapper">
    <aside class="main-sidebar" >

        <section class="sidebar">

            <h3 class="main-color" style="margin: 0;
    padding: 15px 10px;
    border-bottom: 1px solid #123456;">
                <a href="#" id="btn-sidebar-collapse" class="sidebar-toggle"><span class="glyphicon glyphicon-menu-hamburger"></span></a>
                INVENTORY</h3>

            <div class="gnav">

                <div class="gnav-header">
                    <a class="has-childs collapse" role="button" data-toggle="collapse" href="#users-area" aria-expanded="false" aria-controls="users-area">
                        <span class="hidden-on-collapse">Admin</span>
                    </a>
                </div>

                <ul class="subnav collapse" id="users-area">
                    <?php if(isset($_SESSION['user']) && $_SESSION['user']->show_users_roles): ?>
                        <li>
                            <a href="<?= App::$path ?>user/index">
                                <span class="fa fa-users"></span>
                                <span class="hidden-on-collapse">Users</span>
                            </a>
                        </li>
                        <li >
                            <a href="<?= App::$path ?>role/index">
                                <span class="fa fa-lock"></span>
                                <span class="hidden-on-collapse">Roles</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <li>
                        <a href="<?= App::$path ?>user/profile/<?= $_SESSION['user']->id ?>">
                            <span class="fa fa-users"></span>
                            <span class="hidden-on-collapse">Profile</span>
                        </a>
                    </li>
                </ul>
                <div class="gnav-header">
                    <a href="<?= App::$path ?>inventory/index">
                        <i class="fa fa-home"></i>
                        <span class="hidden-on-collapse">Inventories</span>
                    </a>
                </div>
                <div class="gnav-header">
                    <a class="has-childs collapse" role="button" data-toggle="collapse" href="#prodcuts-area" aria-expanded="false" aria-controls="prodcuts-area">
                        <span class="hidden-on-collapse">Products</span>
                    </a>
                </div>
                <ul class="subnav collapse" id="prodcuts-area">
                    <?php if(isset($_SESSION['user']) && $_SESSION['user']->add_articles): ?>
                        <li>
                            <a href="<?= App::$path ?>article/add">
                                &nbsp;&nbsp;
                                <span class="hidden-on-collapse">Add product</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <li>
                        <a href="<?= App::$path ?>article/index">
                            &nbsp;&nbsp;
                            <span class="hidden-on-collapse">Products</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= App::$path ?>category/index">
                            &nbsp;&nbsp;
                            <span class="hidden-on-collapse">Categories</span>
                        </a>
                    </li>
                    <li><a href="<?= App::$path ?>unit/index">
                            &nbsp;&nbsp;
                            <span class="hidden-on-collapse">Units</span>
                        </a>
                    </li>
                </ul>

                <div class="gnav-header">
                    <a class="has-childs collapse" role="button" data-toggle="collapse" href="#purchase-area" aria-expanded="false" aria-controls="purchase-area">
                        <span class="hidden-on-collapse">Purchases</span>
                    </a>
                </div>
                <ul class="subnav collapse" id="purchase-area">
                    <?php if(isset($_SESSION['user']) && $_SESSION['user']->show_purchases): ?>
                        <li><a href="<?= App::$path ?>purchase/index">
                                <span class="fa fa-newspaper-o"></span>
                                <span class="hidden-on-collapse">Purchases</span>
                            </a>
                        </li>
                    <?php endif;?>
                    <?php if(isset($_SESSION['user']) && $_SESSION['user']->show_suppliers):?>
                        <li>
                            <a href="<?= App::$path ?>supplier/index">
                                <span class="fa fa-users"></span>
                                <span class="hidden-on-collapse">Suppliers</span>
                            </a>
                        </li>
                    <?php endif;?>
                </ul>
                <div class="gnav-header">
                    <a class="has-childs collapse" role="button" data-toggle="collapse" href="#sales-area" aria-expanded="false" aria-controls="sales-area">
                        <span class="hidden-on-collapse">Sales</span>
                    </a>
                </div>
                <ul class="subnav collapse" id="sales-area">
                    <?php if(isset($_SESSION['user']) && $_SESSION['user']->show_sales): ?>
                        <li>
                            <a href="<?= App::$path ?>sale/index">
                                <span class="fa fa-newspaper-o"></span>
                                <span class="hidden-on-collapse">Sales</span>
                            </a>
                        </li>
                    <?php endif;?>

                    <?php if(isset($_SESSION['user']) && $_SESSION['user']->show_clients): ?>
                        <li>
                            <a href="<?= App::$path ?>client/index">
                                <span class="fa fa-users"></span>
                                <span class="hidden-on-collapse">Clients</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>

                <div class="user-menu">
                    <div class="subnav main-color" >
                        <a style="color: #ac2925; font-weight: bold" href="<?= App::$path ?>user/logout">
                            LOGOUT
                        </a>
                    </div>
                    <div class="subnav main-color">
                        <a style="background: #fff"> <h5 style="font-weight: bold;"><?= $_SESSION['user']->fname . ' ' .  $_SESSION['user']->lname?></h5></a>
                    </div>
                </div>
            </div>
        </section>
    </aside>

<!-- view content start -->
    <div class="content-wrapper">
        <?= $content; ?>
    </div>

<!-- view content start -->
    <footer class="main-footer">
    </footer>

</div>

<script src="<?= App::$path ?>js/jquery-1.11.3.min.js"></script>
<script src="<?= App::$path ?>js/bootstrap.min.js"></script>
<script src="<?= App::$path ?>js/moment.min.js"></script>
<script src="<?= App::$path ?>js/bootstrap-datetime-piker/bootstrap-datetimepicker.min.js"></script>
<script src="<?= App::$path ?>js/ck-editor/ckeditor.js"></script>
<script src="<?= App::$path ?>js/select2.min.js"></script>
<script src="<?= App::$path ?>js/form-validator/jquery.form-validator.min.js"></script>
<script src="<?= App::$path ?>js/functions.js"></script>
<script src="<?= App::$path ?>js/<?= App::getInstance()->cur_page ?>.js"></script>
<script>
            $(document).ready(function(){

                $('#btn-sidebar-collapse').click(function(){
                    if( $('body').hasClass('has-mini-sidebar') )
                        $('body').removeClass('has-mini-sidebar');
                    else
                        $('body').addClass('has-mini-sidebar')
                });
                //Date table
                if($('.table').length > 0)
                    $('.table').DataTable();
                setTimeout(function () {
                    $('[type="search"]').attr('placeholder', 'Search');
                    $('.header-btns').prepend('<li class="search"></li>')
                    $('.header-btns .search').prepend($('[type="search"]'))
                }, 500);
                $('select').select2();




        });
</script>
</body>
