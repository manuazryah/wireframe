<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\CompanyManagement;
use common\models\Sponsor;

/* @var $this yii\web\View */
/* @var $searchModel common\models\RealEstateMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Real Estate Management';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Default box -->
<div class="box table-responsive">
    <div class="real-estate-master-index">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body table-responsive">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= Html::a('<span> Create Real Estate</span>', ['create'], ['class' => 'btn btn-block manage-btn']) ?>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
//                            'id',
                    [
                        'attribute' => 'company',
                        'label' => 'Company Name',
                        'value' => 'company0.company_name',
                        'filter' => ArrayHelper::map(CompanyManagement::find()->asArray()->all(), 'id', 'company_name'),
                    ],
                    'reference_code',
                    'total_square_feet',
                    [
                        'attribute' => 'sponsor',
                        'label' => 'Sponsor Name',
                        'value' => 'sponsor0.name',
                        'filter' => ArrayHelper::map(Sponsor::find()->asArray()->all(), 'id', 'name'),
                    ],
//                    'comany_name_for_ejari',
                    // 'number_of_license',
                    // 'number_of_plots',
                    // 'comment:ntext',
                    // 'rent_total',
                    // 'no_of_cheques',
                    // 'commission',
                    // 'deposit',
                    // 'sponser_fee',
                    // 'furniture_expense',
                    // 'office_renovation_expense',
                    // 'other_expense',
                    // 'attachments',
                    // 'status',
                    // 'CB',
                    // 'UB',
                    // 'DOC',
                    // 'DOU',
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

