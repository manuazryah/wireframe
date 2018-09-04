<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="panel panel-default">
    <?php
    if (!empty($initial_approval)) {
        ?>
        <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordionMenu" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Trade Name & Initial Approval
                </a>
            </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
                <ul class="nav">
                    <li><a target="_blank" href="<?= Yii::$app->homeUrl; ?>uploads/license_procedure/trade_initial_approval/receipt/<?= $initial_approval->id ?>.<?= $initial_approval->payment_receipt ?>">Payment Receipt</a></li>
                    <li><a target="_blank" href="<?= Yii::$app->homeUrl; ?>uploads/license_procedure/trade_initial_approval/certificate/<?= $initial_approval->id ?>.<?= $initial_approval->certificate ?>">Certificate</a></li>
                    <li><a target="_blank" href="<?= Yii::$app->homeUrl; ?>uploads/license_procedure/trade_initial_approval/family_book/<?= $initial_approval->id ?>.<?= $initial_approval->sponsor_family_book ?>">Sponsor Family Book</a></li>
                </ul>
            </div>
        </div>
        <?php
    }
    ?>
</div>
<div class="panel panel-default">
    <?php
    if (!empty($moa_documents)) {
        ?>
        <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordionMenu" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    MOA
                </a>
            </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
                <ul class="nav">
                    <li><a target="_blank" href="<?= Yii::$app->homeUrl; ?>uploads/license_procedure/moa/aggrement/<?= $moa_documents->id ?>.<?= $moa_documents->aggrement ?>"> Common Aggrement</a></li>
                    <li><a target="_blank" href="<?= Yii::$app->homeUrl; ?>uploads/license_procedure/moa/moa_document/<?= $moa_documents->id ?>.<?= $moa_documents->moa_document ?>">MOA Document</a></li>
                </ul>
            </div>
        </div>
        <?php
    }
    ?>
</div>