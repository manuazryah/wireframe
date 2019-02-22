<?php

use yii\helpers\Html;
use common\models\Services;

/* @var $this yii\web\View */
/* @var $model common\models\Appointment */

$this->title = 'Appointment : ' . $model->service_id;
$this->params['breadcrumbs'][] = ['label' => 'Appointments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Default box -->
<div class="box">
    <div class="appointment-view">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <?= Html::a('<span> Manage Appointment</span>', ['index'], ['class' => 'btn btn-warning mrg-bot-15']) ?>
            <?= Html::a('<span> Generate Quotation</span>', ['/appointment/appointment-service/quotation', 'id' => $model->id], ['class' => 'btn btn-block manage-btn', 'style' => 'float:right;', 'target' => '_blank']) ?>
            <h4>Appointment Details</h4>
            <div class="appointment-history">
                <table class="table table-responsive">
                    <tr>
                        <th>Customer Name</th>
                        <td>: <?= $model->customer != '' ? \common\models\Debtor::findOne($model->customer)->company_name : '' ?></td>
                        <th>Service Type</th>
                        <td>: <?= $model->service_type != '' ? \common\models\AppointmentServices::findOne($model->service_type)->service : '' ?></td>
                    </tr>
                    <tr>
                        <th>Service ID</th>
                        <td>: <?= $model->service_id ?></td>
                        <th>Sponsor</th>
                        <td>: <?= $model->sponsor != '' ? \common\models\Sponsor::findOne($model->sponsor)->name : '' ?></td>
                    </tr>
                    <tr>
                        <th>Reference Code</th>
                        <td>: <?= $model->customer != '' ? \common\models\Debtor::findOne($model->customer)->reference_code : '' ?></td>
                        <th></th>
                        <td></td>
                    </tr>
                </table>
            </div>
            <h4>Appointment Services</h4><hr>
            <div class="appointment-service-create">
                <table class="table table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th>Particular</th>
                            <th>Comment</th>
                            <th>Amount</th>
                            <th>Tax</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($services)) {
                            $amount_tot = 0;
                            $tax_tot = 0;
                            $grand_tot = 0;
                            foreach ($services as $service) {
                                ?>
                                <tr>
                                    <td><?= Services::findOne($service->service)->service_name ?></td>
                                    <td class="edit_text" id="<?= $service->id ?>-comment" val="<?= $service->comment ?>">
                                        <?php
                                        if ($service->comment == '') {
                                            echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                        } else {
                                            echo $service->comment;
                                        }
                                        ?>
                                    </td>
                                    <td style="text-align: right;" class="edit_text" id="<?= $service->id ?>-amount" val="<?= $service->amount ?>">
                                        <?php
                                        if ($service->amount == '') {
                                            echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                        } else {
                                            echo $service->amount;
                                        }
                                        ?>
                                    </td>
                                    <td style="text-align: right;" class="edit_dropdown" drop_id="appointmentservice-tax" id="<?= $service->id ?>-tax" val="<?= $service->tax ?>">
                                        <?php
                                        if ($service->tax == '') {
                                            echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                        } else {
                                            ?>
                                            <?= $service->tax_percentage != '' && $service->tax_percentage > 0 ? $service->tax_percentage : '' ?> <?= $service->tax_percentage != '' ? '%' : '' ?>
                                        <?php }
                                        ?>

                                    </td>
                                    <td style="text-align: right;" class="total-<?= $service->id ?>"><?= $service->total ?></td>
                                </tr>
                                <?php
                                $amount_tot += $service->amount;
                                $tax_tot += $service->tax_amount;
                                $grand_tot += $service->total;
                            }
                            ?>
                            <tr>
                                <td colspan="2" style="text-align: right;">Total</td>
                                <td style="text-align: right;"><?= sprintf('%0.2f', $amount_tot); ?></td>
                                <td style="text-align: right;"><?= sprintf('%0.2f', $tax_tot); ?></td>
                                <td style="text-align: right;"><?= sprintf('%0.2f', $grand_tot); ?></td>
                            </tr>

                        <?php }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.box -->


