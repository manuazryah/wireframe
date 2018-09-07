<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MuncipalityApprovalSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="muncipality-approval-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'licencing_master_id') ?>

    <?= $form->field($model, 'online_reference_number') ?>

    <?= $form->field($model, 'online_application_fees') ?>

    <?= $form->field($model, 'payment_receipt') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'CB') ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'next_step') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
