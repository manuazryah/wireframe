<?php

use yii\helpers\Html;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$estate_details = \common\models\RealEstateDetails::find()->where(['master_id' => $model->id, 'category' => 2])->all();
?>
<tr>
    <td><?= Html::a(common\models\CompanyManagement::findOne($model->company)->company_name, ['/masters/company-management/update', 'id' => $model->company], ['class' => '']) ?></td>
    <td><?= $model->reference_code ?></td>
    <td><?= Html::a(common\models\Sponsor::findOne($model->sponsor)->name, ['/masters/sponsor/update', 'id' => $model->sponsor], ['class' => '']) ?></td>
    <?php
    if (!empty($estate_details)) {
        foreach ($estate_details as $estate_detail) {
            $cost = '';
            if ($estate_detail->availability == 1) {
                $cost = $estate_detail->cost;
            } else {
                $appointment = \common\models\Appointment::find()->where(['plot' => $estate_detail->id])->one();
                if (!empty($appointment)) {
                    $appoinrment_services = common\models\AppointmentService::find()->where(['appointment_id' => $appointment->id, 'service' => 7])->one();
                    if (!empty($appoinrment_services)) {
                        $cost = $appoinrment_services->total;
                    }
                }
            }
            ?>
            <td class="txt-center <?= $estate_detail->availability == 1 ? 'green' : '' ?>"><?= $cost ?></td>
            <?php
        }
    }
    if (count($estate_details) < 26) {
        $new_count = 26 - count($estate_details);
        for ($i = 1; $i <= $new_count; $i++) {
            ?>
            <td style="background-image: url('<?= Yii::$app->homeUrl; ?>img/slash.png')"></td>
            <?php
        }
    }
    ?>
</tr>

