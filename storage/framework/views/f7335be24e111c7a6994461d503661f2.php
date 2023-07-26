<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $__env->yieldContent('page_title'); ?></title>
    <link href="<?php echo e(asset('admin_assets/css/font-face.css')); ?>" rel="stylesheet" media="all">
    <link href="<?php echo e(asset('admin_assets/vendor/font-awesome-4.7/css/font-awesome.min.css')); ?>" rel="stylesheet" media="all">
    <link href="<?php echo e(asset('admin_assets/vendor/font-awesome-5/css/fontawesome-all.min.css')); ?>" rel="stylesheet" media="all">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="<?php echo e(asset('admin_assets/vendor/mdi-font/css/material-design-iconic-font.min.css')); ?>" rel="stylesheet" media="all">
    <link href="<?php echo e(asset('admin_assets/vendor/bootstrap-4.1/bootstrap.min.css')); ?>" rel="stylesheet" media="all">
    <link href="<?php echo e(asset('admin_assets/css/theme.css')); ?>" rel="stylesheet" media="all">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

</head>

<body>
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
        <header class="header-mobile d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
                        <a class="logo" href="<?php echo e(url('admin/dashboard')); ?>">
                            <img src="<?php echo e(asset('admin_assets/images/icon/logo.png')); ?>" alt="CoolAdmin" width="100px" />
                        </a>
                        <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
            </div>
            <nav class="navbar-mobile">
                <div class="container-fluid">
                    <ul class="navbar-mobile__list list-unstyled">
                        <li class="<?php echo $__env->yieldContent('dashboard_select'); ?>">
                            <a href="<?php echo e(url('admin/dashboard')); ?>">
                                <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                        </li>

                        <li class="<?php echo $__env->yieldContent('category_select'); ?>">
                            <a href="<?php echo e(url('admin/category')); ?>">
                                <i class="fas fa-list"></i>Category</a>
                        </li>

                        <li class="<?php echo $__env->yieldContent('coupon_select'); ?>">
                            <a href="<?php echo e(url('admin/coupon')); ?>">
                                <i class="fas fa-tag"></i>Coupon</a>
                        </li>

                        <li class="<?php echo $__env->yieldContent('size_select'); ?>">
                            <a href="<?php echo e(url('admin/size')); ?>">
                                <i class="fas fa-window-maximize"></i>Size</a>
                        </li>

                        <li class="<?php echo $__env->yieldContent('brand_select'); ?>">
                            <a href="<?php echo e(url('admin/brand')); ?>">
                                <i class="fa fa-product-hunt"></i>Brand</a>
                        </li>

                        <li class="<?php echo $__env->yieldContent('color_select'); ?>">
                            <a href="<?php echo e(url('admin/color')); ?>">
                                <i class="fas fa-paint-brush"></i>Color</a>
                        </li>

                        <li class="<?php echo $__env->yieldContent('tax_select'); ?>">
                            <a href="<?php echo e(url('admin/tax')); ?>">
                                <i class="fas fa-percent"></i>Tax</a>
                        </li>

                        <li class="<?php echo $__env->yieldContent('product_select'); ?>">
                            <a href="<?php echo e(url('admin/product')); ?>">
                                <i class="fa fa-product-hunt"></i>Product</a>
                        </li>

                        <li class="<?php echo $__env->yieldContent('customer_select'); ?>">
                            <a href="<?php echo e(url('admin/customer')); ?>">
                                <i class="fa fa-user"></i>Customer</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- END HEADER MOBILE-->

        <!-- MENU SIDEBAR-->
        <aside class="menu-sidebar d-none d-lg-block">
            <div class="logo">
                <a href="<?php echo e(url('admin/dashboard')); ?>">
                    <img src="<?php echo e(asset('admin_assets/images/icon/logo.png')); ?>" width="100px" />
                </a>
            </div>
            <div class="menu-sidebar__content js-scrollbar1">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">
                        <li class="<?php echo $__env->yieldContent('dashboard_select'); ?>">
                            <a href="<?php echo e(url('admin/dashboard')); ?>">
                                <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                        </li>

                        <li class="<?php echo $__env->yieldContent('category_select'); ?>">
                            <a href="<?php echo e(url('admin/category')); ?>">
                                <i class="fas fa-list"></i>Category</a>
                        </li>

                        <li class="<?php echo $__env->yieldContent('coupon_select'); ?>">
                            <a href="<?php echo e(url('admin/coupon')); ?>">
                                <i class="fas fa-tag"></i>Coupon</a>
                        </li>

                        <li class="<?php echo $__env->yieldContent('size_select'); ?>">
                            <a href="<?php echo e(url('admin/size')); ?>">
                                <i class="fas fa-window-maximize"></i>Size</a>
                        </li>

                        <li class="<?php echo $__env->yieldContent('brand_select'); ?>">
                            <a href="<?php echo e(url('admin/brand')); ?>">
                                <i class="fa fa-bold"></i>Brand</a>
                        </li>

                        <li class="<?php echo $__env->yieldContent('color_select'); ?>">
                            <a href="<?php echo e(url('admin/color')); ?>">
                                <i class="fas fa-paint-brush"></i>Color</a>
                        </li>

                        <li class="<?php echo $__env->yieldContent('tax_select'); ?>">
                            <a href="<?php echo e(url('admin/tax')); ?>">
                                <i class="fas fa-percent"></i>Tax</a>
                        </li>

                        <li class="<?php echo $__env->yieldContent('product_select'); ?>">
                            <a href="<?php echo e(url('admin/product')); ?>">
                                <i class="fa fa-product-hunt"></i>Product</a>
                        </li>

                        <li class="<?php echo $__env->yieldContent('customer_select'); ?>">
                            <a href="<?php echo e(url('admin/customer')); ?>">
                                <i class="fa fa-user"></i>Customer</a>
                        </li>

                        <li class="<?php echo $__env->yieldContent('home_banner_select'); ?>">
                            <a href="<?php echo e(url('admin/home_banner')); ?>">
                                <i class="fas fa-images"></i>Home Banner</a>
                        </li>
                            

                    </ul>
                </nav>
            </div>
        </aside>
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <header class="header-desktop">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="header-wrap">
                            <form class="form-header" action="" method="POST">

                            </form>
                            <div class="header-button">
                                <div class="account-wrap">
                                    <div class="account-item clearfix js-item-menu">
                                        <div class="content">
                                            <a class="js-acc-btn" href="#">Welcome Admin</a>
                                        </div>
                                        <div class="account-dropdown js-dropdown">

                                            <div class="account-dropdown__body">
                                                <div class="account-dropdown__item">
                                                    <a href="#">
                                                        <i class="zmdi zmdi-account"></i>Account</a>
                                                </div>

                                            </div>




                                            <div class="account-dropdown__footer">
                                                <a href="<?php echo e(url('admin/logout')); ?>">
                                                    <i class="zmdi zmdi-power"></i>Logout</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- END HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <?php $__env->startSection('container'); ?>
                        <?php echo $__env->yieldSection(); ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTAINER-->

    </div>


    <script src="<?php echo e(asset('admin_assets/vendor/jquery-3.2.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('admin_assets/vendor/bootstrap-4.1/popper.min.js')); ?>"></script>
    <script src="<?php echo e(asset('admin_assets/vendor/bootstrap-4.1/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('admin_assets/vendor/wow/wow.min.js')); ?>"></script>
    <script src="<?php echo e(asset('admin_assets/js/main.js')); ?>"></script>



</body>

</html><?php /**PATH C:\xampp\htdocs\ecom2\resources\views/admin/layout.blade.php ENDPATH**/ ?>