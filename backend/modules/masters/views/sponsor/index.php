<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SponsorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sponsors';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Default box -->
<div class="box table-responsive">
    <div class="sponsor-index">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body table-responsive">
            <?= Html::a('<span> Create Sponsor</span>', ['create'], ['class' => 'btn btn-block manage-btn']) ?>
            <?= \common\components\AlertMessageWidget::widget() ?>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
//                            'id',
                    'name',
                    'reference_code',
                    'email:email',
                    'phone_number',
                    // 'address:ntext',
                    // 'comment:ntext',
                    // 'emirate_id',
                    // 'passport',
                    // 'family_book',
                    // 'photo',
                    // 'others',
                    // 'status',
                    // 'CB',
                    // 'UB',
                    // 'DOC',
                    // 'DOU',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'contentOptions' => ['style' => 'width:30px;'],
//                        'header' => 'Actions',
                        'template' => '{update}{delete}{payment}',
                        'buttons' => [
                            'payment' => function ($url, $model) {
                                return Html::a('<i class="fa fa-pencil"></i>', $url, [
                                            'title' => Yii::t('app', 'update'),
                                            'class' => '',
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                $estate_details = common\models\RealEstateMaster::find()->where(['sponsor' => $model->id])->all();
                                $appointment = common\models\Appointment::find()->where(['sponsor' => $model->id])->all();
                                if (empty($appointment) && empty($estate_details)) {
                                    return Html::a('<i class="fa fa-trash-o"></i>', $url, [
                                                'title' => Yii::t('app', 'delete'),
                                                'class' => '',
                                    ]);
                                }
                            },
                            'payment' => function ($url, $model) {
                                return Html::a('<i class="fa fa-credit-card"></i>', $url, [
                                            'title' => Yii::t('app', 'payment'),
                                            'class' => '',
                                ]);
                            },
                        ],
                        'urlCreator' => function ($action, $model) {
                            if ($action === 'update') {
                                $url = Url::to(['update', 'id' => $model->id]);
                                return $url;
                            }
                            if ($action === 'delete') {
                                $url = Url::to(['delete', 'id' => $model->id]);
                                return $url;
                            }
                            if ($action === 'payment') {
                                $url = Url::to(['sponsor-payment', 'id' => $model->id]);
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

