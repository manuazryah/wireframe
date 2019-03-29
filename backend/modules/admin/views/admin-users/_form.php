<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\AdminPosts;

/* @var $this yii\web\View */
/* @var $model common\models\AdminUsers */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-users-form form-inline">
    <?= \common\components\AlertMessageWidget::widget() ?>
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class='col-md-4 col-sm-6 col-xs-12'>
            <?php $posts = ArrayHelper::map(AdminPosts::findAll(['status' => 1]), 'id', 'post_name'); ?>
            <?= $form->field($model, 'post_id')->dropDownList($posts, ['prompt' => '-Choose a Post-', 'autofocus' => 'true']) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12'>
            <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Name']) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12'>
            <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'email']) ?>

        </div>
        <div class='col-md-4 col-sm-6 col-xs-12'>
            <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true, 'placeholder' => 'Phone number']) ?>

        </div>
        <?php // if ($model->isNewRecord) { ?>
        <div class='col-md-4 col-sm-6 col-xs-12'>

            <?= $form->field($model, 'user_name')->textInput(['maxlength' => true, 'placeholder' => 'User Name']) ?>

        </div>
        <?php // } ?>
        <?php if ($model->isNewRecord) { ?>
            <div class='col-md-4 col-sm-6 col-xs-12'>

                <?= $form->field($model, 'password')->passwordInput(['maxlength' => true, 'placeholder' => 'password']) ?>

                <a onclick="show()" class="show-pass"><img src="<?= yii::$app->homeUrl; ?>img/Oyk1g.png" id="EYE"></a>
            </div>
        <?php } ?>

    </div>
    <div class="form-group action-btn-right">
        <?= Html::a('<span> Cancel</span>', ['index'], ['class' => 'btn btn-block cancel-btn']) ?>
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success create-btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    function show() {
        var a = document.getElementById("adminusers-password");
        var b = document.getElementById("EYE");
        if (a.type == "password") {
            a.type = "text";
            b.src = "<?= Yii::$app->homeUrl; ?>img/waw4z.png";
        } else {
            a.type = "password";
            b.src = "<?= Yii::$app->homeUrl; ?>img/Oyk1g.png";
        }
    }
</script>
