<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\CompanyManagement;
use common\models\Sponsor;
use kartik\export\ExportMenu;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\RealEstateMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Real Estate Management';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Default box -->
<div class="box">
    <div class="real-estate-master-index">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= Html::a('<span> Create Real Estate</span>', ['create'], ['class' => 'btn btn-block manage-btn']) ?>
            <?= \common\components\AlertMessageWidget::widget() ?>
            <?php
            $gridColumns = [
                ['class' => 'yii\grid\SerialColumn'],
                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{update}{delete}',
                    'contentOptions' => ['style' => 'width:60px;'],
                    'buttons' => [
                        'update' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                        'title' => Yii::t('app', 'update'),
                                        'class' => '',
                            ]);
                        },
                        'delete' => function ($url, $model) {
                            $check_exist = \common\models\RealEstateDetails::find()->where(['master_id' => $model->id, 'availability' => 0])->all();
                            if (empty($check_exist)) {
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                            'title' => Yii::t('app', 'delete'),
                                            'class' => '',
                                            'data' => [
                                                'confirm' => 'Are you sure you want to delete?',
                                            ],
                                ]);
                            }
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
                    }],
                [
                    'attribute' => 'type',
                    'label' => 'Type',
                    'value' => function ($model) {
                        return $model->type == 1 ? 'Istadama' : '';
                    },
                    'filter' => ['' => 'Select', 1 => 'Istadama'],
                ],
                [
                    'attribute' => 'company',
                    'label' => 'Company Name',
                    'value' => 'company0.company_name',
                    'filter' => ArrayHelper::map(CompanyManagement::find()->asArray()->all(), 'id', 'company_name'),
                ],
                'reference_code',
                'total_square_feet',
                [
                    'attribute' => 'sponsor',
                    'label' => 'Sponsor Name',
                    'value' => 'sponsor0.name',
                    'filter' => ArrayHelper::map(Sponsor::find()->asArray()->all(), 'id', 'name'),
                ],
                [
                    'attribute' => 'comany_name_for_ejari',
                    'label' => 'Ejari',
                ],
                'number_of_license',
                'number_of_plots',
                'rent_total',
                'no_of_cheques',
                'commission',
                'deposit',
                'sponser_fee',
                'furniture_expense',
                'office_renovation_expense',
                'other_expense',
                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{update}{delete}',
                    'contentOptions' => ['style' => 'width:60px;'],
                    'buttons' => [
                        'update' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                        'title' => Yii::t('app', 'update'),
                                        'class' => '',
                            ]);
                        },
                        'delete' => function ($url, $model) {
                            $check_exist = \common\models\RealEstateDetails::find()->where(['master_id' => $model->id, 'availability' => 0])->all();
                            if (empty($check_exist)) {
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                            'title' => Yii::t('app', 'delete'),
                                            'class' => '',
                                            'data' => [
                                                'confirm' => 'Are you sure you want to delete?',
                                            ],
                                ]);
                            }
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
                    }],
            ];

// Renders a export dropdown menu
            echo ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'columns' => $gridColumns
            ]);

// You can choose to render your own GridView separately
            echo \kartik\grid\GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => $gridColumns
            ]);
            ?>
        </div>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->

