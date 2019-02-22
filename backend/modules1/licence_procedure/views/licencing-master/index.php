<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\Debtor;
use kartik\select2\Select2;
use common\models\Sponsor;

/* @var $this yii\web\View */
/* @var $searchModel common\models\LicencingMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'License Procedure';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Default box -->
<div class="box table-responsive">
    <div class="licencing-master-index">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body table-responsive">
            <?php // echo $this->render('_search', ['model' => $searchModel]);   ?>

            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'appointment_no',
                    [
                        'attribute' => 'customer_id',
                        'format' => 'raw',
                        'value' => function ($data) {
                            if (isset($data->customer_id)) {
                                return \yii\helpers\Html::a(Debtor::findOne($data->customer_id)->company_name, ['/masters/debtor/update', 'id' => $data->customer_id], ['target' => '_blank']);
                            } else {
                                return '';
                            }
                        },
                        'filter' => Select2::widget([
                            'name' => 'LicencingMasterSearch[customer_id]',
                            'model' => $searchModel,
                            'value' => $searchModel->customer_id,
                            'data' => ArrayHelper::map(
                                    common\models\Debtor::findAll(['status' => 1]), 'id', 'company_name'
                            ),
                            'size' => Select2::MEDIUM,
                            'options' => [
                                'placeholder' => '-- Select --',
                                'style' => 'width: 300px;'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                    ],
                    [
                        'attribute' => 'sponsor',
                        'format' => 'raw',
                        'value' => function ($data) {
                            if (isset($data->sponsor)) {
                                return \yii\helpers\Html::a(Sponsor::findOne($data->sponsor)->name, ['/masters/sponsor/update', 'id' => $data->sponsor], ['target' => '_blank']);
                            } else {
                                return '';
                            }
                        },
                        'filter' => Select2::widget([
                            'name' => 'AppointmentSearch[sponsor]',
                            'model' => $searchModel,
                            'value' => $searchModel->sponsor,
                            'data' => ArrayHelper::map(
                                    common\models\Sponsor::findAll(['status' => 1]), 'id', 'name'
                            ),
                            'size' => Select2::MEDIUM,
                            'options' => [
                                'placeholder' => '-- Select --',
                                'style' => 'width: 300px;'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                    ],
                    [
                        'attribute' => 'status',
                        'value' => function($data) {
                            if ($data->status == 1) {
                                return 'Not Started';
                            } elseif ($data->status == 2) {
                                return 'On Process';
                            } elseif ($data->status == 3) {
                                return 'Closed';
                            } elseif ($data->status == 4) {
                                return 'Pending';
                            } else {
                                return '';
                            }
                        },
                        'filter' => [1 => 'Not Started', 2 => 'On Process', 3 => 'Closed', 4 => 'Pending'],
                    ],
                    // 'plot',
                    // 'space_for_licence',
                    // 'no_of_partners',
                    // 'stage',
                    // 'comment',
                    // 'CB',
                    // 'DOC',
                    ['class' => 'yii\grid\ActionColumn',
                        'template' => '{update}',
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->

