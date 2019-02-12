<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php
if (!empty($partner_documents)) {
    ?>
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordionMenu" href="#collapseZero" aria-expanded="true" aria-controls="collapseZero">
                    Partner Documents
                </a>
            </h4>
        </div>
        <div id="collapseZero" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingZero">
            <div class="panel-body">
                <ul class="nav">
                    <?php
                    foreach ($partner_documents as $partner_document) {
                        if (!empty($partner_document->file)) {
                            $path = Yii::$app->basePath . '/../uploads/partner_documents/' . $partner_document->appointment_id . '/' . $partner_document->file;
                            if (file_exists($path)) {
                                ?>
                                <li>
                                    <a href="<?= Yii::$app->homeUrl ?>uploads/partner_documents/<?= $partner_document->appointment_id ?>/<?= $partner_document->file ?>" target="_blank"><?= $partner_document->file ?></a>
                                </li>
                                <?php
                            }
                            ?>
                            <?php
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <?php
}
?>
<?php
if (!empty($initial_approval)) {
    ?>
    <div class="panel panel-default">
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
    </div>
    <?php
}
?>
<?php
if (!empty($moa_documents)) {
    ?>
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordionMenu" href="#collapseTwo" aria-expanded="true" aria-controls="collapseOne">
                    MOA
                </a>
            </h4>
        </div>
        <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
                <ul class="nav">
                    <li><a target="_blank" href="<?= Yii::$app->homeUrl; ?>uploads/license_procedure/moa/aggrement/<?= $moa_documents->id ?>.<?= $moa_documents->aggrement ?>"> Common Aggrement</a></li>
                    <li><a target="_blank" href="<?= Yii::$app->homeUrl; ?>uploads/license_procedure/moa/moa_document/<?= $moa_documents->id ?>.<?= $moa_documents->moa_document ?>">MOA Document</a></li>
                </ul>
            </div>
        </div>

    </div>
    <?php
}
?>
<?php
if (!empty($payment_voucher)) {
    ?>
    <div class="panel panel-default">

        <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordionMenu" href="#collapseThree" aria-expanded="true" aria-controls="collapseOne">
                    Payment Voucher
                </a>
            </h4>
        </div>
        <div id="collapseThree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
                <ul class="nav">
                    <li><a target="_blank" href="<?= Yii::$app->homeUrl; ?>uploads/license_procedure/voucher_documents/ejari/<?= $payment_voucher->id ?>.<?= $payment_voucher->ejari ?>"> Ejari</a></li>
                    <li><a target="_blank" href="<?= Yii::$app->homeUrl; ?>uploads/license_procedure/voucher_documents/main_license/<?= $payment_voucher->id ?>.<?= $payment_voucher->main_license ?>"> Main License</a></li>
                    <li><a target="_blank" href="<?= Yii::$app->homeUrl; ?>uploads/license_procedure/voucher_documents/noc/<?= $payment_voucher->id ?>.<?= $payment_voucher->noc ?>"> NOC</a></li>
                    <li><a target="_blank" href="<?= Yii::$app->homeUrl; ?>uploads/license_procedure/voucher_documents/service_receipt/<?= $payment_voucher->id ?>.<?= $payment_voucher->service_receipt ?>">Service Receipt</a></li>
                    <li><a target="_blank" href="<?= Yii::$app->homeUrl; ?>uploads/license_procedure/voucher_documents/voucher_attachment/<?= $payment_voucher->id ?>.<?= $payment_voucher->voucher_attachment ?>">Voucher Attachment</a></li>
                </ul>
            </div>
        </div>

    </div>
    <?php
}
?>
<?php
if (!empty($license_document)) {
    ?>
    <div class="panel panel-default">

        <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordionMenu" href="#collapseFour" aria-expanded="true" aria-controls="collapseOne">
                    License Document
                </a>
            </h4>
        </div>
        <div id="collapseFour" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
                <ul class="nav">
                    <li><a target="_blank" href="<?= Yii::$app->homeUrl; ?>uploads/license_procedure/licence/licence_attachment/<?= $license_document->id ?>.<?= $license_document->licence_attachment ?>"> License Attachment</a></li>

                </ul>
            </div>
        </div>

    </div>
    <?php
}
?>
<?php
if (!empty($newstamp)) {
    ?>
    <div class="panel panel-default">

        <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordionMenu" href="#collapseFive" aria-expanded="true" aria-controls="collapseOne">
                    New Stamp
                </a>
            </h4>
        </div>
        <div id="collapseFive" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
                <ul class="nav">
                    <li><a target="_blank" href="<?= Yii::$app->homeUrl; ?>uploads/license_procedure/new_stamp/receipt/<?= $newstamp->id ?>.<?= $newstamp->receipt ?>"> Receipt</a></li>

                </ul>
            </div>
        </div>

    </div>
    <?php
}
?>
<?php
if (!empty($company_card)) {
    ?>
    <div class="panel panel-default">

        <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordionMenu" href="#collapseSix" aria-expanded="true" aria-controls="collapseOne">
                    Company Establishment Card
                </a>
            </h4>
        </div>
        <div id="collapseSix" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
                <ul class="nav">
                    <li><a target="_blank" href="<?= Yii::$app->homeUrl; ?>uploads/license_procedure/company-establishment-card/license/<?= $company_card->id ?>.<?= $company_card->license ?>"> License</a></li>
                    <li><a target="_blank" href="<?= Yii::$app->homeUrl; ?>uploads/license_procedure/company-establishment-card/service_receipt/<?= $company_card->id ?>.<?= $company_card->service_reciept ?>"> Service Receipt</a></li>
                    <li><a target="_blank" href="<?= Yii::$app->homeUrl; ?>uploads/license_procedure/company-establishment-card/payment_receipt/<?= $company_card->id ?>.<?= $company_card->payment_reciept ?>"> Payment Receipt</a></li>
                    <li><a target="_blank" href="<?= Yii::$app->homeUrl; ?>uploads/license_procedure/company-establishment-card/card_attachment/<?= $company_card->id ?>.<?= $company_card->card_attachment ?>"> Card Attachment</a></li>

                </ul>
            </div>
        </div>
    </div>
    <?php
}
?>
<?php
if (!empty($municipality_documents)) {
    ?>
    <div class="panel panel-default">

        <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordionMenu" href="#collapseSeven" aria-expanded="true" aria-controls="collapseOne">
                    Municipality Approval
                </a>
            </h4>
        </div>
        <div id="collapseSeven" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
                <ul class="nav">
                    <li><a target="_blank" href="<?= Yii::$app->homeUrl; ?>uploads/license_procedure/municipality_approval/payment_receipt/<?= $municipality_documents->id ?>.<?= $municipality_documents->payment_receipt ?>">Payment Receipt</a></li>

                </ul>
            </div>
        </div>

    </div>
    <?php
}
?>
<?php
if (!empty($rta)) {
    ?>
    <div class="panel panel-default">

        <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordionMenu" href="#collapseEight" aria-expanded="true" aria-controls="collapseOne">
                    RTA
                </a>
            </h4>
        </div>
        <div id="collapseEight" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
                <ul class="nav">
                    <li><a target="_blank" href="<?= Yii::$app->homeUrl; ?>uploads/license_procedure/rta/approval_certificate/<?= $rta->id ?>.<?= $rta->approval_certificate ?>">Approval Receipt</a></li>
                    <li><a target="_blank" href="<?= Yii::$app->homeUrl; ?>uploads/license_procedure/rta/approval_fees_receipt/<?= $rta->id ?>.<?= $rta->approval_fees_receipt ?>">Approval Fees Receipt</a></li>
                    <li><a target="_blank" href="<?= Yii::$app->homeUrl; ?>uploads/license_procedure/rta/payment_receipt/<?= $rta->id ?>.<?= $rta->payment_receipt ?>">Payment Receipt</a></li>

                </ul>
            </div>
        </div>

    </div>
    <?php
}
?>
<?php
if (!empty($dps)) {
    ?>
    <div class="panel panel-default">

        <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordionMenu" href="#collapseNine" aria-expanded="true" aria-controls="collapseOne">
                    DPS
                </a>
            </h4>
        </div>
        <div id="collapseNine" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
                <ul class="nav">
                    <li><a target="_blank" href="<?= Yii::$app->homeUrl; ?>uploads/license_procedure/dps/approval_certificate/<?= $dps->id ?>.<?= $dps->approval_certificate ?>">Approval Receipt</a></li>
                    <li><a target="_blank" href="<?= Yii::$app->homeUrl; ?>uploads/license_procedure/dps/approval_fees_receipt/<?= $dps->id ?>.<?= $dps->approval_fees_receipt ?>">Approval Fees Receipt</a></li>
                    <li><a target="_blank" href="<?= Yii::$app->homeUrl; ?>uploads/license_procedure/dps/payment_receipt/<?= $dps->id ?>.<?= $dps->payment_receipt ?>">Payment Receipt</a></li>
                    <li><a target="_blank" href="<?= Yii::$app->homeUrl; ?>uploads/license_procedure/dps/police_report/<?= $dps->id ?>.<?= $dps->police_report ?>">Police Report</a></li>

                </ul>
            </div>
        </div>

    </div>
    <?php
}
?>
<?php
if (!empty($police_noc)) {
    ?>
    <div class="panel panel-default">

        <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordionMenu" href="#collapseFour" aria-expanded="true" aria-controls="collapseOne">
                    Police NOC
                </a>
            </h4>
        </div>
        <div id="collapseFour" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
                <ul class="nav">
                    <li><a target="_blank" href="<?= Yii::$app->homeUrl; ?>uploads/license_procedure/police_noc/passport_copy/<?= $police_noc->id ?>.<?= $police_noc->passport_copy ?>">Passport Copy</a></li>
                    <li><a target="_blank" href="<?= Yii::$app->homeUrl; ?>uploads/license_procedure/police_noc/receipt/<?= $police_noc->id ?>.<?= $police_noc->receipt ?>">Receipt</a></li>
                    <li><a target="_blank" href="<?= Yii::$app->homeUrl; ?>uploads/license_procedure/police_noc/certificate/<?= $police_noc->id ?>.<?= $police_noc->certificate ?>">Certificate</a></li>
                </ul>
            </div>
        </div>

    </div>
    <?php
}
?>
<?php
if (!empty($others)) {
    ?>
    <div class="panel panel-default">

        <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordionMenu" href="#collapseEleven" aria-expanded="true" aria-controls="collapseOne">
                    OTHERS
                </a>
            </h4>
        </div>
        <div id="collapseEleven" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
                <ul class="nav">
                    <li><a target="_blank" href="<?= Yii::$app->homeUrl; ?>uploads/license_procedure/dps/approval_certificate/<?= $others->id ?>.<?= $others->approval_certificate ?>">Approval Receipt</a></li>
                    <li><a target="_blank" href="<?= Yii::$app->homeUrl; ?>uploads/license_procedure/dps/approval_fees_receipt/<?= $others->id ?>.<?= $others->approval_fees_receipt ?>">Approval Fees Receipt</a></li>
                    <li><a target="_blank" href="<?= Yii::$app->homeUrl; ?>uploads/license_procedure/dps/payment_receipt/<?= $others->id ?>.<?= $others->payment_receipt ?>">Payment Receipt</a></li>
                    <li><a target="_blank" href="<?= Yii::$app->homeUrl; ?>uploads/license_procedure/dps/police_report/<?= $others->id ?>.<?= $others->police_report ?>">Police Report</a></li>

                </ul>
            </div>
        </div>

    </div>
    <?php
}
?>