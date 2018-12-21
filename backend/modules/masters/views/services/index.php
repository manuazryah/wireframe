<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\ServiceCategory;
use common\models\ServiceType;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ServicesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Services';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Default box -->
<div class="box table-responsive">
    <div class="services-index">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body table-responsive">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= Html::a('<span> Create Services</span>', ['create'], ['class' => 'btn btn-block manage-btn']) ?>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
//                            'id',
                    [
                        'attribute' => 'service_category',
                        'value' => function($data) {
                            return ServiceCategory::findOne($data->service_category)->category_name;
                        },
                        'filter' => ArrayHelper::map(ServiceCategory::find()->asArray()->all(), 'id', 'category_name'),
                        'filterOptions' => array('id' => "service_category_search"),
                    ],
                    [
                        'attribute' => 'type',
                        'value' => function($data) {
                            return ServiceType::findOne($data->type)->type;
                        },
                        'filter' => ArrayHelper::map(ServiceType::find()->asArray()->all(), 'id', 'type'),
                        'filterOptions' => array('id' => "service_category_search"),
                    ],
                    'service_name',
                    'service_code',
                    'estimated_cost',
                    // 'supplier',
                    // 'estimated_cost',
                    // 'tax_id',
                    // 'tax_percentage',
                    // 'comment:ntext',
                    // 'status',
                    // 'CB',
                    // 'UB',
                    // 'DOC',
                    // 'DOU',
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

