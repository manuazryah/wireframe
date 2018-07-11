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
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= Html::a('<span> Create Admin Posts</span>', ['create'], ['class' => 'btn btn-block manage-btn']) ?>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
//                            'id',
                    'post_name',
                        [
                        'attribute' => 'admin',
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
                    // 'CB',
                    // 'UB',
                    // 'DOC',
                    // 'DOU',
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]);
            ?>
        </div>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->

