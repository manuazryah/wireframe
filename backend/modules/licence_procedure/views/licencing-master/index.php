<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

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
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'appointment_no',
                    [
                        'attribute' => 'customer_id',
                        'value' => function($data) {
                            return common\models\Debtor::findOne($data->customer_id)->company_name;
                        },
                        'filter' => ArrayHelper::map(common\models\Debtor::find()->asArray()->all(), 'id', 'company_name'),
                    ],
                    [
                        'attribute' => 'sponsor',
                        'value' => function($data) {
                            return common\models\Sponsor::findOne($data->sponsor)->name;
                        },
                        'filter' => ArrayHelper::map(common\models\Sponsor::find()->asArray()->all(), 'id', 'name'),
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

