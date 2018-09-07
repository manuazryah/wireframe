<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MuncipalityApproval */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="muncipality-approval-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'licencing_master_id')->textInput() ?>

    <?= $form->field($model, 'online_reference_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'online_application_fees')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payment_receipt')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'CB')->textInput() ?>

    <?= $form->field($model, 'date')->textInput() ?>

    <?= $form->field($model, 'next_step')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
