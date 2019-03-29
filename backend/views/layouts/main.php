<?php
/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\db\Expression;

AppAsset::register($this);
$controler = Yii::$app->controller->id;
if (Yii::$app->user->identity->post_id == 1 || Yii::$app->user->identity->post_id == 3) {
    $new_notifications = common\models\Notifications::find()->where(new Expression('!FIND_IN_SET(:users, users)'))->addParams([':users' => Yii::$app->user->identity->id])->orWhere(['IS', 'users', (new Expression('Null'))])->all();
} else {
    $new_notifications = [];
}
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
        <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
        <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
        <?php $this->head() ?>
    </head>
    <body class="hold-transition skin-blue sidebar-collapse sidebar-mini">
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

                            <li class="dropdown notifications-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-bell-o"></i>
                                    <span class="label label-warning"><?= count($new_notifications) ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">You have <?= count($new_notifications) ?> notifications</li>
                                    <li>
                                        <!-- inner menu: contains the actual data -->
                                        <ul class="menu">
                                            <?php
                                            if (!empty($new_notifications)) {
                                                foreach ($new_notifications as $notifications) {
                                                    ?>
                                                    <li>
                                                        <?= Html::a('<i class="fa fa-credit-card text-aqua"></i> ' . $notifications->notification_content, ['/notifications/notifications/view', 'id' => $notifications->id], ['title' => $notifications->notification_content]) ?>
                                                    </li>
                                                    <?php
                                                }
                                            }
                                            ?>


                                        </ul>
                                    </li>
                                    <li class="footer">
                                        <?= Html::a('View all', ['/notifications/notifications/index'], ['class' => '']) ?>
                                    </li>
                                </ul>
                            </li>
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
                        <li class="">
                            <?= Html::a('<i class="fa fa-home"></i> <span>Home</span>', ['/site/index'], ['class' => '']) ?>
                        </li>
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
                        <li class="treeview <?= $controler == 'reports' ? 'active' : '' ?>">
                            <a href="">
                                <i class="fa fa-book"></i>
                                <span>Reports</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <?= Html::a('<i class="fa fa-angle-double-right"></i> Full Report', ['/reports/reports/index'], ['class' => 'title']) ?>
                                </li>
                                <li>
                                    <?= Html::a('<i class="fa fa-angle-double-right"></i> PDC Report', ['/reports/reports/pdc-report'], ['class' => 'title']) ?>
                                </li>
                                <li>
                                    <?= Html::a('<i class="fa fa-angle-double-right"></i> Realestate Report', ['/reports/reports/realestate-report'], ['class' => 'title']) ?>
                                </li>
                                <li>
                                    <?= Html::a('<i class="fa fa-angle-double-right"></i> Istadama Report', ['/reports/reports/istadama-report'], ['class' => 'title']) ?>
                                </li>
                                <li>
                                    <?= Html::a('<i class="fa fa-angle-double-right"></i> Realestate Cheque Report', ['/reports/reports/realestate-cheque-report'], ['class' => 'title']) ?>
                                </li>
                                <li>
                                    <?= Html::a('<i class="fa fa-angle-double-right"></i> Sponsor Document Expiry', ['/reports/reports/sponsor-document-expiry'], ['class' => 'title']) ?>
                                </li>
                            </ul>
                        </li>

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
                                        <?= Html::a('<i class="fa fa-angle-double-right"></i> Real Estate Vendors', ['/masters/company-management/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('<i class="fa fa-angle-double-right"></i> Sponsor Management', ['/masters/sponsor/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('<i class="fa fa-angle-double-right"></i> Services', ['/masters/services/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('<i class="fa fa-angle-double-right"></i> Service Category', ['/masters/service-category/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('<i class="fa fa-angle-double-right"></i> Suppliers', ['/masters/supplier/index'], ['class' => 'title']) ?>
                                    </li>
                                    <li>
                                        <?= Html::a('<i class="fa fa-angle-double-right"></i> Banks', ['/masters/banks/index'], ['class' => 'title']) ?>
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
        <div class='page-loader'>
            <div class='loader'>
                <div class='circle'></div>
                <div class='circle'></div>
                <div class='circle'></div>
                <div class='circle'></div>
                <div class='circle'></div>
            </div>
        </div>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
<script>
            $(document).ready(function () {
            });
            function showLoader() {
                $('.page-loader').addClass('show');
                $('.page-loader').removeClass('hide');
            }
            function hideLoader() {
                $('.page-loader').addClass('hide');
                $('.page-loader').removeClass('show');
            }
</script>