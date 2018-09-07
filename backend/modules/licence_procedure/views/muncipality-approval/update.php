<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MuncipalityApproval */

$this->title = 'Update Muncipality Approval: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Muncipality Approvals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="muncipality-approval-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
