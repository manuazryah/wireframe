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
        <caption><h2>Sponsor Report</h2></caption>
        <thead>
            <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Appointment ID</th>
                <th>Payment Type</th>
                <th>Sponsor Fee</th>
                <th>Total Amount</th>
                <th>Agreement Start Date </th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($sponsor_payments)) {
                $i = 0;
                foreach ($sponsor_payments as $sponsor_payment) {
                    if (!empty($sponsor_payment)) {
                        $i++;
                        ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $sponsor_payment->customer_id != '' ? strtolower(common\models\Debtor::findOne($sponsor_payment->customer_id)->company_name) : 'Payment On ' . $sponsor_payment->DOC ?></td>
                            <td><?= $sponsor_payment->appointment_id != '' ? $sponsor_payment->appointment_id : 'N/A' ?></td>
                            <td><?= $sponsor_payment->type == 1 ? 'Credit' : 'Paid' ?></td>
                            <td style="text-align: right;"><?= sprintf('%0.2f', $sponsor_payment->amount) ?></td>
                            <td style="text-align: right;">
                                <?php
                                $total = 0;
                                if ($sponsor_payment->appointment_id != '') {
                                    $total = common\models\AppointmentService::find()->where(['appointment_id' => $sponsor_payment->appointment_id])->sum('total');
                                }
                                echo $total;
                                ?>
                            </td>
                            <td><?= $sponsor_payment->appointment_id != '' ? common\models\Appointment::findOne($sponsor_payment->appointment_id)->contract_start_date : '' ?></td>
                        </tr>
                        <?php
                    }
                }
            }
            ?>
        </tbody>
<!--        <tfoot>
            <tr>
                <th colspan="4">Total Sponsor Fee</th>
                <th style="text-align: right;"><?php // sprintf('%0.2f', $sponsor_total)  ?></th>
                <th></th>
                <th></th>
            </tr>
        </tfoot>-->
    </table>
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
