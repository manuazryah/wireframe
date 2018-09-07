<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Others */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Others', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Default box -->
<div class="box">
    <div class="others-view">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <?= Html::a('<span> Manage Others</span>', ['index'], ['class' => 'btn btn-warning mrg-bot-15']) ?>
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
            'personal_detail',
            'online_refrerence_number',
            'online_application_fees',
            'payment_receipt',
            'sira_approval_fees',
            'approval_fees_receipt',
            'police_report',
            'approval_certificate',
            'CB',
            'date',
            'next_step',
            'comment:ntext',
            ],
            ]) ?>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->


