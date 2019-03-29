<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\RealEstateDetails */

$this->title = 'Update Real Estate Details';
$this->params['breadcrumbs'][] = ['label' => 'Real Estate Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<!-- Default box -->
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <section id="tabs">
            <div class="card1">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation">
                        <?php
                        echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">General Details</span>', ['update', 'id' => $real_estate_master->id]);
                        ?>
                    </li>
                    <li role="presentation" class="active">
                        <?php
                        echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Real Estate Details</span>', ['real-estate-details', 'id' => $real_estate_master->id]);
                        ?>
                    </li>
                </ul>
            </div>
        </section>
        <div class="real-estate-details-update">
            <div class="real-estate-details-form form-inline">
                <?= \common\components\AlertMessageWidget::widget() ?>
                <?php $form = ActiveForm::begin(); ?>
                <div class="row">
                    <div class='col-md-3 col-sm-6 col-xs-12 left_padd'> 
                        <?= $form->field($model, 'category')->dropDownList(['1' => 'License', '2' => 'Plots'], ["disabled" => "disabled"]) ?>

                    </div>
                    <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>    
                        <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

                    </div>
                    <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>  
                        <?= $form->field($model, 'availability')->dropDownList(['0' => 'Occupied', '1' => 'Not Occupied']) ?>

                    </div>
                    <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'customer_id')->textInput() ?>

                    </div>
                    <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'cost')->textInput(['maxlength' => true]) ?>

                    </div>
                    <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'rent_cost')->textInput() ?>

                    </div>
                    <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'off_rent')->textInput() ?>

                    </div>
                    <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'square_feet')->textInput(['maxlength' => true]) ?>

                    </div>
                    <div class='col-md-12 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'comment')->textarea(['rows' => 2]) ?>

                    </div>
                </div>

                <div class="form-group action-btn-right">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
                </div>


                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->