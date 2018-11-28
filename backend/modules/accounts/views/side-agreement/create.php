<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\SideAgreement */

$this->title = 'Create Side Agreement';
$this->params['breadcrumbs'][] = ['label' => 'Side Agreements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Default box -->
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <?=  Html::a('<span> Manage Side Agreement</span>', ['index'], ['class' => 'btn btn-block manage-btn']) ?>
        <div class="side-agreement-create">
            <?= $this->render('_form', [
            'model' => $model,
            ]) ?>
        </div>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->

