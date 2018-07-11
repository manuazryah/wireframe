<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Debtor */

$this->title = $model->company_name;
$this->params['breadcrumbs'][] = ['label' => 'Debtors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Default box -->
<div class="box">
    <div class="debtor-view">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <?= Html::a('<span> Manage Debtor</span>', ['index'], ['class' => 'btn btn-warning mrg-bot-15']) ?>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary mrg-bot-15']) ?>
            <?=
            Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger mrg-bot-15',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ])
            ?>

            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'company_name',
                    'reference_code',
                    'email:email',
                    'phone_number',
                    'address:ntext',
                    'contact_person',
                    'contact_person_email:email',
                    'contact_person_phone',
                    [
                        'attribute' => 'nationality',
                        'value' => call_user_func(function($model) {
                                    if ($model->nationality != '') {
                                        return \common\models\Country::findOne($model->nationality)->country_name;
                                    }
                                }, $model),
                    ],
                    'comment:ntext',
                    'TRN',
                    [
                        'attribute' => 'status',
                        'value' => call_user_func(function($model) {
                                    if ($model->status == 1) {
                                        return 'ENABLED';
                                    } else {
                                        return 'DISABLED';
                                    }
                                }, $model),
                    ],
                    [
                        'attribute' => 'DOC',
                        'label' => 'Date of Creation',
                    ],
                    [
                        'attribute' => 'DOU',
                        'label' => 'Date of Updation',
                    ],
                ],
            ])
            ?>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->


