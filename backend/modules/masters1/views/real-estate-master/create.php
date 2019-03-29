<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\RealEstateMaster */

$this->title = 'Real Estate Management';
$this->params['breadcrumbs'][] = ['label' => 'Real Estate Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Default box -->
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <?=  Html::a('<span> Manage Real Estate</span>', ['index'], ['class' => 'btn btn-block manage-btn']) ?>
        <div class="real-estate-master-create">
            <?= $this->render('_form', [
            'model' => $model,
            ]) ?>
        </div>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->

