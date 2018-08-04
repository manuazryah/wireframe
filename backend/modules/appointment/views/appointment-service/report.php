<?php

use yii\helpers\Html;
?>
<!DOCTYPE html>

<div id="print">
    <style type="text/css">

        /*thead { display: table-header-group;   }*/
        /*tfoot{display: table-footer-group;}*/
        table { page-break-inside:auto;}
        tr{ page-break-inside:avoid; page-break-after:auto; }

        @page {
            size: A4;
        }
        @media print {
            thead {display: table-header-group;}
            tfoot {display: table-footer-group}
            .main-tabl{width: 100%}
            .main-tabl{
                -webkit-print-color-adjust: exact;
                margin: auto;
                tr{ page-break-inside:avoid; page-break-after:auto; }
            }
            /*tfoot{display: table-footer-group;}*/
            table { page-break-inside:auto;}
            tr{ page-break-inside:avoid; page-break-after:auto; }

        }
        body h6,h1,h2,h3,h4,h5,p,b,tr,td,span,th,div{
            color:#191818 !important;
        }
        .main-tabl{
            width: 100%;
        }
        .quation-heading h3{
            text-align: center;
        }
        .appointment-content-table{
            width: 100%;
            border: 1px solid black;
            border-collapse: collapse;
            text-align: left;
        }
        .appointment-content-table th{
            border: 1px solid black;
            padding: 5px 10px;
            font-size: 13px;
        }
        .width-20{
            width: 20%;
        }
        .width-40{
            width: 40%;
        }
        .width-10{
            width: 10%;
        }
        .width-80{
            width: 80%;
        }
        .service-head h6{
            font-size: 14px;
            text-decoration: underline;
            margin-bottom: 5px;
        }
        .service-table{
            width: 100%;
            border: 1px solid black;
            border-collapse: collapse;
            text-align: left;
        }
        .service-table th{
            border: 1px solid black;
            padding: 5px 10px;
            font-size: 13px;
        }
        .service-table td{
            border: 1px solid black;
            padding: 5px 10px;
            font-size: 13px;
        }
        .txt-align-right{
            text-align: right;
        }
        .quotation-conditions h6{
            font-size: 14px;
            margin-bottom: 5px;
            font-weight: 600;
        }
        .declaration .head{
            font-size: 14px;
            font-weight: 600;
        }
        .declaration .contents p{
            font-size: 14px;
        }
        .quotation-conditions li{
            font-size: 14px;
            padding-left: 5px;
            padding-bottom: 6px;
        }
    </style>
    <table class="main-tabl" border="0" >
        <thead>
            <tr>
                <th>
                    <div class="quation-head">
                        <img width="100" src="<?= Yii::$app->homeUrl ?>img/ublcsp-logo.png"/>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="quation-heading">
                        <h3>QUOTATION</h3>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="appointment-content">
                        <table class="appointment-content-table">
                            <tr>
                                <th class="width-20">Customer Name:</th>
                                <th class="width-40"><?= $apointment->customer != '' ? common\models\Debtor::findOne($apointment->customer)->company_name : '' ?></th>
                                <th class="width-20">Date :</th>
                                <th class="width-20"><?= date('d-F-Y') ?></th>
                            </tr>
                            <tr>
                                <th class="width-20">Company Name:</th>
                                <th class="width-40"></th>
                                <th class="width-20">Quotation No:</th>
                                <th class="width-20"><?= $apointment->service_id ?></th>
                            </tr>
                            <tr>
                                <th class="width-20">Office No :</th>
                                <th class="width-40"></th>
                                <th class="width-20"></th>
                                <th class="width-20"></th>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="service-head">
                        <h6>Fees Structure for New Trade License Processing Along With Office Space</h6>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="service-contents">
                        <table class="service-table">
                            <tr>
                                <th class="width-10">Sl No</th>
                                <th class="width-80">Particulars</th>
                                <th class="width-10">Amount AED</th>
                            </tr>
                            <?php
                            if (!empty($services)) {
                                $i = 1;
                                ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td>
                                        <strong style="text-decoration: underline;">A. Specification</strong>
                                        <p>1. New company Formation: Dubai Mainland</p>
                                        <p>2. Company Type: Commercial Issue</p>
                                    </td>
                                    <td>
                                        With Office Space
                                    </td>
                                </tr>
                                <?php
                                foreach ($services as $service) {
                                    if (!empty($service)) {
                                        $i++;
                                        ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><strong><?= $service->service != '' ? common\models\Services::findOne($service->service)->service_name : '' ?></strong>
                                                <?php
                                                if ($service->comment != '') {
                                                    echo '<br><span class="cmmd-span">' . $service->comment . '</span>';
                                                }
                                                ?>
                                            </td>
                                            <td class="txt-align-right"><?= $service->total ?> </td>
                                        </tr>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </table>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="quotation-conditions">
                        <h6>Conditions</h6>
                        <ol>
                            <li>As per UAE Law the customer have to pay 5% vat for the Total amount.</li>
                            <li>UBL will charge 5% of the Total rent for market fee.</li>
                            <li>Office rent has to be paid in 4 Cheque , </li>
                            <li>This quotation is valid for 15 days upon receipt</li>
                            <li>All the requirements must be submitted prior to business license application.</li>
                            <li>UBL is not responsible for any delay in license processing due to the lack of submission of exact documents as required by government departments from the part of the client.</li>
                            <li>UBL requires at least fifty percent (50%) of the total amount to defray processing expenses. The remaining balance has to be paid upon receipt of the payment voucher.</li>
                            <li>Government charges and requirements are subject to change without prior notice. For completion of the license process, we may require</li>
                            <li>Any excess payment made for government fees will be returned to the client.</li>
                            <li>Business Set-Up Consultation is free of charge. Business activities are subject to approval by the concerned government department.</li>
                            <li>Internet (Etisalat) and Electricity Bill (DEWA) will be paid in 3 months advance from the Tenancy occupancy date agreed.</li>
                            <li>Payment is accepted in cash, cheque or bank transfer.</li>
                            <li>If any Rent cheque is Bounce UBL will charge AED -500/-</li>
                            <li>PRO charges per visa is AED 350/-</li>
                        </ol>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="declaration">
                        <p class="head">I understand the above terms and conditions and I hereby authorize UBL to start my license processing as per above rules and regulations.</p>
                        <div style="width:100%;display: inline-flex;" class="contents">
                            <div style="width:50%">
                                <p>For Universal Business Links</p>
                                <p>Name: ..................................</p>
                                <p>Sign: ....................................</p>
                            </div>
                            <div style="width:50%">
                                <p>Customer;</p>
                                <p>Name: <?= $apointment->customer != '' ? common\models\Debtor::findOne($apointment->customer)->company_name : '' ?></p>
                                <p>Sign: ....................................</p>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
        <tfoot>
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
<div style="display:inline-block">
    <div class="print" style="">
        <button onclick="printContent('print')" style="font-weight: bold !important;">Print</button>
        <button onclick="window.close();" style="font-weight: bold !important;">Close</button>

    </div>
</div>