<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel common\models\DebtorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Debtor Management';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Default box -->
<div class="box table-responsive">
    <div class="debtor-index">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body table-responsive">
            <?= \common\components\AlertMessageWidget::widget() ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= Html::a('<span> Create Debtor</span>', ['create'], ['class' => 'btn btn-block manage-btn']) ?>
            <?php
            $gridColumns = [
                ['class' => 'yii\grid\SerialColumn'],
                'company_name',
                'reference_code',
                'email:email',
                'phone_number',
                // 'address:ntext',
                // 'contact_person',
                // 'contact_person_email:email',
                // 'contact_person_phone',
                // 'nationality',
                // 'comment:ntext',
                // 'TRN',
                // 'status',
                // 'CB',
                // 'UB',
                // 'DOC',
                // 'DOU',
                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{update}{delete}',
                ],
            ];

// Renders a export dropdown menu
            echo ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'columns' => $gridColumns
            ]);

// You can choose to render your own GridView separately
            echo \kartik\grid\GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => $gridColumns
            ]);
            ?>
        </div>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->

