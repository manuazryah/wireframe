<?php

use yii\helpers\Html;
use common\models\Services;
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
        .main-tabl{
            width: 100%;
        }
        .account-details .tbl1{
            width: 100%;
            max-width: 100%;
            margin-bottom: 20px;
            border: 1px solid #bbb9b9;
            border-collapse: collapse;
            font-size: 14px;
        }
        .account-details .tbl1 th{
            border: 1px solid #bbb9b9;
            padding: 5px 10px;
        }
        .account-details .tbl1 td{
            border: 1px solid #bbb9b9;
            padding: 5px 10px;
        }
        .account-details .tbl1 .txt-center{
            text-align: right;
        }
        .tabstbl{
            width:100%;
        }
        .tabstbl th{
            text-align: left;
            padding: 8px 10px;
        }
        .tabstbl td{
            text-align: left;
            padding: 8px 10px;
        }
        .amt{
            font-size: 20px;
            font-weight: 600;
        }
        .amt_1{
            color: #41bbd4 !important;
        }
        .amt_2{
            color: #8BC34A !important;
        }
        .amt_3{
            color: #F44336 !important;
        }
    </style>
    <table class="main-tabl" border="0" >
        <thead>
            <tr>
                <th style="width:100%">
                    <div class="header">
                        <h2>Accounts Report</h2>
                    </div>
                </th>
            </tr>

        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="account-details">
                        <table class="tbl1">
                            <thead>
                                <tr>
                                    <th>PARTICULAR</th>
                                    <th>COMMENTS</th>
                                    <th>AMOUNT</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $projection_amount = 0;
                                if (!empty($services)) {
                                    foreach ($services as $service) {
                                        if (!empty($service)) {
                                            ?>
                                            <tr>
                                                <td><?= $service->service != '' ? Services::findOne($service->service)->service_name : '' ?></td>
                                                <td><?= $service->comment ?></td>
                                                <td style="text-align: right;"><?= $service->total ?></td>
                                            </tr>
                                            <?php
                                            $projection_amount += $service->total;
                                        }
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                        <div class="clear"></div>
                        <h4>Payment Details</h4>
                        <table class="tbl1">
                            <tr>
                                <th></th>
                                <th>Cheque Number</th>
                                <th>Amount</th>
                                <th>Paid</th>
                                <th>Balance</th>
                                <th>Status</th>
                            </tr>
                            <?php if ($total_cash_amount > 0) { ?>
                                <tr>
                                    <td></td>
                                    <td>Cash Payment</td>
                                    <td class="txt-center"><?= $total_cash_amount ?></td>
                                    <td class="txt-center"><?= $cash_paid ?></td>
                                    <td class="txt-center"><?= $total_cash_amount - $cash_paid ?></td>
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
                                                        <td class="txt-center"><?= $service_cheque->amount ?></td>
                                                        <td class="txt-center">
                                                            <?php
                                                            if ($service_cheque->status == 1) {
                                                                echo $service_cheque->amount;
                                                            }
                                                            ?>
                                                        </td>
                                                        <td class="txt-center">
                                                            <?php
                                                            if ($service_cheque->status == 1) {
                                                                echo 0;
                                                            } elseif ($service_cheque->status == 2) {
                                                                echo $service_cheque->amount;
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($service_cheque->status == 1) {
                                                                echo 'Cleared';
                                                            } elseif ($service_cheque->status == 2) {
                                                                echo 'Pending';
                                                            } else {
                                                                echo '';
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
                            <table class="tabstbl">
                                <tr>
                                    <th>Total Expense</th>
                                    <th>Total Received</th>
                                    <th>Balance</th>
                                </tr>
                                <tr>
                                    <td class="amt amt_1"><?= sprintf('%0.2f', $projection_amount); ?></td>
                                    <td class="amt amt_2"><?= sprintf('%0.2f', $total_received); ?></td>
                                    <td class="amt amt_3"><?= sprintf('%0.2f', $total_balance); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td style="width:100%">
                    <div style="clear:both"></div>
                    <div class="footer">
                    </div>
                </td>
            </tr>
        </tfoot>
    </table>
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
