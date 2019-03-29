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
        $details = \common\models\RealEstateDetails::find()->where(['master_id' => $model_val->id, 'type' => $model_val->type, 'category' => 2, 'plot_status' => 1])->all();
        $plot_details = \common\models\RealEstateDetails::find()->where(['master_id' => $model_val->id, 'type' => $model_val->type, 'category' => 2, 'plot_status' => 0])->all();
//        if ($k == 3) {
//            var_dump($plot_details);
//            exit;
//        }
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
                    <div class="table-responsive">
                        <table class="table table-responsive table-bordered">
                            <thead>
                                <tr>
                                    <th>Building Name</th>
                                    <?php
                                    if ($max_plot > 0) {
                                        foreach (range(1, $max_plot) as $char) {
                                            ?>
                                            <th><?= Yii::$app->SetValues->NumberAlphabet($char) ?></th>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <?php
                                    if ($max_ist > 0) {
                                        foreach (range(1, $max_ist) as $num) {
                                            ?>
                                            <th>IST-<?= $num ?></th>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <?php if (!empty($model)) { ?>
                                <?php
                                foreach ($model as $model_val) {
                                    ?>
                                    <tr>
                                        <td><?= common\models\CompanyManagement::findOne($model_val->company)->company_name ?></td>
                                        <?php
                                        $details1 = \common\models\RealEstateDetails::find()->where(['master_id' => $model_val->id, 'type' => $model_val->type, 'category' => 2, 'plot_status' => 0])->all();
                                        $details2 = \common\models\RealEstateDetails::find()->where(['master_id' => $model_val->id, 'type' => $model_val->type, 'category' => 2, 'plot_status' => 1])->all();
                                        if (!empty($details1)) {
                                            foreach ($details1 as $detail1) {
                                                ?>
                                                <td class="txt-center <?= $detail1->availability == 1 ? 'green' : '' ?>"><?= $detail1->cost ?></td>
                                                <?php
                                            }
                                        }
                                        if (count($details1) < $max_plot) {
                                            $new_count = $max_plot - count($details1);
                                            for ($i = 1; $i <= $new_count; $i++) {
                                                ?>
                                                <td></td>
                                                <?php
                                            }
                                        }

                                        if (!empty($details2)) {
                                            foreach ($details2 as $detail2) {
                                                ?>
                                                <td class="txt-center <?= $detail2->availability == 1 ? 'green' : '' ?>"><?= $detail2->cost ?></td>
                                                <?php
                                            }
                                        }
                                        if (count($details2) < $max_ist) {
                                            $new_ist_count = $max_ist - count($details2);
                                            for ($i = 1; $i <= $new_ist_count; $i++) {
                                                ?>
                                                <td></td>
                                                <?php
                                            }
                                        }
                                        ?>
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

