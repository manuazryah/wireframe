<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Country */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="country-form form-inline">
    <?= \common\components\AlertMessageWidget::widget() ?>
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>   
            <?= $form->field($model, 'country_name')->textInput(['maxlength' => true, 'placeholder' => 'Country Name'])->label(FALSE) ?>

        </div><div class='col-md-4 col-sm-6 col-xs-12 left_padd'>    
            <?= $form->field($model, 'country_code')->textInput(['maxlength' => true, 'placeholder' => 'Country Code'])->label(FALSE) ?>

        </div><div class='col-md-4 col-sm-6 col-xs-12 left_padd'>   
            <?= $form->field($model, 'status')->dropDownList(['1' => 'Enabled', '0' => 'Disabled'], ['prompt' => 'Select Status'])->label(FALSE) ?>

        </div>
    </div>


    <div class="form-group action-btn-right">
        <?= Html::a('<span> Cancel</span>', ['index'], ['class' => 'btn btn-block cancel-btn']) ?>
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
