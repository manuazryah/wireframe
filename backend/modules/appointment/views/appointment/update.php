<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Appointment */

$this->title = 'Update Appointment: ' . $model->service_id;
$this->params['breadcrumbs'][] = ['label' => 'Appointments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<!-- Default box -->
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <?= Html::a('<span> Manage Appointment</span>', ['index'], ['class' => 'btn btn-block manage-btn', 'style' => 'display:inline-block']) ?>
        <?= Html::a('<span> Remove Appointment</span>', ['remove', 'id' => $model->id], ['class' => 'btn btn-block btn-danger', 'style' => 'display: inline-block;margin-bottom: 34px;margin-left: 15px;', 'id' => 'app-remove']) ?>
        <section id="tabs">
            <div class="card1">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <?php
                        echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Appointment</span>', ['appointment/update', 'id' => $model->id]);
                        ?>
                    </li>
                    <li role="presentation">
                        <?php
                        echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Services</span>', ['appointment-service/add', 'id' => $model->id]);
                        ?>
                    </li>
                </ul>
            </div>
        </section>
        <div class="appointment-update">
            <?=
            $this->render('_form', [
                'model' => $model,
            ])
            ?>
            <div class="clearfix"></div>
            <?= Html::a('<span>Quotation approved and proceed to next</span>', ['/appointment/appointment-service/quotation-approve', 'id' => $model->id], ['class' => 'btn btn-block btn-success btn-sm', 'style' => 'float:right;margin-top:40px;']) ?>
        </div>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->
<script type="text/javascript">
    $('#app-remove').on('click', function () {
        return confirm('Are you sure want to continue?');
    });
</script>