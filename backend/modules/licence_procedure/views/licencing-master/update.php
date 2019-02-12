<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\LicencingMaster */

$this->title = 'License Procedure';
$this->params['breadcrumbs'][] = ['label' => 'Licencing Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<!-- Default box -->
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <?= Html::a('<span> Manage License Procedure</span>', ['index'], ['class' => 'btn btn-block manage-btn', 'style' => 'display: inline-block']) ?>
        <?= Html::a('<span> Partner Details</span>', ['partner-details', 'id' => $license_master->id], ['class' => 'btn btn-block manage-btn', 'style' => 'display: inline-block;margin-top: 0px;']) ?>
        <div class="licencing-master-update">
            <?=
            $this->render('_form', [
                'model' => $model,
                'license_master' => $license_master,
            ])
            ?>
        </div>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->