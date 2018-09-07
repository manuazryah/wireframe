<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Reports';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="box table-responsive">
        <div class="country-index">
                <div class="box-header with-border">
                        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
                </div>
                <div class="box-body table-responsive">
                        <?php
                        $plots_master = \common\models\RealEstateMaster::find()->all();
                        if (count($plots_master) > 0) {
                                foreach ($plots_master as $plot) {
                                        $plots = common\models\RealEstateDetails::find()->where(['master_id' => $plot->id, 'category' => 2])->all();
                                        ?>
                                        <table class="table table-bordered table-striped" style="margin-bottom: 10px;">
                                                <tr>
                                                        <td>Sl.No</td>
                                                        <td></td>
                                                        <td style="width:400px;">Company Name</td>
                                                        <td style="width:300px">Contact Person</td>
                                                        <td style="width:150px">Status</td>
                                                        <td>Balance</td>
                                                        <td>Rent Income</td>
                                                        <td>Sponsorship Income</td>
                                                        <td>Rent Cost</td>
                                                        <td>Sponsr Cost</td>
                                                </tr>
                                                <tr>
                                                        <td colspan="11">
                                                                <b><?= $plot->reference_code ?></b>
                                                        </td>
                                                </tr>
                                                <?php
                                                $p = 0;
                                                $total_rent_income = 0;
                                                foreach ($plots as $value) {
                                                        $p++;
                                                        $appointment_exists = \common\models\Appointment::find()->where(['plot' => $value->id])->exists();
                                                        $balance = '';
                                                        $rent_income = '';
                                                        $status = '';

                                                        if ($appointment_exists) {
                                                                $appointment = \common\models\Appointment::find()->where(['plot' => $value->id])->one();
                                                                $customer = \common\models\Debtor::findOne($appointment->customer);
                                                                $name = $customer->company_name;
                                                                $contact_person = $customer->contact_person;

                                                                if ($appointment->service_type == 1) {
                                                                        $status = 'Sitting';
                                                                } else if ($appointment->service_type == 2) {
                                                                        $status = 'Adding';
                                                                } else if ($appointment->service_type == 3) {
                                                                        $status = 'Space';
                                                                } else {
                                                                        $status = 'Available    ';
                                                                }
                                                                $rent_income = common\models\AppointmentService::find()->where(['appointment_id' => $appointment->id])->sum('total');
                                                                $amount_paid = common\models\AppointmentService::find()->where(['appointment_id' => $appointment->id])->sum('amount_paid');
                                                                $total_rent_income += $rent_income;
                                                                $balance = $rent_income - $amount_paid;
                                                        } else {
                                                                $name = $plot->reference_code . ' ' . $value->code;
                                                                $contact_person = '';
                                                        }
                                                        ?>
                                                        <tr>
                                                                <td><?= $p ?></td>
                                                                <td><?= $value->code ?></td>
                                                                <td><?= $name ?></td>
                                                                <td><?= $contact_person ?></td>
                                                                <td><?= $status ?></td>
                                                                <td><?= number_format((float) $balance, 2, '.', ''); ?></td>
                                                                <td><?= $rent_income ?></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                        </tr>
                                                <?php } ?>
                                                <tr>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><?= number_format((float) $total_rent_income, 2, '.', ''); ?></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                </tr>
                                        </table>
                                        <?php
                                }
                        } else {
                                echo 'No result found';
                        }
                        ?>
                </div>
        </div>
        <!-- /.box-body -->
</div>