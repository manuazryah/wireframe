<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\RealEstateDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Real Estate Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Default box -->
<div class="box table-responsive">
    <div class="real-estate-details-index">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body table-responsive">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= Html::a('<span> Create Real Estate Details</span>', ['create'], ['class' => 'btn btn-block manage-btn']) ?>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'customer',
                        'format' => 'raw',
                        'value' => function ($data) {
                            if (isset($data->customer)) {
                                return \yii\helpers\Html::a(Debtor::findOne($data->customer)->company_name, ['/masters/debtor/update', 'id' => $data->customer], ['target' => '_blank']);
                            } else {
                                return '';
                            }
                        },
                        'filter' => Select2::widget([
                            'name' => 'AppointmentSearch[customer]',
                            'model' => $searchModel,
                            'value' => $searchModel->customer,
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
                    'availability',
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]);
            ?>
        </div>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->

