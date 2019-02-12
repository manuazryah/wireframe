<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Documents;
use common\models\PartnerDetails;

/* @var $this yii\web\View */
/* @var $model common\models\PartnerDetails */

$this->title = 'Add Partner Details';
$this->params['breadcrumbs'][] = ['label' => 'Partner Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    input[type="file"] {
        margin-bottom: 0px;
    }
</style>
<!-- Default box -->
<div class="">
    <div class="box-body">
        <div class="partner-documents-create">
            <div class="partner-documents-form form-inline">

                <?php $form = ActiveForm::begin(); ?>
                <div class="row">
                    <?php
                    if ($model->isNewRecord) {
                        $model->appointment_id = $license_master->appointment_id;
                    }
                    ?>
                    <?php $documents = ArrayHelper::map(Documents::findAll(['status' => 1]), 'unique_name', 'document_name'); ?>
                    <?php $partners = ArrayHelper::map(PartnerDetails::findAll(['appointment_id' => $license_master->appointment_id]), 'id', 'name'); ?>
                    <?= $form->field($model, 'appointment_id')->hiddenInput()->label(FALSE) ?>
                    <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>
                        <?= $form->field($model, 'document_name')->dropDownList($documents, ['prompt' => '-Choose a Document-', 'autofocus' => 'true']) ?>
                    </div>
                    <div class='col-md-6 col-sm-6 col-xs-12 left_padd'> 
                        <?= $form->field($model, 'partner')->dropDownList($partners, ['prompt' => '-Choose a Partner-', 'autofocus' => 'true']) ?>
                    </div>
                </div>
                <div class="row">
                    <div class='col-md-6 col-sm-6 col-xs-12 left_padd'>    
                        <?= $form->field($model, 'file')->fileInput() ?>
                        <?php
                        if ($model->isNewRecord)
                            echo "";
                        else {
                            if (!empty($model->file)) {
                                $path = Yii::$app->basePath . '/../uploads/partner_documents/' . $license_master->appointment_id . '/' . $model->file;
                                if (file_exists($path)) {
                                    ?>
                                    <a href="<?= Yii::$app->homeUrl ?>uploads/partner_documents/<?= $license_master->appointment_id ?>/<?= $model->file ?>" target="_blank"><?= $model->file ?></a>
                                    <?php
                                }
                                ?>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>


                <div class="form-group action-btn-right">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
                </div>


                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->

