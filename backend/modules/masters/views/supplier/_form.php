<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Supplier */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="supplier-form form-inline">
    <?= \common\components\AlertMessageWidget::widget() ?>
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'company_name')->textInput(['maxlength' => true]) ?>

        </div><div class='col-md-4 col-xs-12 left_padd'>    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

        </div><div class='col-md-4 col-xs-12 left_padd'>    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

        </div><div class='col-md-4 col-xs-12 left_padd'>    <?= $form->field($model, 'contact_person')->textInput(['maxlength' => true]) ?>

        </div><div class='col-md-4 col-xs-12 left_padd'>    <?= $form->field($model, 'phone1')->textInput(['maxlength' => true]) ?>

        </div><div class='col-md-4 col-xs-12 left_padd'>    <?= $form->field($model, 'phone2')->textInput(['maxlength' => true]) ?>

        </div>
    </div>
    <div class="row">
        <div class='col-md-8 col-xs-12 left_padd'>    
            <?= $form->field($model, 'comment')->textarea(['rows' => 3]) ?>

        </div>
        <div class='col-md-4 col-xs-12 left_padd'>   
            <?= $form->field($model, 'status')->dropDownList(['1' => 'Enabled', '0' => 'Disabled']) ?>
        </div>
    </div>


    <div class="form-group action-btn-right">
        <?= Html::a('<span> Cancel</span>', ['index'], ['class' => 'btn btn-block cancel-btn']) ?>
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
