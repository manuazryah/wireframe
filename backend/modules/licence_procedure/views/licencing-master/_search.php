<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LicencingMasterSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="licencing-master-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'appointment_id') ?>

    <?= $form->field($model, 'appointment_no') ?>

    <?= $form->field($model, 'customer_id') ?>

    <?= $form->field($model, 'sponsor') ?>

    <?php // echo $form->field($model, 'plot') ?>

    <?php // echo $form->field($model, 'space_for_licence') ?>

    <?php // echo $form->field($model, 'no_of_partners') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'stage') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <?php // echo $form->field($model, 'CB') ?>

    <?php // echo $form->field($model, 'DOC') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
