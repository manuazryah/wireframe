<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PartnerDetails */

$this->title = 'Add Partner Details';
$this->params['breadcrumbs'][] = ['label' => 'Partner Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Default box -->
<div class="">
    <div class="box-body">
        <div class="partner-details-create">
            <div class="partner-details-form form-inline">

                <?php $form = ActiveForm::begin(['id' => 'partner-form']); ?>
                <div class="row">
                    <?php
                    if ($model->isNewRecord) {
                        $model->appointment_id = $license_master->appointment_id;
                    }
                    ?>
                    <?= $form->field($model, 'appointment_id')->hiddenInput()->label(FALSE) ?>
                    <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>    
                        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>   
                        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>    
                        <?= $form->field($model, 'phone_no')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>    
                        <?= $form->field($model, 'address')->textarea(['rows' => 3]) ?>
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
<script>
    $("document").ready(function () {
        $(document).on('submit', '#partner-form', function (e) {
            var id = '<?php echo $model->id; ?>';
            var app_id = '<?php echo $license_master->appointment_id; ?>';
            var partner_name = $('#partnerdetails-name').val();
            $.ajax({
                type: 'POST',
                cache: false,
                async: false,
                data: {id: id, app_id: app_id, partner_name: partner_name},
                url: '<?= Yii::$app->homeUrl; ?>licence_procedure/licencing-master/check-partner',
                success: function (data) {
                    if (data == 1) {
                        if ($("#space").length <= 0) {
                            $('#partnerdetails-name').after('<div id="space" style="color:red">This name is alredy taken.Please try another name.</div>');
                        }
                        e.preventDefault();
                    } else {
                        $("#space").remove();
                    }
                }
            });
        });
    });
</script>

