<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\MunicipalityApproval */

$this->title = 'Create Municipality Approval';
$this->params['breadcrumbs'][] = ['label' => 'Municipality Approvals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Default box -->
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <?=  Html::a('<span> Manage Municipality Approval</span>', ['index'], ['class' => 'btn btn-block manage-btn']) ?>
        <div class="municipality-approval-create">
            <?= $this->render('_form', [
            'model' => $model,
            ]) ?>
        </div>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->

