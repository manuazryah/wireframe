<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CompanyEstablishmentCardSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="company-establishment-card-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'licensing_master_id') ?>

    <?= $form->field($model, 'typing_service') ?>

    <?= $form->field($model, 'service_reciept') ?>

    <?= $form->field($model, 'payment') ?>

    <?php // echo $form->field($model, 'payment_reciept') ?>

    <?php // echo $form->field($model, 'card_attachment') ?>

    <?php // echo $form->field($model, 'expiry_date') ?>

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
