<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\RealEstateDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'License / Virtual Report';
$this->params['breadcrumbs'][] = $this->title;
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
                        <?php echo $this->render('_license_search', ['model' => $searchModel]); ?>
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
                                        $total = \common\models\RealEstateDetails::find()->where(['master_id' => $model_val['id'], 'type' => $model_val['type'], 'category' => 1])->count();
                                        $avail = \common\models\RealEstateDetails::find()->where(['master_id' => $model_val['id'], 'type' => $model_val['type'], 'category' => 1, 'availability' => 1])->count();
                                        $occupied = \common\models\RealEstateDetails::find()->where(['master_id' => $model_val['id'], 'type' => $model_val['type'], 'category' => 1, 'availability' => 0])->count();
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

