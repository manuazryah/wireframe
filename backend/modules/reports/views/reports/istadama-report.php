<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\RealEstateDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Istadama Report';
$this->params['breadcrumbs'][] = $this->title;
$arr = [];
$plot_count = [];
if (!empty($model)) {
//    $k = 0;
    foreach ($model as $model_val) {
        $k++;
        $details = \common\models\RealEstateDetails::find()->where(['master_id' => $model_val['id'], 'type' => $model_val['type'], 'category' => 2, 'plot_status' => 1])->all();
        $plot_details = \common\models\RealEstateDetails::find()->where(['master_id' => $model_val['id'], 'type' => $model_val['type'], 'category' => 2, 'plot_status' => 0])->all();

        if (!empty($details)) {
            $arr[] = count($details);
        }
        if (!empty($plot_details)) {
            $plot_count[] = count($plot_details);
        }
    }
}
if (!empty($arr)) {
    $max_ist = max($arr);
} else {
    $max_ist = 0;
}
if (!empty($plot_count)) {
    $max_plot = max($plot_count);
} else {
    $max_plot = 0;
}
?>
<style>
    .grid-view .form-control{
        border-radius: 5px;
    }
    .green{
        background: green;
        color: #fff;
    }
    .txt-center{
        text-align: center;
    }
    td{
        white-space: nowrap;
    }
    th{
        white-space: nowrap;
    }
</style>
<!-- Default box -->
<div class="box table-responsive">
    <div class="real-estate-details-index">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="">
                        <?php echo $this->render('_istadama_search', ['model' => $searchModel]); ?>
                        <table class="table table-responsive table-bordered">
                            <thead>
                                <tr>
                                    <th>Building Name</th>
                                    <th>Sponsor</th>
                                    <th>Total</th>
                                    <th>Occupied</th>
                                    <th>Available</th>
                                </tr>
                            </thead>
                            <?php if (!empty($model)) { ?>
                                <?php
                                foreach ($model as $model_val) {
                                    ?>
                                    <tr>
                                        <td><?= common\models\CompanyManagement::findOne($model_val['company'])->company_name ?></td>
                                        <td><?= common\models\Sponsor::findOne($model_val['sponsor'])->name ?></td>
                                        <?php
                                        $total = \common\models\RealEstateDetails::find()->where(['master_id' => $model_val['id'], 'type' => $model_val['type'], 'category' => 2])->count();
                                        $avail = \common\models\RealEstateDetails::find()->where(['master_id' => $model_val['id'], 'type' => $model_val['type'], 'category' => 2, 'availability' => 1])->count();
                                        $occupied = \common\models\RealEstateDetails::find()->where(['master_id' => $model_val['id'], 'type' => $model_val['type'], 'category' => 2, 'availability' => 0])->count();
                                        ?>
                                        <td><?= $total ?></td>
                                        <td><?= $occupied ?></td>
                                        <td><?= $avail ?></td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->

