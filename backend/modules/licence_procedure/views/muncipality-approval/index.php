<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\MuncipalityApprovalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Muncipality Approvals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="muncipality-approval-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Muncipality Approval', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'licencing_master_id',
            'online_reference_number',
            'online_application_fees',
            'payment_receipt',
            //'status',
            //'CB',
            //'date',
            //'next_step',
            //'comment:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
