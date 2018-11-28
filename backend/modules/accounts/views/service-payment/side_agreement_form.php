<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SideAgreement */

$this->title = 'Create Side Agreement';
$this->params['breadcrumbs'][] = ['label' => 'Side Agreements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Default box -->
<div class="">
    <div class="box-body">
        <div class="side-agreement-create">
            <div class="side-agreement-form form-inline">

                <?php $form = ActiveForm::begin(); ?>
                <div class="row">
                    <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'company_name')->textInput(['maxlength' => true]) ?>

                    </div>
                    <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'represented_by')->textInput(['maxlength' => true]) ?>

                    </div>
                    <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'date')->textInput() ?>

                    </div>
                    <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'office_no')->textInput(['maxlength' => true]) ?>

                    </div>
                    <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'offfice_address')->textInput(['maxlength' => true]) ?>

                    </div>
                    <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'activity')->textInput(['maxlength' => true]) ?>

                    </div>
                    <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'payment')->textInput() ?>

                    </div>
                    <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'office_statrt_date')->textInput() ?>

                    </div>
                    <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'office_end_date')->textInput() ?>

                    </div>
                    <div class='col-md-3 col-sm-6 col-xs-12 left_padd'>    <?= $form->field($model, 'sponsor_amount')->textInput() ?>

                    </div>
                    <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>    <?= $form->field($model, 'payment_details')->textarea(['rows' => 6]) ?>

                    </div>

                    <div class='col-md-12 col-sm-12 col-xs-12 left_padd'>
                        <div class="form-group action-btn-right">
                            <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

