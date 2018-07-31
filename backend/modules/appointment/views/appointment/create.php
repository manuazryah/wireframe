<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Appointment */

$this->title = 'Create Appointment';
$this->params['breadcrumbs'][] = ['label' => 'Appointments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Default box -->
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <?= Html::a('<span> Manage Appointment</span>', ['index'], ['class' => 'btn btn-block manage-btn']) ?>
        <div class="app-nav">
            <ul class="nav nav-tabs nav-tabs-justified">
                <li class="active">
                    <a><span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Appointment</span></a>
                </li>
                <li class="">
                    <a><span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Services</span></a>
                </li>
            </ul>
        </div>
        <div class="appointment-create">
            <?=
            $this->render('_form', [
                'model' => $model,
            ])
            ?>
        </div>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->

