<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AdminPostsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Admin Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Default box -->
<div class="box table-responsive">
    <div class="admin-posts-index">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <?= \common\components\AlertMessageWidget::widget() ?>

            <?php // Html::a('<span> Create Admin Posts</span>', ['create'], ['class' => 'btn btn-block manage-btn']) ?>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
//                            'id',
                    'post_name',
                    [
                        'attribute' => 'success',
                        'format' => 'raw',
                        'filter' => [1 => 'Yes', 0 => 'No'],
                        'value' => function ($model) {
                            return $model->admin == 1 ? 'Yes' : 'No';
                        },
                    ],
                    [
                        'attribute' => 'masters',
                        'format' => 'raw',
                        'filter' => [1 => 'Yes', 0 => 'No'],
                        'value' => function ($model) {
                            return $model->masters == 1 ? 'Yes' : 'No';
                        },
                    ],
                    [
                        'attribute' => 'sales',
                        'format' => 'raw',
                        'filter' => [1 => 'Yes', 0 => 'No'],
                        'value' => function ($model) {
                            return $model->sales == 1 ? 'Yes' : 'No';
                        },
                    ],
                    [
                        'attribute' => 'accounts',
                        'format' => 'raw',
                        'filter' => [1 => 'Yes', 0 => 'No'],
                        'value' => function ($model) {
                            return $model->accounts == 1 ? 'Yes' : 'No';
                        },
                    ],
                    [
                        'attribute' => 'operations',
                        'format' => 'raw',
                        'filter' => [1 => 'Yes', 0 => 'No'],
                        'value' => function ($model) {
                            return $model->operations == 1 ? 'Yes' : 'No';
                        },
                    ],
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

