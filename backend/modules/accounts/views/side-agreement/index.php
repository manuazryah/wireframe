<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SideAgreementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Side Agreements';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Default box -->
<div class="box table-responsive">
    <div class="side-agreement-index">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body table-responsive">
                                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            
            <?=  Html::a('<span> Create Side Agreement</span>', ['create'], ['class' => 'btn btn-block manage-btn']) ?>
                                        <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
        'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                            'id',
            'appointment_id',
            'date',
            'company_name',
            'represented_by',
            // 'office_no',
            // 'offfice_address',
            // 'activity',
            // 'payment',
            // 'office_statrt_date',
            // 'office_end_date',
            // 'payment_details:ntext',
            // 'sponsor_amount',
            // 'status',
            // 'CB',
            // 'UB',
            // 'DOC',
            // 'DOU',

                ['class' => 'yii\grid\ActionColumn'],
                ],
                ]); ?>
                                </div>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->

