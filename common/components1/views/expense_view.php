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
                <span><?= !empty($paymentmaster) ? sprintf('%0.2f', $paymentmaster->amount_paid) : sprintf('%0.2f', 0); ?></span>
            </ul>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
            <ul>
                <li>Total Expense</li>
                <span><?= sprintf('%0.2f', $projection_amount); ?></span>
            </ul>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <ul>
                <li>Balance</li>
                <span style="color: #939b21"><?= !empty($paymentmaster) ? sprintf('%0.2f', $paymentmaster->balance_amount) : sprintf('%0.2f', 0); ?></span>
            </ul>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <ul>
                <li>
                    <?= Html::a('View payment history', ['/accounts/service-payment/payment-history', 'id' => $appointment->id], ['class' => 'button', 'target' => '_blank']) ?>
                </li>
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