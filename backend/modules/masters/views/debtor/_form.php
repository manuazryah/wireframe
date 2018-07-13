<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Country;

/* @var $this yii\web\View */
/* @var $model common\models\Debtor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="debtor-form form-inline">
    <?= \common\components\AlertMessageWidget::widget() ?>
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class='col-md-4 col-xs-12 left_padd'>    
            <?= $form->field($model, 'company_name')->textInput(['maxlength' => true, 'placeholder' => 'Company Name']) ?>

        </div>
        <div class='col-md-4 col-xs-12 left_padd'>    
            <?= $form->field($model, 'reference_code')->textInput(['maxlength' => true, 'placeholder' => 'Reference Code']) ?>

        </div>
        <div class='col-md-4 col-xs-12 left_padd'>    
            <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'Email']) ?>

        </div>
        <div class='col-md-4 col-xs-12 left_padd'>    
            <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true, 'placeholder' => 'Phone Number']) ?>

        </div>
        <div class='col-md-4 col-xs-12 left_padd'>    
            <?= $form->field($model, 'address')->textInput(['maxlength' => true, 'placeholder' => 'Address']) ?>

        </div>
        <div class='col-md-4 col-xs-12 left_padd'>    
            <?= $form->field($model, 'contact_person')->textInput(['maxlength' => true, 'placeholder' => 'Contact Person']) ?>

        </div>
        <div class='col-md-4 col-xs-12 left_padd'>    
            <?= $form->field($model, 'contact_person_email')->textInput(['maxlength' => true, 'placeholder' => 'Contact Person Email']) ?>

        </div>
        <div class='col-md-4 col-xs-12 left_padd'>    
            <?= $form->field($model, 'contact_person_phone')->textInput(['maxlength' => true, 'placeholder' => 'Contact Person Phone']) ?>

        </div>
        <div class='col-md-4 col-xs-12 left_padd'> 
            <?php $countries = ArrayHelper::map(Country::findAll(['status' => 1]), 'id', 'country_name'); ?>
            <?= $form->field($model, 'nationality')->dropDownList($countries, ['prompt' => 'Choose Nationality']) ?>

        </div>
    </div>
    <div class="row">
        <div class='col-md-8 col-xs-12 left_padd'>    
            <?= $form->field($model, 'comment')->textarea(['rows' => 6, 'placeholder' => 'Comment']) ?>

        </div>
        <div class='col-md-4 col-xs-12 left_padd'> 
            <div class='col-md-12 col-xs-12 pad-0'> 
                <?= $form->field($model, 'TRN')->textInput(['maxlength' => true, 'placeholder' => 'TRN']) ?>
            </div>
            <div class='col-md-12 col-xs-12 pad-0'> 
                <?= $form->field($model, 'status')->dropDownList(['1' => 'Enabled', '0' => 'Disabled']) ?>
            </div>
        </div>
        <div class='col-md-4 col-xs-12 left_padd'>    

        </div> </div>


    <div class="form-group action-btn-right">
        <?= Html::a('<span> Cancel</span>', ['index'], ['class' => 'btn btn-block cancel-btn']) ?>
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
