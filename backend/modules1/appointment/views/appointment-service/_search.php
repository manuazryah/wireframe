<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AppointmentServiceSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="appointment-service-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'appointment_id') ?>

    <?= $form->field($model, 'service') ?>

    <?= $form->field($model, 'comment') ?>

    <?= $form->field($model, 'amount') ?>

    <?php // echo $form->field($model, 'tax') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'total') ?>

    <?php // echo $form->field($model, 'tax_percentage') ?>

    <?php // echo $form->field($model, 'tax_amount') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'CB') ?>

    <?php // echo $form->field($model, 'UB') ?>

    <?php // echo $form->field($model, 'DOC') ?>

    <?php // echo $form->field($model, 'DOU') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
