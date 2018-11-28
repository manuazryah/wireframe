<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\Debtor;
use common\models\AppointmentServices;
use common\models\Sponsor;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AppointmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payment History';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Default box -->

<div class="box table-responsive">


    <div class="appointment-index">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
            <a href="<?= Yii::$app->homeUrl ?>accounts/service-payment/payment?id=<?= $id ?>" class="button" style="    width: 16%;
               float: right;">View Account</a>
        </div>

        <div class="box-body table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th>SNo.</th>
                    <th>Date</th>
                    <th>Transaction Type</th>
                    <th>Cheque Number</th>
                    <th>Amount</th>
                    <th></th>
                </tr>
                <?php
                if (!empty($payment_model)) {
                    $i = 0;
                    foreach ($payment_model as $model) {
                        $i++;
                        ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $model->DOC ?></td>
                            <td><?= $model->payment_type == 2 ? 'Cheque Payment' : 'Cash Payment' ?></td>
                            <td><?= $model->payment_type == 2 ? $model->cheque_no : '' ?></td>
                            <td><?= $model->amount; ?></td>
                            <td style="width: 50px;text-align: center;"><?= Html::a('<i class="fa fa-print"></i>', ['report', 'id' => $model->id], ['style' => 'font-size:18px;', 'target' => '_blank']) ?></td>
                        </tr>

                        <?php
                    }
                }
                ?>



            </table>

        </div>
    </div>
    <!-- /.box-body -->
</div>

<script>

    $("document").ready(function () {



    });
</script>

