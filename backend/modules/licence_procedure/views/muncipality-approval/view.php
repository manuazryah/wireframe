<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\MuncipalityApproval */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Muncipality Approvals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="muncipality-approval-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'licencing_master_id',
            'online_reference_number',
            'online_application_fees',
            'payment_receipt',
            'status',
            'CB',
            'date',
            'next_step',
            'comment:ntext',
        ],
    ]) ?>

</div>
