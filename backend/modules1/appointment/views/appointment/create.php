<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Appointment */

$this->title = 'Create Appointment';
$this->params['breadcrumbs'][] = ['label' => 'Appointments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Default box -->
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <?= Html::a('<span> Manage Appointment</span>', ['index'], ['class' => 'btn btn-block manage-btn']) ?>
        <section id="tabs">
            <div class="card1">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a>Appointment</a>
                    </li>
                    <li role="presentation">
                        <a>Services</a>
                    </li>
                </ul>
            </div>
        </section>
        <div class="appointment-create">
            <?=
            $this->render('_form', [
                'model' => $model,
            ])
            ?>
        </div>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->

