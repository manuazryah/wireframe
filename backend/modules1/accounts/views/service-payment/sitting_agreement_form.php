<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model common\models\SideAgreement */

$this->title = 'Sitting Agreement';
$this->params['breadcrumbs'][] = ['label' => 'Side Agreements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Default box -->
<div class="">
    <div class="box-header with-border">
        <button type="button" class="close" data-dismiss="modal" id="trigger_close" aria-label="Close">
            <span aria-hidden="true">×</span></button>
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <div class="side-agreement-create">
            <div class="side-agreement-form form-inline">

                <?php $form = ActiveForm::begin(['id' => 'sitting-agreement-form',]); ?>
                <div class="row">
                    <input type="hidden" id="sittingagreement-appointment_id" class="form-control" name="SittingAgreement[appointment_id]" value="<?= $id ?>">
                    <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>    
                        <?= $form->field($model, 'company_name')->textInput(['required' => true]) ?>

                    </div>
                    <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>    
                        <?= $form->field($model, 'represented_by')->textInput(['required' => true]) ?>

                    </div>
                    <div class='col-md-4 col-sm-6 col-xs-12 left_padd'> 
                        <div class="form-group">
                            <label class="control-label">Date</label>

                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input id="sittingagreement-date" name="SittingAgreement[date]" type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask required value="<?= $model->date != '' ? date("d/m/Y", strtotime($model->date)) : '' ?>">
                            </div>
                            <!-- /.input group -->
                        </div>
                    </div>
                    <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'office_no')->textInput(['required' => true]) ?>

                    </div>
                    <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'office_address')->textInput(['required' => true]) ?>

                    </div>
                    <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'location')->textInput(['required' => true]) ?>

                    </div>
                    <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'activity')->textInput(['required' => true]) ?>

                    </div>
                </div>
                <div class="row">
                    <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
                        <div class="form-group action-btn-right">
                            <?= Html::submitButton('Generate Agreement', ['class' => 'btn btn-success']) ?>
                        </div>
                    </div>
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
        $('#sitting-agreement-form').submit(function (e) {
            e.preventDefault();
            $.ajax({
                url: '<?= Yii::$app->homeUrl; ?>accounts/service-payment/save-sitting-agreement',
                type: "POST",
                data: $(this).serialize(),
                success: function (data) {
                    $('#modal-default').modal('hide');
                    window.open(data, '_blank');
//                    window.open(data, "mywindow", "menubar=1,resizable=1,width=1000,height=500");
                }
            });
        });
    });
</script>
