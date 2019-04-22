<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use common\models\Services;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AppointmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Accounts Payment(Appointments)';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Default box -->
<div class="box table-responsive">
    <div class="appointment-index">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>

        <div class="box-body table-responsive">
            <?= Html::a('<span> Manage Accounts</span>', ['index'], ['class' => 'btn btn-block manage-btn']) ?>
            <section id="tabs1">
                <div class="card1">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation">
                            <?php
                            echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Step 1</span>', ['service-payment/service-payment', 'id' => $id]);
                            ?>
                        </li>
                        <li role="presentation">
                            <?php
                            echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Step 2</span>', ['service-payment/service-payment-details', 'id' => $id]);
                            ?>
                        </li>
                        <li role="presentation" class="active">
                            <?php
                            echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Step 3</span>', ['service-payment/payment', 'id' => $id]);
                            ?>
                        </li>
                    </ul>
                </div>
            </section>
            <div class="appointment-history">
                <table class="table table-responsive">
                    <tr>
                        <th>Customer Name</th>
                        <td>: <?= $appointment->customer != '' ? \common\models\Debtor::findOne($appointment->customer)->company_name : '' ?></td>
                        <th>Service Type</th>
                        <td>: <?= $appointment->service_type != '' ? \common\models\AppointmentServices::findOne($appointment->service_type)->service : '' ?></td>
                    </tr>
                    <tr>
                        <th>Service ID</th>
                        <td>: <?= $appointment->service_id ?></td>
                        <th>Sponsor</th>
                        <td>: <?= $appointment->sponsor != '' ? \common\models\Sponsor::findOne($appointment->sponsor)->name : '' ?></td>
                    </tr>
                    <tr>
                        <th>Office ID</th>
                        <?php
                        $plot_id = '';
                        $licence_id = '';
                        $off_id = '';
                        if ($appointment->plot != '') {
                            $plot_dtl = \common\models\RealEstateDetails::find()->where(['id' => $appointment->plot])->one();
                            if (!empty($plot_dtl)) {
                                $plot_id = common\models\RealEstateMaster::findOne($plot_dtl->master_id)->reference_code . ' - ' . $plot_dtl->code;
                            }
                        }
                        if ($appointment->space_for_license != '') {
                            $licence_dtl = \common\models\RealEstateDetails::find()->where(['id' => $appointment->space_for_license])->one();
                            if (!empty($licence_dtl)) {
                                $licence_id = common\models\RealEstateMaster::findOne($licence_dtl->master_id)->reference_code . ' - ' . $licence_dtl->code;
                            }
                        }
                        if ($licence_id != '' && $plot_id != '') {
                            $off_id = $plot_id . ', ' . $licence_id;
                        } elseif ($licence_id == '' && $plot_id != '') {
                            $off_id = $plot_id;
                        } elseif ($licence_id != '' && $plot_id == '') {
                            $off_id = $licence_id;
                        }
                        ?>
                        <td>: <?= $off_id ?></td>
                        <th></th>
                        <td></td>
                    </tr>
                </table>
            </div>
            <?= \common\components\AlertMessageWidget::widget() ?>
            <?php
            $form = ActiveForm::begin([
                        'id' => 'account-form1',
            ]);
            ?>
            <?php if (!empty($security_cheque)) { ?>
                <div class="row">
                    <div class="col-md-12">
                        <div id="security-cheque-details">
                            <div class="row">
                                <div class='col-md-12 col-xs-12 expense-head'>
                                    <span class="sub-heading">Security Cheque Details</span>
                                    <div class="horizontal_line"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class = 'col-md-4 col-sm-12 col-xs-12 left_padd'>
                                    <div class = "form-group">
                                        <label class="control-label" for="">Cheque Number</label>
                                        <input class="form-control" type = "text" name = "Security[cheque_num]" required value="<?= $security_cheque->cheque_no ?>" autofocus>

                                    </div>
                                </div>
                                <div class='col-md-4 col-sm-12 col-xs-12 left_padd'>
                                    <div class="form-group">
                                        <label class="control-label">Cheque Date</label>

                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input id="security-cheque_date" name="Security[cheque_date]" type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask required value="<?= $security_cheque->cheque_date != '' ? date("d/m/Y", strtotime($security_cheque->cheque_date)) : '' ?>">
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                </div>
                                <div class='col-md-4 col-sm-12 col-xs-12 left_padd'>
                                    <div class="form-group">
                                        <label class="control-label" for="">Amount</label>
                                        <input class="form-control" type = "number" name = "Security[amount]" required min="1" value="<?= $security_cheque->amount ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }
            ?>
            <div class="row">
                <div class='col-md-12 col-xs-12 expense-head'>
                    <span class="sub-heading">Contract Details</span>
                    <div class="horizontal_line"></div>
                </div>
                <div class="col-md-12">
                    <div id="expiry-details">
                        <div class="row">
                            <div class="col-md-3 col-sm-12 col-xs-12 left_padd">
                                <div class="form-group">
                                    <label class="control-label">License Expiry Date</label>

                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input id="appointment-license_expiry_date" name="Appointment[license_expiry_date]" type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask value="<?= $appointment->license_expiry_date != '' ? date("d/m/Y", strtotime($appointment->license_expiry_date)) : '' ?>" autofocus>
                                    </div>
                                    <!-- /.input group -->
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12 col-xs-12 left_padd">
                                <div class="form-group">
                                    <label class="control-label">Contract Start Date</label>

                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input id="appointment-contract_start_date" name="Appointment[contract_start_date]" type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask value="<?= $appointment->contract_start_date != '' ? date("d/m/Y", strtotime($appointment->contract_start_date)) : '' ?>" >
                                    </div>
                                    <!-- /.input group -->
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12 col-xs-12 left_padd">
                                <div class="form-group">
                                    <label class="control-label">Contract End Date</label>

                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input id="appointment-contract_end_date" name="Appointment[contract_end_date]" type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask value="<?= $appointment->contract_end_date != '' ? date("d/m/Y", strtotime($appointment->contract_end_date)) : '' ?>">
                                    </div>
                                    <!-- /.input group -->
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-12 col-xs-12 left_padd">
                                <div class="form-group">
                                    <label class="control-label">Sales Person Commission</label>
                                    <input id="appointment-sales_person_commission" name="Appointment[sales_person_commission]" value="<?= $appointment->sales_person_commission ?>" type="text" class="form-control">
                                    <!-- /.input group -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group action-btn-right">
                <?= Html::submitButton('Update', ['class' => 'btn btn-success create-btn']) ?>
            </div>
            <?php ActiveForm::end(); ?>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-responsive">
                        <thead>
                            <tr>
                                <th>Particular</th>
                                <th>Comment</th>
                                <th>Amount</th>
                                <th>Tax Amount</th>
                                <th>Projection Amount</th>
                                <th>Actual Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($services)) {
                                $amount_tot = 0;
                                $tax_tot = 0;
                                $grand_tot = 0;
                                $onetime_tot = 0;
                                $cheque_tot = 0;
                                foreach ($services as $service) {
                                    ?>
                                    <tr>
                                        <td><?= Services::findOne($service->service)->service_name ?></td>
                                        <td><?= $service->comment ?></td>
                                        <td style="text-align:right"><?= $service->amount ?></td>
                                        <td style="text-align: right;"><?= $service->tax_amount ?> <?= $service->tax_percentage != '' && $service->tax_percentage > 0 ? '( ' . $service->tax_percentage : '' ?> <?= $service->tax_percentage != '' ? '% )' : '' ?></td>
                                        <td style="text-align: right;"><?= $service->total ?></td>
                                        <td style="text-align: right;"><?= $service->total ?></td>
                                    </tr>
                                    <?php
                                    $amount_tot += $service->amount;
                                    $tax_tot += $service->tax_amount;
                                    $grand_tot += $service->total;
                                    if ($service->payment_type == 1) {
                                        $cheque_tot += $service->total;
                                    } elseif ($service->payment_type == 2) {
                                        $onetime_tot += $service->total;
                                    }
                                }
                                ?>
                                <tr>
                                    <td colspan="2" style="text-align: right;">Total</td>
                                    <td style="text-align: right;"><?= sprintf('%0.2f', $amount_tot); ?></td>
                                    <td style="text-align: right;"><?= sprintf('%0.2f', $tax_tot); ?></td>
                                    <td style="text-align: right;"><?= sprintf('%0.2f', $grand_tot); ?></td>
                                    <td style="text-align: right;"><?= sprintf('%0.2f', $grand_tot); ?></td>
                                </tr>

                            <?php }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12">
                    <div class="acc-print">
                        <?php
                        echo Html::a('<i class="fa fa-print"></i>Print', ['service-payment/accounts-report', 'id' => $appointment->id], ['target' => '_blank']);
                        ?>
                    </div>
                </div>
            </div>
            <br/>
            <?php Pjax::begin(['id' => 'products-table']); ?>
            <table class="table table-bordered">
                <tr>
                    <th></th>
                    <th>Cheque Number</th>
                    <th>Bank</th>
                    <th>Amount</th>
                    <th>Paid</th>
                    <th>Balance</th>
                    <th>Status</th>
                </tr>
                <?php if ($total_cash_amount > 0) { ?>
                    <tr>
                        <td></td>
                        <td>Cash Payment</td>
                        <td></td>
                        <td><?= $total_cash_amount ?></td>
                        <td><?= sprintf('%0.2f', $cash_paid) ?></td>
                        <td><?= sprintf('%0.2f', $total_cash_amount - $cash_paid) ?></td>
                        <td></td>
                    </tr>
                    <?php
                }
                if (!empty($cheque_dates)) {
                    foreach ($cheque_dates as $cheque_date) {
                        if (!empty($cheque_date)) {
                            $service_cheques = common\models\ServiceChequeDetails::find()->where(['cheque_date' => $cheque_date->cheque_date])->andWhere(['appointment_id' => $appointment->id])->all();
                            if (!empty($service_cheques)) {
                                ?>
                                <tr>
                                    <td rowspan="<?= count($service_cheques) ?>" ><?= $cheque_date->cheque_date ?></td>
                                    <?php
                                    foreach ($service_cheques as $service_cheque) {
                                        if (!empty($service_cheque)) {
                                            ?>

                                            <td><?= $service_cheque->cheque_number ?></td>
                                            <td><?= $service_cheque->bank ?></td>
                                            <td><?= $service_cheque->amount ?></td>
                                            <td>
                                                <?php
                                                if ($service_cheque->status == 1) {
                                                    echo $service_cheque->amount;
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($service_cheque->status == 1) {
                                                    echo 0;
                                                } elseif ($service_cheque->status == 2) {
                                                    echo $service_cheque->amount;
                                                } elseif ($service_cheque->status == 3) {
                                                    echo $service_cheque->amount;
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($service_cheque->status == 1) {
                                                    echo 'Cleared';
                                                } else {
                                                    echo Html::dropDownList('status', $service_cheque->status, ['1' => 'Cleared', '2' => 'Pending', '3' => 'Bounced'], ['class' => 'cheque_payment form-control', 'id' => $service_cheque->id, 'prompt' => '--Change Status--']);
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                            }
                        }
                    }
                }
                ?>
            </table>
            <div id="tabs">
                <div class="customer-info-footer">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                        <ul>
                            <li>Total Cost</li>
                            <span><?= sprintf('%0.2f', $grand_tot); ?></span>
                        </ul>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                        <ul>
                            <li>Received</li>
                            <span><?= sprintf('%0.2f', $total_received); ?></span>
                        </ul>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                        <ul>
                            <li>Balance</li>
                            <?php
                            $balance_amount = common\models\ServiceChequeDetails::find()->where(['or', ['<>', 'status', 1], ['is', 'status', NULL]])->andWhere(['appointment_id' => $appointment->id])->andWhere(['>', 'cheque_date', date('Y-m-d')])->sum('amount');
                            ?>
                            <span style="color: #939b21"><?= sprintf('%0.2f', $balance_amount); ?></span>
                        </ul>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                        <ul>
                            <li>Pending</li>
                            <?php
                            $pending_cheque_amount = common\models\ServiceChequeDetails::find()->where(['or', ['<>', 'status', 1], ['is', 'status', NULL]])->andWhere(['appointment_id' => $appointment->id])->andWhere(['<=', 'cheque_date', date('Y-m-d')])->sum('amount');
                            $pending_cash_amount = $total_cash_amount - $cash_paid;
                            $pending_amount = $pending_cash_amount + $pending_cheque_amount;
                            ?>
                            <span style="color: #939b21"><?= sprintf('%0.2f', $pending_amount); ?></span>
                        </ul>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                        <ul>
                            <li>
                                <?= Html::a('View payment history', ['/accounts/service-payment/payment-history', 'id' => $appointment->id], ['class' => 'button', 'target' => '_blank']) ?>
                            <li>
                                <a id="<?= $appointment->id ?>" type="button" class="pay-btn button" data-toggle="modal" data-target="#modal-default" >
                                    Make a receipt
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php Pjax::end(); ?>
            <?php $form3 = ActiveForm::begin(['action' => ['service-payment/check-files'], 'options' => ['method' => 'post', 'id' => 'cheque_files']]) ?>
            <div class="row">
                <?php
                ?>
                <div class='col-md-3  col-xs-12 left_padd'> 
                    <input type="hidden" value="<?= $appointment->id ?>" id="chequefiles-appointment_id" class="form-control" name="ChequeFiles[appointment_id]" aria-invalid="false">
                    <?= $form3->field($cheque_model, 'cheque_files[]')->fileInput(['multiple' => true]) ?>
                </div>
                <div class='col-md-3  col-xs-12 left_padd'> 
                    <?= Html::submitButton('Upload File', ['class' => 'btn btn-success create-btn', 'style' => 'margin-top: 10px;']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
            <div class="row">
                <div class='col-md-12  col-xs-12 left_padd'> 
                    <?php
                    if (!$model->isNewRecord) {
                        $path = Yii::getAlias('@paths') . '/accounts/cheque_files/' . $appointment->id;
                        if (count(glob("{$path}/*")) > 0) {
                            $k = 0;
                            ?>
                            <ul class="link-box">
                                <?php
                                foreach (glob("{$path}/*") as $file) {
                                    $k++;
                                    $arry = explode('/', $file);
                                    $img_nmee = end($arry);

                                    $img_nmees = explode('.', $img_nmee);
                                    if ($img_nmees['1'] != '') {
                                        ?>
                                        <li>
                                            <a class="acc-file" href="<?= Yii::$app->homeUrl ?>uploads/accounts/cheque_files/<?= $appointment->id ?>/<?= end($arry); ?>" target="_blank"><?= $img_nmees['0'] ?></a>
                                            <?= Html::a('<i class="fa fa-remove"></i>', ['/accounts/service-payment/remove-file', 'file' => end($arry), 'id' => $appointment->id], ['class' => 'acc-file-remove']) ?>
                                        </li>
                                        <?php
                                    }
                                }
                                ?>
                            </ul>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content payment-modal">

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script>

    $("document").ready(function () {
        $('#appointment-license_expiry_date').inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'});
        $('#appointment-contract_start_date').inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'});
        $('#appointment-contract_end_date').inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'});
        $('#security-cheque_date').inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'});
        $(document).on('change', '.cheque_payment', function (e) {
            var cheque_id = this.id;
            var cheque_status = $('option:selected', this).val();
            $.ajax({
                type: 'POST',
                cache: false,
                async: false,
                data: {id: cheque_id, status: cheque_status},
                url: '<?= Yii::$app->homeUrl; ?>accounts/service-payment/ajax-cheque-payment',
                success: function (response) {
                    $.pjax.reload({container: '#products-table', timeout: false});
                },
                error: function (response) {
                    console.log(response);
                }
            });
        });

        $(document).on('click', '.pay-btn', function (e) {
            var appointment_id = $(this).attr('id');
            $.ajax({
                type: 'POST',
                cache: false,
                async: false,
                data: {appointment_id: appointment_id},
                url: '<?= Yii::$app->homeUrl; ?>accounts/service-payment/get-payment',
                success: function (data) {
                    $(".payment-modal").html(data);
                }
            });

        });

    });
</script>

