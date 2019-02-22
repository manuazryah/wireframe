<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\RealEstateMasterSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="real-estate-master-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'company') ?>

    <?= $form->field($model, 'reference_code') ?>

    <?= $form->field($model, 'total_square_feet') ?>

    <?= $form->field($model, 'sponsor') ?>

    <?php // echo $form->field($model, 'comany_name_for_ejari') ?>

    <?php // echo $form->field($model, 'number_of_license') ?>

    <?php // echo $form->field($model, 'number_of_plots') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <?php // echo $form->field($model, 'rent_total') ?>

    <?php // echo $form->field($model, 'no_of_cheques') ?>

    <?php // echo $form->field($model, 'commission') ?>

    <?php // echo $form->field($model, 'deposit') ?>

    <?php // echo $form->field($model, 'sponser_fee') ?>

    <?php // echo $form->field($model, 'furniture_expense') ?>

    <?php // echo $form->field($model, 'office_renovation_expense') ?>

    <?php // echo $form->field($model, 'other_expense') ?>

    <?php // echo $form->field($model, 'attachments') ?>

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
