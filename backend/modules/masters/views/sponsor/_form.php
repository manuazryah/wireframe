<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Sponsor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sponsor-form form-inline">
    <?= \common\components\AlertMessageWidget::widget() ?>
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
            <table class="table table-bordered attachment_tbl">
                <thead>
                    <tr>
                        <th style="width: 20%">Title</th>
                        <th>Choose File</th>
                        <th style="width: 10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Emirates ID</td>
                        <td>
                            <label class="upload-cv">
                                <?= $form->field($model, 'emirate_id')->fileInput(['maxlength' => true])->label(FALSE) ?>
                                <span class="uplod-file-span" id="emirate_id"></span>
                            </label> 
                        </td>
                        <td>
                            <?php
                            if ($model->emirate_id != '') {
                                $dirPath = Yii::getAlias(Yii::$app->params['uploadPath']) . '/uploads/sponsers/' . $model->id . '/emirate_id.' . $model->emirate_id;
                                if (file_exists($dirPath)) {
                                    ?>
                                    <a class="" href="<?= Yii::$app->homeUrl ?>uploads/sponsers/<?= $model->id; ?>/emirate_id.<?= $model->emirate_id; ?>?<?= rand() ?>" target="_blank"><i class="fa fa-eye"></i></a>
                                    <?= Html::a('<i class="fa fa-trash-o"></i>', ['/masters/sponsor/remove', 'path' => Yii::$app->basePath . '/../uploads/sponsers/' . $model->id . '/emirate_id.' . $model->emirate_id, 'id' => $model->id, 'type' => 1], ['class' => 'gal-img-remove']) ?>
                                    <?php
                                }
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Passport</td>
                        <td>
                            <label class="upload-cv">
                                <?= $form->field($model, 'passport')->fileInput(['maxlength' => true])->label(FALSE) ?>
                                <span class="uplod-file-span" id="passport"></span>
                            </label> 
                        </td>
                        <td>
                            <?php
                            if ($model->passport != '') {
                                $dirPath = Yii::getAlias(Yii::$app->params['uploadPath']) . '/uploads/sponsers/' . $model->id . '/passport.' . $model->passport;
                                if (file_exists($dirPath)) {
                                    ?>
                                    <a class="" href="<?= Yii::$app->homeUrl ?>uploads/sponsers/<?= $model->id; ?>/passport.<?= $model->passport; ?>?<?= rand() ?>" target="_blank"><i class="fa fa-eye"></i></a>
                                    <?= Html::a('<i class="fa fa-trash-o"></i>', ['/masters/sponsor/remove', 'path' => Yii::$app->basePath . '/../uploads/sponsers/' . $model->id . '/passport.' . $model->passport, 'id' => $model->id, 'type' => 2], ['class' => 'gal-img-remove']) ?>
                                    <?php
                                }
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Family Book</td>
                        <td>
                            <label class="upload-cv">
                                <?= $form->field($model, 'family_book')->fileInput(['maxlength' => true])->label(FALSE) ?>
                                <span class="uplod-file-span" id="familybook"></span>
                            </label>
                        </td>
                        <td>
                            <?php
                            if ($model->family_book != '') {
                                $dirPath = Yii::getAlias(Yii::$app->params['uploadPath']) . '/uploads/sponsers/' . $model->id . '/family_book.' . $model->family_book;
                                if (file_exists($dirPath)) {
                                    ?>
                                    <a class="" href="<?= Yii::$app->homeUrl ?>uploads/sponsers/<?= $model->id; ?>/family_book.<?= $model->family_book; ?>?<?= rand() ?>" target="_blank"><i class="fa fa-eye"></i></a>
                                    <?= Html::a('<i class="fa fa-trash-o"></i>', ['/masters/sponsor/remove', 'path' => Yii::$app->basePath . '/../uploads/sponsers/' . $model->id . '/family_book.' . $model->family_book, 'id' => $model->id, 'type' => 3], ['class' => 'gal-img-remove']) ?>
                                    <?php
                                }
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Photo</td>
                        <td>
                            <label class="upload-cv">
                                <?= $form->field($model, 'photo')->fileInput(['maxlength' => true])->label(FALSE) ?>
                                <span class="uplod-file-span" id="photo"></span>
                            </label>
                        </td>
                        <td>
                            <?php
                            if ($model->photo != '') {
                                $dirPath = Yii::getAlias(Yii::$app->params['uploadPath']) . '/uploads/sponsers/' . $model->id . '/photo.' . $model->photo;
                                if (file_exists($dirPath)) {
                                    ?>
                                    <a class="" href="<?= Yii::$app->homeUrl ?>uploads/sponsers/<?= $model->id; ?>/photo.<?= $model->photo; ?>?<?= rand() ?>" target="_blank"><i class="fa fa-eye"></i></a>
                                    <?= Html::a('<i class="fa fa-trash-o"></i>', ['/masters/sponsor/remove', 'path' => Yii::$app->basePath . '/../uploads/sponsers/' . $model->id . '/photo.' . $model->photo, 'id' => $model->id, 'type' => 4], ['class' => 'gal-img-remove']) ?>
                                    <?php
                                }
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Other Files</td>
                        <td>
                            <label class="upload-cv">
                                <?= $form->field($model, 'others[]')->fileInput(['multiple' => true])->label(FALSE) ?>
                                <span class="uplod-file-span" id="other_filed"></span>
                            </label>
                            <?php
                            $path = Yii::getAlias('@paths') . '/sponsers/' . $model->id . '/others';
                            if (count(glob("{$path}/*")) > 0) {
                                $k = 0;
                                ?>
                                <table class="table table-bordered sub-tbl">
                                    <tbody>
                                        <?php
                                        foreach (glob("{$path}/*") as $file) {
                                            $k++;
                                            $arry = explode('/', $file);
                                            $img_nmee = end($arry);

                                            $img_nmees = explode('.', $img_nmee);
                                            if ($img_nmees['1'] != '') {
                                                ?>
                                                <tr>
                                                    <td><?= end($arry) ?></td>
                                                    <td style="width: 10%;">
                                                        <a class="" href="<?= Yii::$app->homeUrl ?>uploads/sponsers/<?= $model->id; ?>/others/<?= end($arry); ?>?<?= rand() ?>" target="_blank"><i class="fa fa-eye"></i></a>
                                                        <?= Html::a('<i class="fa fa-trash-o"></i>', ['/masters/sponsor/remove', 'path' => Yii::$app->basePath . '/../uploads/sponsers/' . $model->id . '/others/' . end($arry), 'id' => $model->id, 'type' => 5], ['class' => 'gal-img-remove']) ?>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <?php
                            }
                            ?>
                        </td>
                        <td>
                        </td>
                    </tr>
                </tbody>
            </table>
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