<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use common\models\CompanyManagement;
use yii\helpers\ArrayHelper;
use common\models\Sponsor;

/* @var $this yii\web\View */
/* @var $model common\models\RealEstateMasterSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="real-estate-master-search">

    <?php
    $form = ActiveForm::begin([
                'action' => ['realestate-report'],
                'method' => 'get',
    ]);
    ?>
    <div class="row">
        <div class='col-md-4  col-xs-12 left_padd'>
            <?php $companies = ArrayHelper::map(CompanyManagement::findAll(['status' => 1]), 'id', 'company_name'); ?>
            <?php
            echo $form->field($model, 'company')->widget(Select2::classname(), [
                'data' => $companies,
                'language' => 'en',
                'options' => ['placeholder' => 'Choose Realestate'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Realestate');
            ?>

        </div>
        <div class='col-md-4  col-xs-12 left_padd'>
            <?php $sponsors = ArrayHelper::map(Sponsor::findAll(['status' => 1]), 'id', 'name'); ?>
            <?php
            echo $form->field($model, 'sponsor')->widget(Select2::classname(), [
                'data' => $sponsors,
                'language' => 'en',
                'options' => ['placeholder' => 'Choose Sponsor'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>

        </div>
        <div class='col-md-4  col-xs-12 left_padd'>
            <div class="form-group">
                <?= Html::submitButton('Search', ['class' => 'btn btn-primary', 'style' => 'margin-top: 25px;']) ?>
                <?= Html::a('Reset', ['realestate-report'], ['class' => 'btn btn-default', 'style' => 'margin-top: 25px;']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
