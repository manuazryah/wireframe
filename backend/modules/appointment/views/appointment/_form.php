<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Debtor;
use common\models\Tax;
use common\models\AppointmentServices;
use common\models\Sponsor;
use common\models\RealEstateDetails;
use common\models\RealEstateMaster;

/* @var $this yii\web\View */
/* @var $model common\models\Appointment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="appointment-form form-inline">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class='col-md-3 col-sm-6 col-xs-12 left_padd'> 
            <?php $customers = ArrayHelper::map(Debtor::findAll(['status' => 1]), 'id', 'company_name'); ?>
            <?= $form->field($model, 'customer')->dropDownList($customers, ['prompt' => 'Choose Customer']) ?>

        </div>
        <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>   
            <?php $service_types = ArrayHelper::map(AppointmentServices::findAll(['status' => 1]), 'id', 'service'); ?>
            <?= $form->field($model, 'service_type')->dropDownList($service_types, ['prompt' => 'Choose Service']) ?>

        </div>
        <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>  
            <?php
            $plots = ArrayHelper::map(RealEstateDetails::find()->where(['status' => 1, 'category' => 2])->all(), 'id', function($model) {
                        return common\models\RealEstateMaster::findOne($model['master_id'])->reference_code . ' - ' . $model['code'];
                    }
            );
            ?>
            <?= $form->field($model, 'plot')->dropDownList($plots, ['prompt' => 'Choose a Plot']) ?>

        </div>
        <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>  
            <?php
            $licenses = ArrayHelper::map(RealEstateDetails::find()->where(['status' => 1, 'category' => 1])->all(), 'id', function($model) {
                        return common\models\RealEstateMaster::findOne($model['master_id'])->reference_code . ' - ' . $model['code'];
                    }
            );
            ?>
            <?= $form->field($model, 'space_for_license')->dropDownList($licenses, ['prompt' => 'Space for License']) ?>

        </div>
    </div>
    <div class="row">
        <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
            <?php
            if ($model->isNewRecord) {
                $model->service_id = $this->context->generateServiceNo();
            }
            ?>
            <?= $form->field($model, 'service_id')->textInput(['maxlength' => true, 'readonly' => TRUE]) ?>

        </div>
        <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>    
            <?= $form->field($model, 'estimated_cost')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>  
            <?php $sponsors = ArrayHelper::map(Sponsor::findAll(['status' => 1]), 'id', 'name'); ?>
            <?= $form->field($model, 'sponsor')->dropDownList($sponsors, ['prompt' => 'Choose Sponsor']) ?>

        </div>
        <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>  
            <?php $taxs = ArrayHelper::map(Tax::findAll(['status' => 1]), 'id', 'name'); ?>
            <?= $form->field($model, 'tax')->dropDownList($taxs, ['prompt' => 'Choose Tax']) ?>

        </div>
    </div>
    <div class="row">
        <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>    
            <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>    
           <?= $form->field($model, 'status')->dropDownList(['1' => 'Enabled', '0' => 'Disabled']) ?>

        </div>
    </div>


    <div class="form-group action-btn-right">
        <?= Html::a('<span> Cancel</span>', ['index'], ['class' => 'btn btn-block cancel-btn']) ?>
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
