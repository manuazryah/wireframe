<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php
if (!empty($appointment)) {
    ?>
    <div class="customer-info-footer">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
            <ul>
                <li>Total Received</li>
                <span><?= $paymentmaster->amount_paid ?></span>
            </ul>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
            <ul>
                <li>Total Expense</li>
                <span><?= $paymentmaster->total_amount ?></span>
            </ul>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <ul>
                <li>Balance</li>
                <span style="color: #939b21"><?= $paymentmaster->balance_amount ?></span>
            </ul>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <ul>
                <li><a href="" class="button">View payment history</a></li>
            </ul>
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pad-0">
        <ul>
            <li><a href="" class="button" style="width: fit-content">View quotation</a></li>
        </ul>
    </div>
    <?php
}
?>