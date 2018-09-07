<?php
/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);
$controler = Yii::$app->controller->id;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="<?= Yii::$app->homeUrl; ?>img/favicon.ico" type="image/x-icon">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <script src="<?= Yii::$app->homeUrl; ?>js/jquery.min.js"></script>
        <script type="text/javascript">
            var homeUrl = '<?= Yii::$app->homeUrl; ?>';
        </script>
        <?php $this->head() ?>
    </head>
    <body class="skin-blue fixed sidebar-mini sidebar-mini-expand-feature sidebar-collapse">
        <?php $this->beginBody() ?>

        <div class="wrapper">
            <header class="main-header">
                <!-- Logo -->
                <a href="" class="logo">
                    <img width="50" class="img-fluid" src="<?= Yii::$app->homeUrl; ?>img/ublcsp-logo.png"/>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>

                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <?php
                                echo ''
                                . Html::beginForm(['/site/logout'], 'post', ['style' => '']) . '<a>'
                                . Html::submitButton(
                                        '<i class="fa fa-sign-out" aria-hidden="true"></i> Sign out', ['class' => 'signout-btn', 'style' => '']
                                ) . '</a>'
                                . Html::endForm()
                                . '';
                                ?>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>

            <!-- =============================================== -->

            <!-- Left side column. contains the sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu" data-widget="tree">
                        <li class="header"></li>
                        <?php
                        if (Yii::$app->user->identity->post_id == 1 || Yii::$app->session['post']['admin'] == 1) {
                            ?>
                            <li class="treeview <?= $controler == 'admin-posts' || $controler == 'admin-users' || $controler == 'site' ? 'active' : '' ?>">
                                <a href="">
                                    <i class="fa fa-dashboard"></i>
                                    <span>Administration</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li>
                                        <?= Html::a('<i class="fa fa-angle-double-right"></i> Access Powers', ['/admin/admin-posts/index'], ['class' => 'title']) ?>
                                    </li>

                                    <li>
                                        <?= Html::a('<i class="fa fa-angle-double-right"></i> Admin Users', ['/admin/admin-users/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('<i class="fa fa-angle-double-right"></i> Design', ['/admin/test/index'], ['class' => 'title']) ?>
                                    </li>
                                </ul>
                            </li>
                            <?php
                        }
                        ?>
                        <?php
                        if (Yii::$app->user->identity->post_id == 1 || Yii::$app->session['post']['masters'] == 1) {
                            ?>
                            <li class="<?= $controler == 'real-estate-master' ? 'active' : '' ?>">
                                <?= Html::a('<i class="fa fa-building-o"></i> <span>Real Estate Management</span>', ['/masters/real-estate-master/index'], ['class' => '']) ?>
                            </li>
                            <?php
                        }
                        ?>
                        <?php
                        if (Yii::$app->user->identity->post_id == 1 || Yii::$app->session['post']['sales'] == 1) {
                            ?>
                            <li class="<?= $controler == 'appointment' ? 'active' : '' ?>">
                                <?= Html::a('<i class="fa fa-file"></i> <span>Appointment</span>', ['/appointment/appointment/index'], ['class' => '']) ?>
                            </li>
                            <?php
                        }
                        ?>
                        <?php
                        if (Yii::$app->user->identity->post_id == 1 || Yii::$app->session['post']['accounts'] == 1) {
                            ?>
                            <li class="<?= $controler == 'service-payment' ? 'active' : '' ?>">
                                <?= Html::a('<i class="fa fa-money"></i> <span>Accounts</span>', ['/accounts/service-payment/index'], ['class' => '']) ?>
                            </li>
                            <?php
                        }
                        ?>
                        <?php
                        if (Yii::$app->user->identity->post_id == 1 || Yii::$app->session['post']['operations'] == 1) {
                            ?>
                            <li class="<?= $controler == 'licencing-master' ? 'active' : '' ?>">
                                <?= Html::a('<i class="fa fa-id-card-o"></i> <span>License Procedure</span>', ['/licence_procedure/licencing-master/index'], ['class' => '']) ?>
                            </li>
                            <?php
                        }
                        ?>
                        <?php
                        if (Yii::$app->user->identity->post_id == 1 || Yii::$app->session['post']['masters'] == 1) {
                            ?>
                            <li class="treeview <?= $controler == 'country' || $controler == 'services' || $controler == 'supplier' || $controler == 'service-category' || $controler == 'sponsor' || $controler == 'company-management' || $controler == 'debtor' ? 'active' : '' ?>">
                                <a href="">
                                    <i class="fa fa-database"></i>
                                    <span>Masters</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li>
                                        <?= Html::a('<i class="fa fa-angle-double-right"></i> Debtors', ['/masters/debtor/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('<i class="fa fa-angle-double-right"></i> Company Management', ['/masters/company-management/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('<i class="fa fa-angle-double-right"></i> Sponsor Management', ['/masters/sponsor/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('<i class="fa fa-angle-double-right"></i> Service Category', ['/masters/service-category/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('<i class="fa fa-angle-double-right"></i> Suppliers', ['/masters/supplier/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('<i class="fa fa-angle-double-right"></i> Services', ['/masters/services/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('<i class="fa fa-angle-double-right"></i> Nationality', ['/masters/country/index'], ['class' => 'title']) ?>
                                    </li>

                                </ul>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- =============================================== -->
            <div class="content-wrapper">
                <!-- Main content -->
                <section class="content">
                    <?= $content ?>
                </section>
            </div>
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                </div>
                <strong>Copyright &copy; 2018-2019 <a href="http://azryah.com/">epitome.ae</a>.</strong> All rights
                reserved.
            </footer>
            <div class="control-sidebar-bg"></div>
        </div>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
<script>
    $(document).ready(function () {
        $(".step-change").change(function () {
            var url = $(".step-change").val();
            if (url != '') {
                window.location.href = url;
            }
        });
    });
</script>
