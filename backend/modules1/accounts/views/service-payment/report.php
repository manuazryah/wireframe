<?php

use yii\helpers\Html;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="header">
    <h3>Universal Business Links</h3>
    <p>Office 309</p>
    <p>Al Kazim Building</p>
    <p>Dubai, UAE</p>
    <p>Emirate : Dubai</p>
    <p>Email : info@ublcsp.com</p>
    <h3 style="">Payment Voucher</h3>
</div>
<div class="body">
    <table class="table" style="width: 100%;">
        <tr>
            <td style="width: 50%;">No : <strong><?= $model->id ?></strong></td>
            <td style="width: 50%;" class="text-right">Dated : <strong><?= date("d-M-Y", strtotime($model->DOC)) ?></strong></td>
        </tr>
    </table>
    <table class="main-content-table">
        <thead>
            <tr>
                <th class="main-left">Particulars</th>
                <th class="main-right">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr class="table-top">
                <td class="particular-content">
                    <div class="main-content">
                        Amount
                    </div>
                </td>
                <td class="particular-content text-right">
                    <?= sprintf('%0.2f', $model->amount) ?>
                </td>
            </tr>
            <?php if ($model->payment_type == 2) { ?>
                <tr class="bottom-details table-top">
                    <td>
                        <div class="bank-details">
                            <h4>Bank Transaction Details</h4>
                            <div class="bank-details-list">
                                <table>
                                    <tr class="bank-details-list-row">
                                        <td>Cheque</td>
                                        <td><?= $model->cheque_no ?></td>
                                        <td><?= date("d-M-Y", strtotime($model->cheque_date)) ?></td>
                                        <td><?= sprintf('%0.2f', $model->amount) ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </td>
                    <td>
                    </td>
                </tr>
            <?php }
            ?>
            <tr class="bottom-details">
                <td>
                    <div class="bank-details">
                        <h4>Amount in words : <?php echo ucwords(Yii::$app->NumToWord->ConvertNumberToWords(round(abs($model->amount), 2))) . ' Only'; ?></h4>
                    </div>
                </td>
                <td>
                    <strong>AED <?= sprintf('%0.2f', $model->amount) ?></strong>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="footer">
    <table class="footer-table">
        <tr>
            <th>Receiver's Signature</th>
            <th>Authorised Signatory</th>
        </tr>
    </table>
</div>
