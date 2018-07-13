<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\CompanyManagement;
use common\models\Sponsor;

/* @var $this yii\web\View */
/* @var $model common\models\RealEstateMaster */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="real-estate-master-form form-inline">
    <?= \common\components\AlertMessageWidget::widget() ?>
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class='col-md-12 col-xs-12 expense-head'>
            <span class="sub-heading">General Details</span>
            <div class="horizontal_line"></div>
        </div>
    </div>
    <div class="row">
        <div class='col-md-4  col-xs-12 left_padd'>
            <?php $companies = ArrayHelper::map(CompanyManagement::findAll(['status' => 1]), 'id', 'company_name'); ?>
            <?= $form->field($model, 'company')->dropDownList($companies, ['prompt' => 'Choose Company']) ?>

        </div>
        <div class='col-md-4  col-xs-12 left_padd'>   
            <?= $form->field($model, 'reference_code')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-4  col-xs-12 left_padd'>    
            <?= $form->field($model, 'total_square_feet')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-4  col-xs-12 left_padd'> 
            <?php $sponsors = ArrayHelper::map(Sponsor::findAll(['status' => 1]), 'id', 'name'); ?>
            <?= $form->field($model, 'sponsor')->dropDownList($sponsors, ['prompt' => 'Choose Sponsor']) ?>

        </div>
        <div class='col-md-4  col-xs-12 left_padd'>    
            <?= $form->field($model, 'comany_name_for_ejari')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-4  col-xs-12 left_padd'>    
            <?= $form->field($model, 'number_of_license')->textInput() ?>

        </div>
    </div>
    <div class="row">
        <div class='col-md-8  col-xs-12 left_padd'>    
            <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>
        </div>
        <div class='col-md-4  col-xs-12 left_padd'>
            <div class='col-md-12 col-xs-12 pad-0'>
                <?= $form->field($model, 'number_of_plots')->textInput() ?>
            </div>
            <div class='col-md-12 col-xs-12 pad-0'>
                <?= $form->field($model, 'status')->dropDownList(['1' => 'Enabled', '0' => 'Disabled']) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class='col-md-12 col-xs-12 expense-head'>
            <span class="sub-heading">Expense Details ( <span id="expense-total">00.00</span> )</span>
            <div class="horizontal_line"></div>
        </div>
    </div>
    <div class="row">
        <div class='col-md-4  col-xs-12 left_padd'>    <?= $form->field($model, 'rent_total')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-4  col-xs-12 left_padd'>
            <?php
            $numbers = Yii::$app->SetValues->Number();
            ?>
            <?= $form->field($model, 'no_of_cheques')->dropDownList($numbers, ['prompt' => '- select -']) ?>

        </div>
        <div class='col-md-4  col-xs-12 left_padd'>    
            <?= $form->field($model, 'commission')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-4  col-xs-12 left_padd'>    
            <?= $form->field($model, 'deposit')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-4  col-xs-12 left_padd'>   
            <?= $form->field($model, 'sponser_fee')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-4  col-xs-12 left_padd'>   
            <?= $form->field($model, 'furniture_expense')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-4  col-xs-12 left_padd'>    
            <?= $form->field($model, 'office_renovation_expense')->textInput(['maxlength' => true]) ?>

        </div>
        <div class='col-md-4  col-xs-12 left_padd'>    
            <?= $form->field($model, 'other_expense')->textInput(['maxlength' => true]) ?>

        </div>
    </div>
    <div class="row">
        <div class='col-md-12 col-xs-12 expense-head'>
            <div id="cheque-details-content">

            </div>
        </div>
    </div>
    <div class="row">
        <div class='col-md-12 col-xs-12 expense-head'>
            <span class="sub-heading">Attachments</span>
            <div class="horizontal_line"></div>
        </div>
    </div>
    <div class="row">
        <div class='col-md-4  col-xs-12 left_padd'>    <?= $form->field($model, 'attachments[]')->fileInput(['multiple' => true]) ?>

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

        $("#realestatemaster-total_square_feet").blur(function () {
            var total = $(this).val();
            var res = total / 100;
            $("#realestatemaster-number_of_license").val(res);
            $("#realestatemaster-number_of_plots").val(res);
        });
        $(document).on('keyup mouseup', '#realestatemaster-rent_total', function (e) {
            calculateTotal();
        });
        $(document).on('keyup mouseup', '#realestatemaster-commission', function (e) {
            calculateTotal();
        });
        $(document).on('keyup mouseup', '#realestatemaster-deposit', function (e) {
            calculateTotal();
        });
        $(document).on('keyup mouseup', '#realestatemaster-sponser_fee', function (e) {
            calculateTotal();
        });
        $(document).on('keyup mouseup', '#realestatemaster-furniture_expense', function (e) {
            calculateTotal();
        });
        $(document).on('keyup mouseup', '#realestatemaster-office_renovation_expense', function (e) {
            calculateTotal();
        });
        $(document).on('keyup mouseup', '#realestatemaster-other_expense', function (e) {
            calculateTotal();
        });

        $(document).on('change', '#realestatemaster-no_of_cheques', function (e) {
            var no_of_cheque = $(this).val();
            $.ajax({
                type: 'POST',
                cache: false,
                async: false,
                data: {no_of_cheque: no_of_cheque},
                url: '<?= Yii::$app->homeUrl; ?>masters/real-estate-master/add-cheque-details',
                success: function (data) {
                    $("#cheque-details-content").html(data);
                }
            });
        });
    });
    function calculateTotal() {
        var rent_total = $("#realestatemaster-rent_total").val();
        var commission = $("#realestatemaster-commission").val();
        var deposit = $("#realestatemaster-deposit").val();
        var sponsor_fee = $("#realestatemaster-sponser_fee").val();
        var furniture_expense = $("#realestatemaster-furniture_expense").val();
        var renovation_expense = $("#realestatemaster-office_renovation_expense").val();
        var other_expense = $("#realestatemaster-other_expense").val();
        if (rent_total == '') {
            rent_total = 0;
        }
        if (commission == '') {
            commission = 0;
        }
        if (deposit == '') {
            deposit = 0;
        }
        if (sponsor_fee == '') {
            sponsor_fee = 0;
        }
        if (furniture_expense == '') {
            furniture_expense = 0;
        }
        if (renovation_expense == '') {
            renovation_expense = 0;
        }
        if (other_expense == '') {
            other_expense = 0;
        }
        var total = parseFloat(rent_total) + parseFloat(commission) + parseFloat(deposit) + parseFloat(sponsor_fee) + parseFloat(furniture_expense) + parseFloat(renovation_expense) + parseFloat(other_expense);
        $('#expense-total').text(total.toFixed(2));
    }
</script>
