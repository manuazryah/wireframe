<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LicencingMaster */

$this->title = 'License Procedure';
$this->params['breadcrumbs'][] = ['label' => 'Licencing Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<!-- Default box -->
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <?= Html::a('<span> Manage License Procedure</span>', ['index'], ['class' => 'btn btn-block manage-btn']) ?>
        <div class="licencing-master-update">
            <div class="test-form form-inline">

                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                        <section id="tabs">
                            <div class="card">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation"><a href="#step1" aria-controls="home" role="tab" data-toggle="tab">Step 1</a></li>
                                    <li role="presentation" class="active"><a href="#step2" aria-controls="profile" role="tab" data-toggle="tab">Step 2</a></li>
                                    <li role="presentation"><a href="#step3" aria-controls="messages" role="tab" data-toggle="tab">Step 3</a></li>
                                    <li role="presentation"><a href="#step4" aria-controls="settings" role="tab" data-toggle="tab">Step 4</a></li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="step1">
                                        <h3 class="heading">MOA</h3>
                                        <?= common\components\AppointmentWidget::widget(['id' => $license_master->appointment_id]) ?>
                                        <?= common\components\ExpenseWidget::widget(['id' => $license_master->appointment_id]) ?>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pad-0">
                                            <div class="form-box">
                                                <?php $form = ActiveForm::begin(); ?>
                                                <div class="row">

                                                    <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
                                                        <?= $form->field($model, 'online_reference_number')->textInput(['maxlength' => true, 'autofocus' => 'true']) ?>

                                                    </div>
                                                    <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
                                                        <?= $form->field($model, 'online_application_fees')->textInput(['maxlength' => true]) ?>

                                                    </div>
                                                    <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>
                                                        <?= $form->field($model, 'payment_receipt')->fileInput(['class' => 'form-control']) ?>

                                                    </div>
                                                    <div class='col-md-8 col-sm-6 col-xs-12 left_padd'>
                                                        <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

                                                    </div>
                                                </div>


                                                <div class="form-group action-btn-right">
                                                    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                                                </div>


                                                <?php ActiveForm::end(); ?>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="next-step">
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 pad-0 fright">
                                                <?= Html::a('<span> Completed and procced to next</span>', ['payment-voucher', 'id' => $license_master->id], ['class' => 'button green']) ?>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 fright">

                                                <select class="form-control">
                                                    <option value="">Select Step</option>
                                                    <option value="1">Step1</option>
                                                    <option value="2">Step2</option>
                                                    <option value="3">Step3</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </section>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="right-box">
                            <h3 class="heading">Documents</h3>
                            <div class="panel-group" id="accordionMenu" role="tablist" aria-multiselectable="true">
                                <?= common\components\DocumentLinksWidget::widget(['id' => $license_master->id]) ?>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->