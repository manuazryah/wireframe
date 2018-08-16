<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\Debtor;
use common\models\AppointmentServices;
use common\models\Sponsor;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AppointmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Accounts (Appointments)';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Default box -->
<div class="box table-responsive">
    <div class="appointment-index">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body table-responsive">
            <?= \common\components\AlertMessageWidget::widget() ?>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
//                            'id',
                    [
                        'attribute' => 'customer',
                        'value' => 'customer0.company_name',
                        'filter' => ArrayHelper::map(Debtor::find()->asArray()->all(), 'id', 'company_name'),
                    ],
                    [
                        'attribute' => 'service_type',
                        'value' => 'serviceType.service',
                        'filter' => ArrayHelper::map(AppointmentServices::find()->asArray()->all(), 'id', 'service'),
                    ],
                    'service_id',
                    [
                        'attribute' => 'sponsor',
                        'value' => 'sponsor0.name',
                        'filter' => ArrayHelper::map(Sponsor::find()->asArray()->all(), 'id', 'name'),
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'contentOptions' => ['style' => 'width:50px;'],
                        'header' => 'Actions',
                        'template' => '{service}',
                        'buttons' => [
                            'service' => function ($url, $model) {
                                return Html::a('<i class="fa fa-database"></i>', $url, [
                                            'title' => Yii::t('app', 'service'),
                                            'class' => '',
                                ]);
                            },
                        ],
                        'urlCreator' => function ($action, $model) {
                            if ($action === 'service') {
                                if ($model->status == 2) {
                                    $url = Url::to(['service-payment', 'id' => $model->id]);
                                } elseif ($model->status == 3) {
                                    $url = Url::to(['payment', 'id' => $model->id]);
                                }
                                return $url;
                            }
                        }
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->

