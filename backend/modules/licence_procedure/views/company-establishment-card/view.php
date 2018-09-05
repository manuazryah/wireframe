<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\CompanyEstablishmentCard */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Company Establishment Cards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Default box -->
<div class="box">
    <div class="company-establishment-card-view">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <?= Html::a('<span> Manage Company Establishment Card</span>', ['index'], ['class' => 'btn btn-warning mrg-bot-15']) ?>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary mrg-bot-15']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger mrg-bot-15',
            'data' => [
            'confirm' => 'Are you sure you want to delete this item?',
            'method' => 'post',
            ],
            ]) ?>

            <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                        'id',
            'licensing_master_id',
            'typing_service',
            'service_reciept',
            'payment',
            'payment_reciept',
            'card_attachment',
            'expiry_date',
            'status',
            'CB',
            'date',
            'next_step',
            'comment:ntext',
            ],
            ]) ?>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->


