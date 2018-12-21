<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Notifications */

$this->title = 'Notifications';
$this->params['breadcrumbs'][] = ['label' => 'Notifications', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Default box -->
<div class="box">
    <div class="notifications-view">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <?= Html::a('<span> View All Notifications</span>', ['index'], ['class' => 'btn btn-warning mrg-bot-15']) ?>
            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'notification_type',
                        'value' => function ($data) {
                            if ($data->notification_type == 1) {
                                return "Real Estate Cheque";
                            } elseif ($data->notification_type == 2) {
                                return "Appointment service cheque";
                            } elseif ($data->notification_type == 3) {
                                return "Appointment Generate";
                            } elseif ($data->notification_type == 4) {
                                return "Appointment Approved";
                            } else {
                                return '';
                            }
                        },
                    ],
                    'notification_content:ntext',
                    'date',
                ],
            ])
            ?>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->


