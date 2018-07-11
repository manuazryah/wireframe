<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CompanyManagement */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="company-management-form form-inline">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>   
            <?= $form->field($model, 'company_name')->textInput(['maxlength' => true, 'placeholder' => 'Company Name'])->label(FALSE) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>    
            <?= $form->field($model, 'reference_code')->textInput(['maxlength' => true, 'placeholder' => 'Reference Code'])->label(FALSE) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>    
            <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'Email'])->label(FALSE) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>    
            <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true, 'placeholder' => 'Phone Number'])->label(FALSE) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>    
            <?= $form->field($model, 'address')->textInput(['maxlength' => true, 'placeholder' => 'Address'])->label(FALSE) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>    
            <?= $form->field($model, 'contact_person')->textInput(['maxlength' => true, 'placeholder' => 'Contact Person'])->label(FALSE) ?>

        </div>
    </div>
    <div class="row">
        <div class='col-md-8 col-sm-6 col-xs-12 left_padd'>    
            <?= $form->field($model, 'comment')->textarea(['rows' => 3, 'placeholder' => 'Comment'])->label(FALSE) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>    
           <?= $form->field($model, 'status')->dropDownList(['1' => 'Enabled', '0' => 'Disabled'], ['prompt' => 'Select Status'])->label(FALSE) ?>

        </div>
    </div>


    <div class="form-group action-btn-right">
        <?= Html::a('<span> Cancel</span>', ['index'], ['class' => 'btn btn-block cancel-btn']) ?>
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
