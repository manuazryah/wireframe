<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Sponsor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sponsor-form form-inline">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class='col-md-4 col-xs-12 left_padd'>
            <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Name'])->label(FALSE) ?>

        </div>
        <div class='col-md-4 col-xs-12 left_padd'>
            <?= $form->field($model, 'reference_code')->textInput(['maxlength' => true, 'placeholder' => 'Reference Code'])->label(FALSE) ?>

        </div>
        <div class='col-md-4 col-xs-12 left_padd'>
            <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'Email'])->label(FALSE) ?>

        </div>
    </div>
    <div class="row">
        <div class='col-md-4 col-xs-12 left_padd'>
            <?= $form->field($model, 'address')->textInput(['maxlength' => true, 'placeholder' => 'Address'])->label(FALSE) ?>
        </div>
        <div class='col-md-4 col-xs-12 left_padd'>
            <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true, 'placeholder' => 'Phone Number'])->label(FALSE) ?>

        </div>
        <div class='col-md-4 col-xs-12 left_padd'>
            <?= $form->field($model, 'status')->dropDownList(['1' => 'Enabled', '0' => 'Disabled'], ['prompt' => 'Select Status'])->label(FALSE) ?>

        </div>
    </div>
    <div class="row">
        <div class='col-md-8 col-xs-12 left_padd'>
            <?= $form->field($model, 'comment')->textarea(['rows' => 2, 'placeholder' => 'Comment'])->label(FALSE) ?>

        </div>
    </div>
    <span class="sub-head">Attachments</span>
    <hr>
    <div class="row">
        <div class="col-md-4 col-xs-12 left_padd">
            <label id="upload-cv"> Upload Emirate ID
                <?= $form->field($model, 'emirate_id')->fileInput(['maxlength' => true])->label(FALSE) ?>
                <span class="uplod-file-span" id="emirate_id"></span>
            </label>
        </div>
        <div class="col-md-4 col-xs-12 left_padd">
            <label id="upload-cv"> Upload Passport
                <?= $form->field($model, 'passport')->fileInput(['maxlength' => true])->label(FALSE) ?>
                <span class="uplod-file-span" id="passport"></span>
            </label>
        </div>
        <div class="col-md-4 col-xs-12 left_padd">
            <label id="upload-cv"> Upload Family Book
                <?= $form->field($model, 'family_book')->fileInput(['maxlength' => true])->label(FALSE) ?>
                <span class="uplod-file-span" id="familybook"></span>
            </label>
        </div>
        <div class="col-md-4 col-xs-12 left_padd">
            <label id="upload-cv"> Upload Photo
                <?= $form->field($model, 'photo')->fileInput(['maxlength' => true])->label(FALSE) ?>
                <span class="uplod-file-span" id="photo"></span>
            </label>
        </div>
        <div class="col-md-4 col-xs-12 left_padd">
            <label id="upload-cv"> Upload Other Files
                <?= $form->field($model, 'others')->fileInput(['maxlength' => true])->label(FALSE) ?>
                <span class="uplod-file-span" id="other_filed"></span>
            </label>
        </div>
    </div>


    <div class="form-group action-btn-right">
        <?= Html::a('<span> Cancel</span>', ['index'], ['class' => 'btn btn-block cancel-btn']) ?>
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
<script>
    $("document").ready(function () {

        $("#sponsor-emirate_id").change(function () {
            var file_name = $("#sponsor-emirate_id").val().replace(/.*(\/|\\)/, '');
            $("#emirate_id").text(file_name);
        });
    });
</script>