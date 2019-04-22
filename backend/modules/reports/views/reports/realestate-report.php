<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\RealEstateDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Realestate Report';
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
    .summary{
        display: none;
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
                        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
                        <table class="table table-responsive table-bordered">
                            <thead>
                                <tr>
                                    <th>Building Name</th>
                                    <th>Office ID</th>
                                    <th>Sponsor</th>
                                    <?php
                                    foreach (range('A', 'Z') as $x) {
                                        ?>
                                        <th><?= $x ?></th>
                                        <?php
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <?php
                            echo ListView::widget([
                                'dataProvider' => $dataProvider,
                                'itemView' => '_estate_report_view',
                            ]);
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

