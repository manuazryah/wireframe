<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\AdminPosts;

/* @var $this yii\web\View */
/* @var $model common\models\AdminUsers */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-users-form form-inline">
    <?= \common\widgets\Alert::widget(); ?>
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class='col-md-4 col-xs-12'>
            <?php $posts = ArrayHelper::map(AdminPosts::findAll(['status' => 1]), 'id', 'post_name'); ?>
            <?= $form->field($model, 'post_id')->dropDownList($posts, ['prompt' => '-Choose a Post-']) ?>

        </div>
        <div class='col-md-4 col-xs-12'>
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-4 col-xs-12'>
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12'>
            <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true]) ?>

        </div>
        <?php if ($model->isNewRecord) { ?>
            <div class='col-md-4 col-sm-6 col-xs-12'>

                <?= $form->field($model, 'user_name')->textInput(['maxlength' => true]) ?>

            </div>
        <?php } ?>
        <?php if ($model->isNewRecord) { ?>
            <div class='col-md-4 col-sm-6 col-xs-12'>

                <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>


            </div>
        <?php } ?>

        <div class='col-md-4 col-sm-6 col-xs-12'>
            <?= $form->field($model, 'status')->dropDownList(['1' => 'Enabled', '0' => 'Disabled']) ?>

        </div>
    </div>
    <div class="form-group ">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
