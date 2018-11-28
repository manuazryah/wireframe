<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SideAgreementSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="side-agreement-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'appointment_id') ?>

    <?= $form->field($model, 'date') ?>

    <?= $form->field($model, 'company_name') ?>

    <?= $form->field($model, 'represented_by') ?>

    <?php // echo $form->field($model, 'office_no') ?>

    <?php // echo $form->field($model, 'offfice_address') ?>

    <?php // echo $form->field($model, 'activity') ?>

    <?php // echo $form->field($model, 'payment') ?>

    <?php // echo $form->field($model, 'office_statrt_date') ?>

    <?php // echo $form->field($model, 'office_end_date') ?>

    <?php // echo $form->field($model, 'payment_details') ?>

    <?php // echo $form->field($model, 'sponsor_amount') ?>

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
