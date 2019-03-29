<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AdminUsers */

$this->title = 'Change Password';
$this->params['breadcrumbs'][] = ['label' => 'Admin Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>

            </div>
            <div class="panel-body">
                <?= Html::a('<i class="fa fa-list"></i><span> Manage Admin User</span>', ['index'], ['class' => 'btn btn-block btn-info btn-sm']) ?>
                <div class="admin-users-create">
                    <div class="admin-users-form form-inline">
                        <?= \common\widgets\Alert::widget(); ?>
                        <?php
                        $form = ActiveForm::begin();
                        ?>
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <?= $form->field($model, 'password')->passwordInput()->label('Old Password *') ?>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <?= $form->field($model, 'new_password')->passwordInput()->label('New Password *') ?>
                            </div>
                            <div class="ol-md-4 col-sm-4 col-xs-12">
                                <?= $form->field($model, 'confirm_password')->passwordInput()->label('Confirm Password *') ?>
                            </div>
                        </div>
                        <div class="form-group ">
                            <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
                            <?= Html::a('Reset', ['change-password'], ['class' => 'btn btn-success']) ?>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

