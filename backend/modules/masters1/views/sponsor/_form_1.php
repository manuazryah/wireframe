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
            <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Name']) ?>

        </div>
        <div class='col-md-4 col-xs-12 left_padd'>
            <?= $form->field($model, 'reference_code')->textInput(['maxlength' => true, 'placeholder' => 'Reference Code']) ?>

        </div>
        <div class='col-md-4 col-xs-12 left_padd'>
            <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'Email']) ?>

        </div>
    </div>
    <div class="row">
        <div class='col-md-4 col-xs-12 left_padd'>
            <?= $form->field($model, 'address')->textInput(['maxlength' => true, 'placeholder' => 'Address']) ?>
        </div>
        <div class='col-md-4 col-xs-12 left_padd'>
            <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true, 'placeholder' => 'Phone Number']) ?>

        </div>
        <div class='col-md-4 col-xs-12 left_padd'>
            <?= $form->field($model, 'status')->dropDownList(['1' => 'Enabled', '0' => 'Disabled'], ['prompt' => 'Select Status']) ?>

        </div>
    </div>
    <div class="row">
        <div class='col-md-8 col-xs-12 left_padd'>
            <?= $form->field($model, 'comment')->textarea(['rows' => 2, 'placeholder' => 'Comment']) ?>

        </div>
    </div>
    <span class="sub-head">Attachments</span>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Choose File</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Emirate ID</td>
                        <td>
                            <label id="upload-cv">
                                <?= $form->field($model, 'emirate_id')->fileInput(['maxlength' => true])->label(FALSE) ?>
                                <span class="uplod-file-span" id="emirate_id"></span>
                            </label> 
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Emirate ID</td>
                        <td>
                            <label id="upload-cv">
                                <?= $form->field($model, 'emirate_id')->fileInput(['maxlength' => true])->label(FALSE) ?>
                                <span class="uplod-file-span" id="emirate_id"></span>
                            </label> 
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Emirate ID</td>
                        <td>
                            <label id="upload-cv">
                                <?= $form->field($model, 'emirate_id')->fileInput(['maxlength' => true])->label(FALSE) ?>
                                <span class="uplod-file-span" id="emirate_id"></span>
                            </label> 
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Emirate ID</td>
                        <td>
                            <label id="upload-cv">
                                <?= $form->field($model, 'emirate_id')->fileInput(['maxlength' => true])->label(FALSE) ?>
                                <span class="uplod-file-span" id="emirate_id"></span>
                            </label> 
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Emirate ID</td>
                        <td>
                            <label id="upload-cv">
                                <?= $form->field($model, 'emirate_id')->fileInput(['maxlength' => true])->label(FALSE) ?>
                                <span class="uplod-file-span" id="emirate_id"></span>
                            </label> 
                        </td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-xs-12 left_padd">
            <label id="upload-cv"> Upload Emirate ID
                <?= $form->field($model, 'emirate_id')->fileInput(['maxlength' => true])->label(FALSE) ?>
                <span class="uplod-file-span" id="emirate_id"></span>
            </label>
            <?php
            if ($model->emirate_id != '') {
                $dirPath = Yii::getAlias(Yii::$app->params['uploadPath']) . '/uploads/sponsers/' . $model->id . '/emirate_id.' . $model->emirate_id;
                if (file_exists($dirPath)) {
                    ?>
                    <a class="attachment_link" href="<?= Yii::$app->homeUrl ?>uploads/sponsers/<?= $model->id; ?>/emirate_id.<?= $model->emirate_id; ?>" target="_blank">Emirate Document</a>
                    <?php
                }
            }
            ?>
        </div>
        <div class="col-md-4 col-xs-12 left_padd">
            <label id="upload-cv"> Upload Passport
                <?= $form->field($model, 'passport')->fileInput(['maxlength' => true])->label(FALSE) ?>
                <span class="uplod-file-span" id="passport"></span>
            </label>
            <?php
            if ($model->passport != '') {
                $dirPath = Yii::getAlias(Yii::$app->params['uploadPath']) . '/uploads/sponsers/' . $model->id . '/passport.' . $model->passport;
                if (file_exists($dirPath)) {
                    ?>
                    <a class="attachment_link" href="<?= Yii::$app->homeUrl ?>uploads/sponsers/<?= $model->id; ?>/passport.<?= $model->passport; ?>" target="_blank">Passport Document</a>
                    <?php
                }
            }
            ?>
        </div>
        <div class="col-md-4 col-xs-12 left_padd">
            <label id="upload-cv"> Upload Family Book
                <?= $form->field($model, 'family_book')->fileInput(['maxlength' => true])->label(FALSE) ?>
                <span class="uplod-file-span" id="familybook"></span>
            </label>
            <?php
            if ($model->family_book != '') {
                $dirPath = Yii::getAlias(Yii::$app->params['uploadPath']) . '/uploads/sponsers/' . $model->id . '/family_book.' . $model->family_book;
                if (file_exists($dirPath)) {
                    ?>
                    <a class="attachment_link" href="<?= Yii::$app->homeUrl ?>uploads/sponsers/<?= $model->id; ?>/family_book.<?= $model->family_book; ?>" target="_blank">Family Book Document</a>
                    <?php
                }
            }
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-xs-12 left_padd">
            <label id="upload-cv"> Upload Photo
                <?= $form->field($model, 'photo')->fileInput(['maxlength' => true])->label(FALSE) ?>
                <span class="uplod-file-span" id="photo"></span>
            </label>
            <?php
            if ($model->photo != '') {
                $dirPath = Yii::getAlias(Yii::$app->params['uploadPath']) . '/uploads/sponsers/' . $model->id . '/photo.' . $model->photo;
                if (file_exists($dirPath)) {
                    ?>
                    <a class="attachment_link" href="<?= Yii::$app->homeUrl ?>uploads/sponsers/<?= $model->id; ?>/photo.<?= $model->photo; ?>" target="_blank">Photo</a>
                    <?php
                }
            }
            ?>
        </div>
        <div class="col-md-4 col-xs-12 left_padd">
            <label id="upload-cv"> Upload Other Files
                <?= $form->field($model, 'others[]')->fileInput(['multiple' => true])->label(FALSE) ?>
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
        $("#sponsor-passport").change(function () {
            var file_name = $("#sponsor-passport").val().replace(/.*(\/|\\)/, '');
            $("#passport").text(file_name);
        });
        $("#sponsor-family_book").change(function () {
            var file_name = $("#sponsor-family_book").val().replace(/.*(\/|\\)/, '');
            $("#familybook").text(file_name);
        });
        $("#sponsor-photo").change(function () {
            var file_name = $("#sponsor-photo").val().replace(/.*(\/|\\)/, '');
            $("#photo").text(file_name);
        });
        $("#sponsor-others").change(function () {
            var fp = $("#sponsor-others");
            var lg = fp[0].files.length; // get length
            alert(lg);
            $("#other_filed").text(lg + ' files');
        });
    });
</script>