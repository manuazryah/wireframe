<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AdminUsers */

$this->title = 'Create Admin Users';
$this->params['breadcrumbs'][] = ['label' => 'Admin Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Default box -->
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <?=  Html::a('<span> Manage Admin Users</span>', ['index'], ['class' => 'btn btn-block btn-warning manage-btn']) ?>
        <div class="admin-users-create">
            <?= $this->render('_form', [
            'model' => $model,
            ]) ?>
        </div>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->

