<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\RealEstateMaster */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Real Estate Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Default box -->
<div class="box">
    <div class="real-estate-master-view">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <?= Html::a('<span> Manage Real Estate Master</span>', ['index'], ['class' => 'btn btn-warning mrg-bot-15']) ?>
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
            'company',
            'reference_code',
            'total_square_feet',
            'sponsor',
            'comany_name_for_ejari',
            'number_of_license',
            'number_of_plots',
            'comment:ntext',
            'rent_total',
            'no_of_cheques',
            'commission',
            'deposit',
            'sponser_fee',
            'furniture_expense',
            'office_renovation_expense',
            'other_expense',
            'attachments',
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


