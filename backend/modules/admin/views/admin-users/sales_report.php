<?php

use yii\helpers\Html;
?>
<!DOCTYPE html>
<div style="display:inline-block">
    <div class="print" style="float:left;">
        <button onclick="printContent('print')" style="font-weight: bold !important;">Print</button>
        <button onclick="window.close();" style="font-weight: bold !important;">Close</button>

    </div>
</div>
<div id="print">
    <style type="text/css">

        tfoot{display: table-footer-group;}
        table { page-break-inside:auto;}
        tr{ page-break-inside:avoid; page-break-after:auto; }

        @page {
            size: A4;
        }
        @media print {
            thead {display: table-header-group;}
            tfoot {display: table-footer-group}
            .main-tabl{width: 100%}
            .footer {position: fixed ; left: 0px; bottom: 0px; right: 0px; font-size:10px; }
            .main-tabl{
                -webkit-print-color-adjust: exact;
                margin: auto;
                tr{ page-break-inside:avoid; page-break-after:auto; }
            }
            tfoot{display: table-footer-group;}
            table { page-break-inside:auto;}
            tr{ page-break-inside:avoid; page-break-after:auto; }

        }
        @media screen{
        }
        body h6,h1,h2,h3,h4,h5,p,b,tr,td,span,th,div{
            color:#525252 !important;
        }
        .main-tabl {
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .main-tabl{
            width: 98%;
        }
        .tbl2{
            width: 50%;
        }
        .main-tabl, .main-tabl th, .main-tabl td {
            border: 1px solid #cacaca;
        }
        .main-tabl th, .main-tabl td {
            white-space: nowrap !important;
        }
        .main-tabl th {
            font-size: 16px;
            padding: 10px 10px;
        }
        .main-tabl td {
            font-size: 14px;
            padding: 10px 10px;
            text-transform: capitalize;
        }
    </style>
    <table class="main-tabl">
        <caption><h2>Sales Person Report</h2></caption>
        <thead>
            <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Appointment</th>
                <th>Total Amount</th>
                <th>UBL Amount</th>
                <th>Commission</th>
                <th>Agreement Start Date </th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($sales_appointments)) {
                $i = 0;
                foreach ($sales_appointments as $sales_appointment) {
                    if (!empty($sales_appointment)) {
                        $i++;
                        ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $sales_appointment['customer'] != '' ? strtolower(common\models\Debtor::findOne($sales_appointment['customer'])->company_name) : '' ?></td>
                            <td><?= $sales_appointment['service_id'] ?></td>
                            <td style="text-align: right;">
                                <?php
                                $total = 0;
                                if ($sales_appointment['id'] != '') {
                                    $total = common\models\AppointmentService::find()->where(['appointment_id' => $sales_appointment['id']])->sum('total');
                                }
                                echo $total;
                                ?>
                            </td>
                            <td style="text-align: right;">
                                <?php
                                $ubl_total = 0;
                                $services = \common\models\Services::find()->where(['type' => 1])->all();
                                if (!empty($services)) {
                                    $arr = [];
                                    foreach ($services as $service) {
                                        $arr[] = $service->id;
                                    }
                                    if (!empty($arr)) {
                                        $ubl_total = common\models\AppointmentService::find()->where(['appointment_id' => $sales_appointment['id']])->andWhere(['service' => $arr])->sum('total');
                                    }
                                }
                                echo $ubl_total;
                                ?>
                            </td>
                            <td style="text-align: right;"><?= $sales_appointment['sales_person_commission'] != '' && $sales_appointment['sales_person_commission'] > 0 ? sprintf('%0.2f', $sales_appointment['sales_person_commission']) : '' ?></td>
                            <td><?= $sales_appointment['id'] != '' ? common\models\Appointment::findOne($sales_appointment['id'])->contract_start_date : '' ?></td>
                        </tr>
                        <?php
                    }
                }
            }
            ?>
        </tbody>
<!--        <tfoot>
            <tr>
                <th colspan="5">Total Commission</th>
                <th style="text-align: right;"><?php // sprintf('%0.2f', $sales_total)               ?></th>
                <th></th>
            </tr>
        </tfoot>-->
    </table>
    <?php
    if (!empty($sales_payment)) {
        ?>
        <table class="main-tabl tbl2">
            <caption><h2>Payment History</h2></caption>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Amount Paid</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $k = 0;
                foreach ($sales_payment as $payment) {
                    $k++;
                    ?>
                    <tr>
                        <td><?= $k ?></td>
                        <td><?= $payment->DOC ?></td>
                        <td style="text-align:right;"><?= sprintf('%0.2f', $payment->amount) ?></td>
                    </tr>
                <?php }
                ?>
            </tbody>
        </table>
        <?php
    }
    ?>
</div>
<div style="display:inline-block">
    <div class="print" style="float:left;">
        <button onclick="printContent('print')" style="font-weight: bold !important;">Print</button>
        <button onclick="window.close();" style="font-weight: bold !important;">Close</button>

    </div>
</div>
<script>
    function printContent(el) {
        var restorepage = document.body.innerHTML;
        var printcontent = document.getElementById(el).innerHTML;
        document.body.innerHTML = printcontent;
        window.print();
        document.body.innerHTML = restorepage;
    }
</script>
