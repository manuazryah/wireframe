<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AppointmentService */

$this->title = 'Add Services';
$this->params['breadcrumbs'][] = ['label' => 'Appointment Services', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Default box -->
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <div class="app-nav">
            <ul class="nav nav-tabs nav-tabs-justified">
                <li class="">
                    <?php
                     echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Appointment</span>', ['appointment/update', 'id' => $appointment->id]);
                    ?>

                </li>
                <li class="active">
                    <?php
                    echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Services</span>', ['appointment-service/add', 'id' => $appointment->id]);
                    ?>

                </li>
            </ul>
        </div>
        <div class="appointment-history">
            <table class="table table-responsive">
                <tr>
                    <th>Customer Name</th>
                    <td>: <?= $appointment->customer != ''?\common\models\Debtor::findOne($appointment->customer)->company_name : '' ?></td>
                    <th>Service Type</th>
                    <td>: <?= $appointment->service_type != ''? \common\models\AppointmentServices::findOne($appointment->service_type)->service : '' ?></td>
                </tr>
                <tr>
                    <th>Service ID</th>
                    <td>: <?= $appointment->service_id ?></td>
                    <th>Sponsor</th>
                    <td>: <?= $appointment->sponsor != ''? \common\models\Sponsor::findOne($appointment->sponsor)->name : '' ?></td>
                </tr>
            </table>
        </div>
        <div class="appointment-service-create">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>Particular</th>
                        <th>Comment</th>
                        <th>Amount</th>
                        <th>Tax</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $form = ActiveForm::begin(); ?>
                    <tr>
                        <td><?= $form->field($model, 'service')->textInput()->label(FALSE) ?></td>
                        <td><?= $form->field($model, 'comment')->textInput()->label(FALSE) ?></td>
                        <td><?= $form->field($model, 'amount')->textInput(['maxlength' => true])->label(FALSE) ?></td>
                        <td><?= $form->field($model, 'tax')->textInput()->label(FALSE) ?></td>
                        <td><?= $form->field($model, 'total')->textInput(['maxlength' => true])->label(FALSE) ?></td>
                        <td><?= Html::submitButton($model->isNewRecord ? 'Add' : 'Update', ['class' => 'btn btn-success']) ?></td>
                    </tr>
                     <?php ActiveForm::end(); ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->

