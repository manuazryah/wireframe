<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AdminPosts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-posts-form form-inline">
    <?= \common\components\AlertMessageWidget::widget() ?>
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class='col-md-3 col-xs-12'>
            <?= $form->field($model, 'post_name')->textInput(['maxlength' => true, 'placeholder' => 'Post Name']) ?>

        </div>
        <div class='col-md-3 col-xs-12'>
            <?= $form->field($model, 'admin')->dropDownList(['1' => 'Yes', '0' => 'No'], ['prompt' => 'Admin  Module Permission']) ?>

        </div>
        <div class='col-md-3 col-xs-12'>
            <?= $form->field($model, 'masters')->dropDownList(['1' => 'Yes', '0' => 'No'], ['prompt' => 'Masters  Module Permission']) ?>

        </div>
        <div class='col-md-3 col-xs-12'>
            <?= $form->field($model, 'sales')->dropDownList(['1' => 'Yes', '0' => 'No'], ['prompt' => 'Appointment  Module Permission']) ?>

        </div>
        <div class='col-md-3 col-xs-12'>
            <?= $form->field($model, 'accounts')->dropDownList(['1' => 'Yes', '0' => 'No'], ['prompt' => 'Accounts  Module Permission']) ?>

        </div>
        <div class='col-md-3 col-xs-12'>
            <?= $form->field($model, 'operations')->dropDownList(['1' => 'Yes', '0' => 'No'], ['prompt' => 'Operations  Module Permission']) ?>

        </div>
        <div class='col-md-3 col-xs-12'>
            <?= $form->field($model, 'status')->dropDownList(['1' => 'Enabled', '0' => 'Disabled']) ?>

        </div>
    </div>


    <div class="form-group action-btn-right">
        <?= Html::a('<span> Cancel</span>', ['index'], ['class' => 'btn btn-block cancel-btn']) ?>
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success create-btn']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
