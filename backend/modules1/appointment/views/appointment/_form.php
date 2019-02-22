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
    <?= \common\components\AlertMessageWidget::widget() ?>
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>
            <?php $customers = ArrayHelper::map(Debtor::findAll(['status' => 1]), 'id', 'company_name'); ?>
            <?php
            echo $form->field($model, 'customer')->widget(Select2::classname(), [
                'data' => $customers,
                'language' => 'en',
                'options' => ['placeholder' => 'Choose Customer', 'autofocus' => 'true'],
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
                if ($model->service_type != 5) {
                    if ($model->plot == '') {
                        $plots = ArrayHelper::map(RealEstateDetails::find()->where(['status' => 1, 'category' => 2, 'type' => 0])->all(), 'id', function($model) {
                                    return common\models\RealEstateMaster::findOne($model['master_id'])->reference_code . ' - ' . $model['code'];
                                }
                        );
                    } else {
                        $plots = ArrayHelper::map(RealEstateDetails::find()->where(['status' => 1, 'category' => 2, 'type' => 0])->orWhere(['in', 'id', explode(',', $model->plot)])->all(), 'id', function($model) {
                                    return common\models\RealEstateMaster::findOne($model['master_id'])->reference_code . ' - ' . $model['code'];
                                }
                        );
                    }
                } else {
                    $plots = ArrayHelper::map(RealEstateDetails::find()->where(['status' => 1, 'category' => 2])->all(), 'id', function($model) {
                                return common\models\RealEstateMaster::findOne($model['master_id'])->reference_code . ' - ' . $model['code'];
                            }
                    );
                }
            }
            ?>
            <?php
            if (!$model->isNewRecord) {
                $model->plot = explode(',', $model->plot);
            }
            ?>
            <?php
            echo $form->field($model, 'plot')->widget(Select2::classname(), [
                'data' => $plots,
                'language' => 'en',
                'options' => ['placeholder' => 'Choose Plot', 'multiple' => true, 'disabled' => $model->service_type == 2 || $model->service_type == 4 ? TRUE : FALSE,],
                'pluginOptions' => [
                    'allowClear' => true,
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
                if ($model->service_type != 5) {
                    if ($model->space_for_license == '') {
                        $licenses = ArrayHelper::map(RealEstateDetails::find()->where(['status' => 1, 'category' => 1, 'type' => 0])->all(), 'id', function($model) {
                                    return common\models\RealEstateMaster::findOne($model['master_id'])->reference_code . ' - ' . $model['code'];
                                }
                        );
                    } else {
                        $licenses = ArrayHelper::map(RealEstateDetails::find()->where(['status' => 1, 'category' => 1, 'type' => 0])->orWhere(['in', 'id', explode(',', $model->space_for_license)])->all(), 'id', function($model) {
                                    return common\models\RealEstateMaster::findOne($model['master_id'])->reference_code . ' - ' . $model['code'];
                                }
                        );
                    }
                } else {
                    $licenses = ArrayHelper::map(RealEstateDetails::find()->where(['status' => 1, 'category' => 1, 'type' => 1])->all(), 'id', function($model) {
                                return common\models\RealEstateMaster::findOne($model['master_id'])->reference_code . ' - ' . $model['code'];
                            }
                    );
                }
            }
            ?>
            <?php
            if (!$model->isNewRecord) {
                $model->space_for_license = explode(',', $model->space_for_license);
            }
            ?>
            <?php
            echo $form->field($model, 'space_for_license')->widget(Select2::classname(), [
                'data' => $licenses,
                'language' => 'en',
                'options' => ['placeholder' => 'Choose License', 'multiple' => true, 'disabled' => $model->service_type == 1 || $model->service_type == 4 ? TRUE : FALSE],
                'pluginOptions' => [
                    'allowClear' => true,
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
            <?= $form->field($model, 'service_cost')->textInput(['maxlength' => true]) ?>

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
            <?php $salesman = ArrayHelper::map(\common\models\AdminUsers::findAll(['status' => 1]), 'id', 'name'); ?>
            <?= $form->field($model, 'sales_man')->dropDownList($salesman, ['prompt' => 'Choose Salesman']) ?>

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
            var type = $(this).val();
            var idd = '<?php echo $model->id; ?>';
            $('#appointment-plot').val('').trigger('change');
            $('#appointment-space_for_license').val('').trigger('change');
            if (type != '') {
                $.ajax({
                    type: 'POST',
                    cache: false,
                    async: false,
                    data: {type: type, id: idd},
                    url: '<?= Yii::$app->homeUrl; ?>appointment/appointment/get-plots',
                    success: function (data) {
                        var res = $.parseJSON(data);
                        $("#appointment-plot").html(res.result['plots']);
                        $("#appointment-space_for_license").html(res.result['license']);
                        e.preventDefault();
                    }
                });
            }
            if (type == 1) {
                $(".field-appointment-service_cost .control-label").text("Estimate to  Office Rent");
                $("#appointment-plot").prop("disabled", false);
                $("#appointment-space_for_license").prop("disabled", true);
                $("#appointment-service_cost").prop("disabled", false);
            } else if (type == 2) {
                $(".field-appointment-service_cost .control-label").text("Ejari cost");
                $("#appointment-plot").prop("disabled", true);
                $("#appointment-space_for_license").prop("disabled", false);
                $("#appointment-service_cost").prop("disabled", false);
            } else if (type == 3) {
                $(".field-appointment-service_cost .control-label").text("Office rent");
                $("#appointment-plot").prop("disabled", false);
                $("#appointment-space_for_license").prop("disabled", false);
                $("#appointment-service_cost").prop("disabled", false);
            } else if (type == 4) {
                $(".field-appointment-service_cost .control-label").text("Sponsorship cost");
                $("#appointment-plot").prop("disabled", true);
                $("#appointment-space_for_license").prop("disabled", true);
                $("#appointment-service_cost").prop("disabled", false);
            } else if (type == 5) {
                $("#appointment-service_cost").val("");
                $(".field-appointment-service_cost .control-label").text("");
                $("#appointment-plot").prop("disabled", false);
                $("#appointment-space_for_license").prop("disabled", false);
                $("#appointment-service_cost").prop("disabled", true);
            } else {
                $(".field-appointment-service_cost .control-label").text("");
                $("#appointment-service_cost").prop("disabled", true);
            }

        });
        $(document).on('change', '#appointment-space_for_license', function (e) {
            var space = $(this).val();
            var idd = '<?php echo $model->id; ?>';
            if (space == "") {
                $("#appointment-sponsor").val(null).trigger("change");
            } else {
//                if (idd === "") {
                $.ajax({
                    type: 'POST',
                    cache: false,
                    async: false,
                    data: {space: space},
                    url: '<?= Yii::$app->homeUrl; ?>appointment/appointment/get-supplier',
                    success: function (data) {
                        if (data === '') {
                            $("#appointment-sponsor").val(null).trigger("change");
                        } else {
                            $("#appointment-sponsor").val(data).trigger("change");
                        }
                        e.preventDefault();
                    }
                });
//                }
            }
        });
    });
    function setLabel() {
        var type = $('#appointment-service_type').val();
        if (type == 1) {
            $(".field-appointment-service_cost .control-label").text("Estimate to  Office Rent");
            $("#appointment-service_cost").prop("disabled", false);
        } else if (type == 2) {
            $(".field-appointment-service_cost .control-label").text("Ejari cost");
            $("#appointment-service_cost").prop("disabled", false);
        } else if (type == 3) {
            $(".field-appointment-service_cost .control-label").text("Office rent");
            $("#appointment-service_cost").prop("disabled", false);
        } else if (type == 4) {
            $(".field-appointment-service_cost .control-label").text("Sponsorship cost");
            $("#appointment-service_cost").prop("disabled", false);
        } else if (type == 5) {
            $(".field-appointment-service_cost .control-label").text("");
            $("#appointment-service_cost").prop("disabled", true);
        } else {
            $(".field-appointment-service_cost .control-label").text("");
            $("#appointment-service_cost").prop("disabled", true);
        }
    }
</script>
