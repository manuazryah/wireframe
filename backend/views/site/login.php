<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <div class="row">
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
        <div class="col-md-12">
            <?= $form->field($model, 'user_name')->textInput(['autofocus' => true]) ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'password')->passwordInput() ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'rememberMe')->checkbox() ?>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
