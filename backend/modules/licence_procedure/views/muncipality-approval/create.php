<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\MuncipalityApproval */

$this->title = 'Create Muncipality Approval';
$this->params['breadcrumbs'][] = ['label' => 'Muncipality Approvals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="muncipality-approval-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
