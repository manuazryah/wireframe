<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\NotificationsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Notifications';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .glyphicon-eye-open{
        color:green;
    }
</style>
<!-- Default box -->
<div class="box table-responsive">
    <div class="notifications-index">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body table-responsive">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'notification_type',
                        'format' => 'raw',
                        'value' => function ($data) {
                            if ($data->notification_type == 1) {
                                return "Real Estate Cheque";
                            } elseif ($data->notification_type == 2) {
                                return "Appointment service cheque";
                            } elseif ($data->notification_type == 3) {
                                return "Appointment Generate";
                            } elseif ($data->notification_type == 4) {
                                return "Appointment Approved";
                            } elseif ($data->notification_type == 5) {
                                return "Payment";
                            } else {
                                return '';
                            }
                        },
                    ],
                    [
                        'attribute' => 'notification_content',
                        'format' => 'raw',
                        'value' => function ($data ) {
                            if (!empty($data->notification_content)) {
                                $message = wordwrap($data->notification_content, 200, "<br />\n");
                                return $message;
                            } else {
                                return '';
                            }
                        },
                    ],
                    ['class' => 'yii\grid\ActionColumn',
                        'contentOptions' => ['style' => 'width:40px;'],
                        'template' => '{view}'
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->

