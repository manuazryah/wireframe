<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ServiceCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="service-category-form form-inline">
    <?= \common\components\AlertMessageWidget::widget() ?>
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class='col-md-4 col-xs-12 left_padd'>   
            <?= $form->field($model, 'category_name')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-4 col-xs-12 left_padd'>    
            <?= $form->field($model, 'category_code')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-4 col-xs-12 left_padd'>    
            <?= $form->field($model, 'status')->dropDownList(['1' => 'Enabled', '0' => 'Disabled'], ['prompt' => 'Select Status']) ?>

        </div>
        <div class='col-md-8 col-xs-12 left_padd'>    
            <?= $form->field($model, 'comment')->textarea(['rows' => 3]) ?>

        </div>
    </div>


    <div class="form-group action-btn-right">
        <?= Html::a('<span> Cancel</span>', ['index'], ['class' => 'btn btn-block cancel-btn']) ?>
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
