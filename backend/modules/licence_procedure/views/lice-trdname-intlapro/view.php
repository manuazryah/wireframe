<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\LiceTrdnameIntlapro */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Lice Trdname Intlapros', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Default box -->
<div class="box">
    <div class="lice-trdname-intlapro-view">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <?= Html::a('<span> Manage Lice Trdname Intlapro</span>', ['index'], ['class' => 'btn btn-warning mrg-bot-15']) ?>
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
            'payment_amount',
            'payment_receipt',
            'certificate',
            'status',
            'CB',
            'date',
            'next_step',
            'sponsor_family_book',
            'comment:ntext',
            ],
            ]) ?>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->


