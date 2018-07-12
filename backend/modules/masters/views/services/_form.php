<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Tax;
use common\models\ServiceType;
use common\models\ServiceCategory;


/* @var $this yii\web\View */
/* @var $model common\models\Services */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="services-form form-inline">
    <?= \common\components\AlertMessageWidget::widget() ?>
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'> 
             <?php $service_category = ArrayHelper::map(ServiceCategory::findAll(['status' => 1]), 'id', 'category_name'); ?>
            <?= $form->field($model, 'service_category')->dropDownList($service_category, ['prompt' => 'Service Category']) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'> 
            <?php $service_type = ArrayHelper::map(ServiceType::findAll(['status' => 1]), 'id', 'type'); ?>
            <?= $form->field($model, 'type')->dropDownList($service_type, ['prompt' => 'Service Type']) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>    
            <?= $form->field($model, 'service_name')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>    
            <?= $form->field($model, 'service_code')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>    
            <?= $form->field($model, 'supplier')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>    
            <?= $form->field($model, 'estimated_cost')->textInput(['maxlength' => true]) ?>

        </div>
    </div>
    <div class="row">
        <div class='col-md-8 col-sm-6 col-xs-12 left_padd'> 
            <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'> 
            <div class='col-md-12 col-xs-12 pad-0'> 
                <?php $tax = ArrayHelper::map(Tax::findAll(['status' => 1]), 'id', 'name'); ?>
            <?= $form->field($model, 'tax_id')->dropDownList($tax, ['prompt' => 'Tax']) ?>
            </div>
            <div class='col-md-12 col-xs-12 pad-0'> 
                <?= $form->field($model, 'status')->dropDownList(['1' => 'Enabled', '0' => 'Disabled']) ?>
            </div>
        </div>
    </div>


    <div class="form-group action-btn-right">
        <?= Html::a('<span> Cancel</span>', ['index'], ['class' => 'btn btn-block cancel-btn']) ?>
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
