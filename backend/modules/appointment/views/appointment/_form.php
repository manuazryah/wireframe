<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Debtor;
use common\models\Tax;
use common\models\AppointmentServices;
use common\models\Sponsor;
use common\models\RealEstateDetails;
use yii\helpers\Url;
use kartik\select2\Select2;
use common\components\ModalViewWidget;

/* @var $this yii\web\View */
/* @var $model common\models\Appointment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="appointment-form form-inline">
    <?php
    echo ModalViewWidget::widget();
    ?>
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
            <?php $customers = ArrayHelper::map(Debtor::findAll(['status' => 1]), 'id', 'company_name'); ?>
            <?php
            echo $form->field($model, 'customer')->widget(Select2::classname(), [
                'data' => $customers,
                'language' => 'en',
                'options' => ['placeholder' => 'Choose Customer'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>
            <?= Html::button('<span> Not in the list ? Add New</span>', ['value' => Url::to('../appointment/add-customer'), 'class' => 'btn-add modalButton']) ?>

        </div>
        <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
            <?php $service_types = ArrayHelper::map(AppointmentServices::findAll(['status' => 1]), 'id', 'service'); ?>
            <?= $form->field($model, 'service_type')->dropDownList($service_types, ['prompt' => 'Choose Service']) ?>

        </div>
        <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
            <?php
            if ($model->isNewRecord) {
                $plots = ArrayHelper::map(RealEstateDetails::find()->where(['status' => 1, 'category' => 2, 'availability' => 1])->all(), 'id', function($model) {
                            return common\models\RealEstateMaster::findOne($model['master_id'])->reference_code . ' - ' . $model['code'];
                        }
                );
            } else {
                $plots = ArrayHelper::map(RealEstateDetails::find()->where(['status' => 1, 'category' => 2])->all(), 'id', function($model) {
                            return common\models\RealEstateMaster::findOne($model['master_id'])->reference_code . ' - ' . $model['code'];
                        }
                );
            }
            ?>
            <?php
            echo $form->field($model, 'plot')->widget(Select2::classname(), [
                'data' => $plots,
                'language' => 'en',
                'options' => ['placeholder' => 'Choose a Plot'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>

        </div>
        <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
            <?php
            if ($model->isNewRecord) {
                $licenses = ArrayHelper::map(RealEstateDetails::find()->where(['status' => 1, 'category' => 1, 'availability' => 1])->all(), 'id', function($model) {
                            return common\models\RealEstateMaster::findOne($model['master_id'])->reference_code . ' - ' . $model['code'];
                        }
                );
            } else {
                $licenses = ArrayHelper::map(RealEstateDetails::find()->where(['status' => 1, 'category' => 1])->all(), 'id', function($model) {
                            return common\models\RealEstateMaster::findOne($model['master_id'])->reference_code . ' - ' . $model['code'];
                        }
                );
            }
            ?>
            <?php
            echo $form->field($model, 'space_for_license')->widget(Select2::classname(), [
                'data' => $licenses,
                'language' => 'en',
                'options' => ['placeholder' => 'Space for License'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            ?>

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
        <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
            <?php $taxs = ArrayHelper::map(Tax::findAll(['status' => 1]), 'id', 'name'); ?>
            <?= $form->field($model, 'tax')->dropDownList($taxs, ['prompt' => 'Choose Tax']) ?>

        </div>
    </div>
    <div class="row">
        <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
            <?php $salesman = ArrayHelper::map(\common\models\AdminUsers::findAll(['status' => 1]), 'id', 'name'); ?>
            <?= $form->field($model, 'sales_man')->dropDownList($salesman, ['prompt' => 'Choose Salesman']) ?>

        </div>
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
<script>
    $("document").ready(function () {
        $(document).on('click', '.modalButton', function () {
            $('#modal').modal('show')
                    .find('#modalContent')
                    .load($(this).attr("value"));
        });
    });
</script>
<script>
    $("document").ready(function () {
        $(document).on('change', '#appointment-service_type', function (e) {
            $("#appointment-plot").val('');
            $("#appointment-space_for_license").val('');
            var type = $(this).val();
            if (type == 1) {
                $("#appointment-plot").prop("disabled", false);
                $("#appointment-space_for_license").prop("disabled", true);
            } else if (type == 2) {
                $("#appointment-plot").prop("disabled", true);
                $("#appointment-space_for_license").prop("disabled", false);
            } else if (type == 3) {
                $("#appointment-plot").prop("disabled", false);
                $("#appointment-space_for_license").prop("disabled", false);
            }
        });
    });
</script>
