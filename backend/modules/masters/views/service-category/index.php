<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ServiceCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Service Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Default box -->
<div class="box table-responsive">
    <div class="service-category-index">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body table-responsive">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= Html::a('<span> Create Service Category</span>', ['create'], ['class' => 'btn btn-block manage-btn']) ?>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
//                            'id',
                    'category_name',
                    'category_code',
                    'comment:ntext',
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'filter' => [1 => 'Enabled', 0 => 'Disabled'],
                        'value' => function ($model) {
                            return $model->status == 1 ? 'Enabled' : 'Disabled';
                        },
                    ],
                    // 'CB',
                    // 'UB',
                    // 'DOC',
                    // 'DOU',
                   ['class' => 'yii\grid\ActionColumn',
                        'template' => '{update}{delete}',
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->

