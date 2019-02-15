<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Services;
use common\models\Tax;

/* @var $this yii\web\View */
/* @var $model common\models\AppointmentService */

$this->title = 'Service Payment';
$this->params['breadcrumbs'][] = ['label' => 'Appointment Services', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$sub_status = $appointment->sub_status;
?>
<!-- Default box -->
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <?= Html::a('<span> Manage Accounts</span>', ['index'], ['class' => 'btn btn-block manage-btn']) ?>
        <section id="tabs1">
            <div class="card1">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation">
                        <?php
                        echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Step 1</span>', ['service-payment/service-payment', 'id' => $id]);
                        ?>
                    </li>
                    <li role="presentation" class="active">
                        <?php
                        echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Step 2</span>', ['service-payment/service-payment-details', 'id' => $id]);
                        ?>
                    </li>
                    <li role="presentation">
                        <?php
                        if ($appointment->sub_status != '' && $appointment->sub_status > 1) {
                            echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Step 3</span>', ['service-payment/payment', 'id' => $id]);
                        } else {
                            echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Step 3</span>', ['service-payment/service-payment-details', 'id' => $id]);
                        }
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
                    'id' => 'account-form',
        ]);
        ?>
        <div class="form-group field-appointment-id">

            <input type="hidden" name="security_cheque" value="0"><label><input type="checkbox" id="security_cheque" name="security_cheque" value="1"> Security Cheque</label>

            <div class="help-block"></div>
        </div>
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
        <?php } else { ?>
            <div class="row">
                <div class="col-md-12">
                    <div id="security-cheque-details">

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
                        <div class="col-md-4 col-sm-12 col-xs-12 left_padd">
                            <div class="form-group">
                                <label class="control-label">License Expiry Date</label>

                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input id="appointment-license_expiry_date" name="Appointment[license_expiry_date]" type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask value="" autofocus>
                                </div>
                                <!-- /.input group -->
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12 left_padd">
                            <div class="form-group">
                                <label class="control-label">Contract Start Date</label>

                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input id="appointment-contract_start_date" name="Appointment[contract_start_date]" type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask >
                                </div>
                                <!-- /.input group -->
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12 left_padd">
                            <div class="form-group">
                                <label class="control-label">Contract End Date</label>

                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input id="appointment-contract_end_date" name="Appointment[contract_end_date]" type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask >
                                </div>
                                <!-- /.input group -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="appointment-service-create">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>Particular</th>
                        <th>Comment</th>
                        <th>Amount</th>
                        <th>Tax Amount</th>
                        <th>Total</th>
                        <th>Payment Type</th>
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
                        $cheque_tax_tot = 0;
                        foreach ($services as $service) {
                            ?>
                            <tr>
                                <td><?= Services::findOne($service->service)->service_name ?></td>
                                <td><?= $service->comment ?></td>
                                <td style="text-align:right"><?= $service->amount ?></td>
                                <td style="text-align: right;"><?= $service->tax_amount ?> <?= $service->tax_percentage != '' && $service->tax_percentage > 0 ? '( ' . $service->tax_percentage : '' ?> <?= $service->tax_percentage != '' ? '% )' : '' ?></td>
                                <td style="text-align: right;"><?= $service->total ?></td>
                                <td>
                                    <?php
                                    if ($service->payment_type == 1) {
                                        echo 'Multiple';
                                    } elseif ($service->payment_type == 2) {
                                        echo 'One Time';
                                    } else {
                                        echo '';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php
                            $amount_tot += $service->amount;
                            $tax_tot += $service->tax_amount;
                            $grand_tot += $service->total;
                            if ($service->payment_type == 1) {
                                $cheque_tot += $service->total;
                                $cheque_tax_tot += $service->tax_amount;
                            } elseif ($service->payment_type == 2) {
                                $onetime_tot += $service->total;
                            }
                        }
                        ?>
                        <tr>
                            <td colspan="2" style="text-align: right;">Total</td>
                            <td style="text-align: right;"><?= sprintf('%0.2f', $amount_tot); ?></td>
                            <td style="text-align: right;"><?= sprintf('%0.2f', $tax_tot); ?></td>
                            <td style="text-align: right;">
                                <input type="hidden" value="<?= sprintf('%0.2f', $grand_tot); ?>" id="grand-tot" />
                                <?= sprintf('%0.2f', $grand_tot); ?>
                            </td>
                            <td></td>
                        </tr>

                    <?php }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-md-6" style="border-right: 1px solid #c5c5c5;">
                <div class="col-md-4">
                    <div class="form-group field-debtor-company_name">
                        <label class="control-label" for="debtor-company_name">Cheque Amount</label>
                        <input type="text" value="<?= $appointment->multiple_total ?>" id="multiple-tot" name="multiple_total" class="form-control" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group field-debtor-company_name">
                        <label class="control-label" for="debtor-company_name">Tax Amount</label>
                        <input type="text" value="<?= $cheque_tax_tot ?>" id="multiple-tax-tot" class="form-control" readonly />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group field-debtor-company_name required">
                        <label class="control-label" for="debtor-company_name">No of Cheques</label>
                        <input style=" margin: 0px 5px;"type="number" value="<?= count($multiple_cheque_details) ?>" id="multiple-cheque-count" class="form-control" step="1"/>
                    </div>
                </div>
                <div class="col-md-12">
                    <?= $form->field($appointment, "tax_to_onetime")->checkbox(); ?>
                </div>
                <div class="col-md-12">
                    <div id="cheque-details-content-multiple">
                        <?php
                        if (!empty($multiple_cheque_details)) {
                            ?>
                            <div class="row">
                                <div class="col-md-12 col-xs-12 expense-head">
                                    <span class="sub-heading">Cheque Details</span>
                                    <div class="horizontal_line"></div>
                                </div>
                            </div>
                            <?php
                            $j = 0;
                            foreach ($multiple_cheque_details as $multiple_cheque_detail) {
                                $j++;
                                ?>
                                <div class="row">
                                    <div class = 'col-md-4 col-sm-12 col-xs-12 left_padd'>
                                        <div class = "form-group">
                                            <label class="control-label" for="">Cheque Number</label>
                                            <input class="form-control" type = "text" name = "create[cheque_num][]" value="<?= $multiple_cheque_detail->cheque_number ?>" required>

                                        </div>
                                    </div>
                                    <div class='col-md-4 col-sm-12 col-xs-12 left_padd'>
                                        <div class="form-group">
                                            <label class="control-label">Cheque Date</label>

                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input id="create-<?= $j ?>" name="create[cheque_date][]" type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask value="<?= $multiple_cheque_detail->cheque_date != '' ? date("d/m/Y", strtotime($multiple_cheque_detail->cheque_date)) : '' ?>" required>
                                            </div>
                                            <!-- /.input group -->
                                        </div>
                                    </div>
                                    <div class='col-md-4 col-sm-12 col-xs-12 left_padd'>
                                        <div class="form-group">
                                            <label class="control-label" for="">Amount</label>
                                            <input class="form-control mul_cheque_amt" id="mul_cheque_amt-<?= $j ?>" type="number" name="create[amount][]" value="<?= $multiple_cheque_detail->amount ?>" step="any" required>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="col-md-6">
                    <div class="form-group field-debtor-company_name required">
                        <label class="control-label" for="debtor-company_name">One Time Payment</label>
                        <input type="text" value="<?= $appointment->one_time_total ?>" id="one-time-tot" name="one_time_total" class="form-control" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group field-debtor-company_name required">
                        <label class="control-label" for="debtor-company_name">Payment Type</label>
                        <select style="margin: 0px 0px;" id="one-time-payment_type" class="form-control">
                            <?php
                            if (!empty($onetime_cheque_details)) {
                                $type = 2;
                            } else {
                                $type = 1;
                            }
                            ?>
                            <option value="1" <?= $type == 1 ? 'selected' : '' ?>>Cash</option>
                            <option value="2" <?= $type == 2 ? 'selected' : '' ?>>Cheque</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div id="cheque-details-content-one-time">
                        <?php
                        if (!empty($onetime_cheque_details)) {
                            ?>
                            <div class="row">
                                <div class="col-md-12 col-xs-12 expense-head">
                                    <span class="sub-heading">Cheque Details</span>
                                    <div class="horizontal_line"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class = 'col-md-4 col-sm-12 col-xs-12 left_padd'>
                                    <div class = "form-group">
                                        <label class="control-label" for="">Cheque Number</label>
                                        <input class="form-control" type = "text" name = "createone[cheque_num]" value="<?= $onetime_cheque_details->cheque_number ?>" required>

                                    </div>
                                </div>
                                <div class='col-md-4 col-sm-12 col-xs-12 left_padd'>
                                    <div class="form-group">
                                        <label class="control-label">Cheque Date</label>

                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input id="createone-cheque_date" name="createone[cheque_date]" type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask value="<?= $onetime_cheque_details->cheque_date != '' ? date("d/m/Y", strtotime($onetime_cheque_details->cheque_date)) : '' ?>" required>
                                        </div>
                                        <!-- /.input group -->
                                    </div>
                                </div>
                                <div class='col-md-4 col-sm-12 col-xs-12 left_padd'>
                                    <div class="form-group">
                                        <label class="control-label" for="">Amount</label>
                                        <input class="form-control" id="one_time_amt" type="number" name="createone[amount]" value="<?= $onetime_cheque_details->amount ?>" step="any" required>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group action-btn-right">
            <?= Html::a('<span> Cancel</span>', ['index'], ['class' => 'btn btn-block cancel-btn']) ?>
            <?= Html::submitButton('Save', ['class' => 'btn btn-success create-btn']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->
<script>

</script>

