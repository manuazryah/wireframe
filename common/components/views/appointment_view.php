<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php
if (!empty($appointment)) {
    ?>
    <div class="customer-info">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 content-box">
            <ul>
                <li>Customer name / ID</li>
                <li><?= $appointment->customer != '' ? common\models\Debtor::findOne($appointment->customer)->company_name : '' ?></li>
            </ul>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 content-box">
            <ul>
                <li>Email / Phone</li>
                <li><?= $appointment->customer != '' ? common\models\Debtor::findOne($appointment->customer)->email : '' ?></li>
            </ul>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 content-box">
            <ul>
                <li>Service ID</li>
                <li><?= $appointment->service_id ?></li>
            </ul>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 content-box">
            <ul>
                <li>Service type</li>
                <li><?= $appointment->service_type != '' ? common\models\AppointmentServices::findOne($appointment->service_type)->service : '' ?></li>
            </ul>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 content-box">
            <ul>
                <li>Sponsor</li>
                <li><?= $appointment->sponsor != '' ? common\models\Sponsor::findOne($appointment->sponsor)->name : '' ?></li>
            </ul>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 content-box">
            <ul>
                <li>Space ID</li>
                <?php
                if ($appointment->space_for_license != '') {
                    $estate_details = common\models\RealEstateDetails::findOne($appointment->space_for_license);
                    if (!empty($estate_details)) {
                        if ($estate_details->master_id != '') {
                            $estate_master = common\models\RealEstateMaster::findOne($estate_details->master_id);
                            $space = $estate_master->reference_code . '-' . $estate_details->code;
                        } else {
                            $space = '';
                        }
                    } else {
                        $space = '';
                    }
                } else {
                    $space = '';
                }
                ?>
                <li><?= $space ?></li>
            </ul>
        </div>
    </div>
    <?php
}
?>