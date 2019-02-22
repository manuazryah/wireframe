<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\RealEstateDetails */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Real Estate Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Default box -->
<div class="box">
    <div class="real-estate-details-view">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <?= Html::a('<span> Manage Real Estate Details</span>', ['index'], ['class' => 'btn btn-warning mrg-bot-15']) ?>
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
            'master_id',
            'category',
            'code',
            'availability',
            'customer_id',
            'cost',
            'rent_cost',
            'off_rent',
            'square_feet',
            'comment:ntext',
            'status',
            'CB',
            'UB',
            'DOC',
            'DOU',
            ],
            ]) ?>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->


