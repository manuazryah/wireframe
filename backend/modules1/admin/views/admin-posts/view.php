<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\AdminPosts */

$this->title = $model->post_name;
$this->params['breadcrumbs'][] = ['label' => 'Admin Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Default box -->
<div class="box">
    <div class="admin-posts-view">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <?= Html::a('<span> Manage Admin Posts</span>', ['index'], ['class' => 'btn btn-warning mrg-bot-15']) ?>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary mrg-bot-15']) ?>
            <?=
            Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger mrg-bot-15',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ])
            ?>

            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'post_name',
                        [
                        'label' => 'Admin',
                        'format' => 'raw',
                        'value' => $model->admin == 1 ? 'Yes' : 'No',
                    ],
                        [
                        'label' => 'Masters',
                        'format' => 'raw',
                        'value' => $model->masters == 1 ? 'Yes' : 'No',
                    ],
                        [
                        'attribute' => 'status',
                        'value' => call_user_func(function($model) {
                                    if ($model->status == 1) {
                                        return 'ENABLED';
                                    } else {
                                        return 'DISABLED';
                                    }
                                }, $model),
                    ],
                        [
                        'attribute' => 'DOC',
                        'label' => 'Date of Creation',
                    ],
                        [
                        'attribute' => 'DOU',
                        'label' => 'Date of Updation',
                    ],
                ],
            ])
            ?>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->


