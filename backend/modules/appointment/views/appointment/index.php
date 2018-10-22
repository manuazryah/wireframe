<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\helpers\ArrayHelper;
use common\models\Debtor;
use common\models\AppointmentServices;
use common\models\Sponsor;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AppointmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Appointments';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Default box -->
<div class="box table-responsive">
    <div class="appointment-index">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body table-responsive">
            <?= \common\components\AlertMessageWidget::widget() ?>

            <?= Html::a('<span> Create Appointment</span>', ['create'], ['class' => 'btn btn-block manage-btn']) ?>
            <?php
            $gridColumns = [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'customer',
                    'value' => 'customer0.company_name',
                    'filter' => ArrayHelper::map(Debtor::find()->asArray()->all(), 'id', 'company_name'),
                ],
                [
                    'attribute' => 'service_type',
                    'value' => 'serviceType.service',
                    'filter' => ArrayHelper::map(AppointmentServices::find()->asArray()->all(), 'id', 'service'),
                ],
                'service_id',
                [
                    'attribute' => 'sponsor',
                    'value' => 'sponsor0.name',
                    'filter' => ArrayHelper::map(Sponsor::find()->asArray()->all(), 'id', 'name'),
                ],
                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{update}',
                ],
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

