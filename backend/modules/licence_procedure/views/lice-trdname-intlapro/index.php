<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\LiceTrdnameIntlaproSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lice Trdname Intlapros';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Default box -->
<div class="box table-responsive">
    <div class="lice-trdname-intlapro-index">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body table-responsive">
                                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            
            <?=  Html::a('<span> Create Lice Trdname Intlapro</span>', ['create'], ['class' => 'btn btn-block manage-btn']) ?>
                                        <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
        'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                            'id',
            'licensing_master_id',
            'payment_amount',
            'payment_receipt',
            'certificate',
            // 'status',
            // 'CB',
            // 'date',
            // 'next_step',
            // 'sponsor_family_book',
            // 'comment:ntext',

                ['class' => 'yii\grid\ActionColumn'],
                ],
                ]); ?>
                                </div>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->
