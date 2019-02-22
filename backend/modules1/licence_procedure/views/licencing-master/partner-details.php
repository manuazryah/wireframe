<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PartnerDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Partner Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .modal-header{
        font-size: 18px;
        font-weight: 600;
    }
</style>
<!-- Default box -->
<div class="box table-responsive">
    <div class="partner-details-index">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body table-responsive">
            <?= Html::a('<span>License Procedure</span>', ['update', 'id' => $license_master->id], ['class' => 'btn btn-block manage-btn', 'style' => 'display: inline-block']) ?>
            <?= Html::button('<span> Add Partner Details</span>', ['value' => Url::to(['add-partner', 'id' => $license_master->id]), 'class' => 'btn btn-block manage-btn modalButton', 'style' => 'display: inline-block;margin-top: 0px;']) ?>
            <?= \common\components\AlertMessageWidget::widget() ?>
            <section id="tabs">
                <div class="card1">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <?php
                            echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Partner Details</span>', ['licencing-master/partner-details', 'id' => $license_master->id]);
                            ?>
                        </li>
                        <li role="presentation">
                            <?php
                            echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Partner Documents</span>', ['licencing-master/partner-documents', 'id' => $license_master->id]);
                            ?>
                        </li>
                    </ul>
                </div>
            </section>
            <?php
            Modal::begin([
                'header' => 'Partner Details',
                'id' => 'modal',
                'size' => 'modal-lg',
            ]);
            echo "<div id = 'modalContent'></div>";
            Modal::end();
            ?>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'name',
                    'email:email',
                    'phone_no',
                    'address:ntext',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => 'Actions',
                        'template' => '{update}{delete}',
                        'buttons' => [
                            'update' => function ($url, $model) use ($license_master) {
                                return Html::button('<i class="fa fa-pencil"></i>', ['value' => Url::to(['update-partner', 'id' => $model->id, 'licence_id' => $license_master->id]), 'class' => 'modalButton edit-btn', 'style' => 'background: none;border: none;font-size: 18px;']);
                            },
                            'delete' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                            'title' => Yii::t('app', 'delete'),
                                            'style' => 'display: inline-block;',
                                            'data' => [
                                                'confirm' => 'Are you sure you want to delete this item?',
                                            ],
                                ]);
                            },
                        ],
                        'urlCreator' => function ($action, $model)use ($license_master) {
                            if ($action === 'delete') {
                                $url = Url::to(['delete-partner', 'id' => $model->id, 'licence_id' => $license_master->id]);
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
<script>
    $(document).on('click', '.modalButton', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr("value"));

    });
</script>

