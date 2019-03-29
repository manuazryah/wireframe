<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="<?= $step == 1 ? 'active' : '' ?>">
        <?= Html::a('Step 1', ['update', 'id' => $license_master->id], ['class' => 'step-links']) ?>
    </li>
    <li role="presentation" class="<?= $step == 2 ? 'active' : '' ?>">
        <?= Html::a('Step 2', ['moa', 'id' => $license_master->id], ['class' => 'step-links']) ?>
    </li>
    <li role="presentation" class="<?= $step == 3 ? 'active' : '' ?>">
        <?= Html::a('Step 3', ['payment-voucher', 'id' => $license_master->id], ['class' => 'step-links']) ?>
    </li>
    <li role="presentation" class="<?= $step == 4 ? 'active' : '' ?>">
        <?= Html::a('Step 4', ['licence', 'id' => $license_master->id], ['class' => 'step-links']) ?>
    </li>
    <li role="presentation" class="<?= $step == 5 ? 'active' : '' ?>">
        <?= Html::a('Step 5', ['new-stamp', 'id' => $license_master->id], ['class' => 'step-links']) ?>
    </li>
    <li role="presentation" class="<?= $step == 6 ? 'active' : '' ?>">
        <?= Html::a('Step 6', ['company-establishment-card', 'id' => $license_master->id], ['class' => 'step-links']) ?>
    </li>
    <li role="presentation" class="<?= $step == 7 ? 'active' : '' ?>">
        <?= Html::a('Step 7', ['labour-card', 'id' => $license_master->id], ['class' => 'step-links']) ?>
    </li>
</ul>