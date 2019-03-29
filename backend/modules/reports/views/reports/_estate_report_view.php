<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$estate_details = \common\models\RealEstateDetails::find()->where(['master_id' => $model->id, 'category' => 2])->all();
?>
<tr>
    <td><?= common\models\CompanyManagement::findOne($model->company)->company_name ?></td>
    <?php
    if (!empty($estate_details)) {
        foreach ($estate_details as $estate_detail) {
            ?>
            <td class="txt-center <?= $estate_detail->availability == 1 ? 'green' : '' ?>"><?= $estate_detail->cost ?></td>
            <?php
        }
    }
    if (count($estate_details) < 26) {
        $new_count = 26 - count($estate_details);
        for ($i = 1; $i <= $new_count; $i++) {
            ?>
            <td></td>
            <?php
        }
    }
    ?>
</tr>

