<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\NotificationsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notifications-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'data_id') ?>

    <?= $form->field($model, 'master_id') ?>

    <?= $form->field($model, 'notification_type') ?>

    <?= $form->field($model, 'notification_content') ?>

    <?php // echo $form->field($model, 'users') ?>

    <?php // echo $form->field($model, 'link') ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'doc') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
