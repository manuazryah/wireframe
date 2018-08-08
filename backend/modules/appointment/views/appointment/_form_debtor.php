<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Country;

/* @var $this yii\web\View */
/* @var $model common\models\Debtor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="debtor-form form-inline">
    <?= \common\components\AlertMessageWidget::widget() ?>
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class='col-md-4 col-xs-12 left_padd'>    
            <?= $form->field($model, 'company_name')->textInput(['maxlength' => true, 'placeholder' => 'Company Name']) ?>

        </div>
        <div class='col-md-4 col-xs-12 left_padd'>    
            <?= $form->field($model, 'reference_code')->textInput(['maxlength' => true, 'placeholder' => 'Reference Code']) ?>

        </div>
        <div class='col-md-4 col-xs-12 left_padd'>    
            <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'Email']) ?>

        </div>
        <div class='col-md-4 col-xs-12 left_padd'>    
            <?= $form->field($model, 'phone_number')->textInput(['maxlength' => true, 'placeholder' => 'Phone Number']) ?>

        </div>
        <div class='col-md-4 col-xs-12 left_padd'>    
            <?= $form->field($model, 'address')->textInput(['maxlength' => true, 'placeholder' => 'Address']) ?>

        </div>
        <div class='col-md-4 col-xs-12 left_padd'>    
            <?= $form->field($model, 'contact_person')->textInput(['maxlength' => true, 'placeholder' => 'Contact Person']) ?>

        </div>
        <div class='col-md-4 col-xs-12 left_padd'>    
            <?= $form->field($model, 'contact_person_email')->textInput(['maxlength' => true, 'placeholder' => 'Contact Person Email']) ?>

        </div>
        <div class='col-md-4 col-xs-12 left_padd'>    
            <?= $form->field($model, 'contact_person_phone')->textInput(['maxlength' => true, 'placeholder' => 'Contact Person Phone']) ?>

        </div>
        <div class='col-md-4 col-xs-12 left_padd'> 
            <?php $countries = ArrayHelper::map(Country::findAll(['status' => 1]), 'id', 'country_name'); ?>
            <?= $form->field($model, 'nationality')->dropDownList($countries, ['prompt' => 'Choose Nationality']) ?>

        </div>
    </div>
    <div class="row">
        <div class='col-md-8 col-xs-12 left_padd'>    
            <?= $form->field($model, 'comment')->textarea(['rows' => 6, 'placeholder' => 'Comment']) ?>

        </div>
        <div class='col-md-4 col-xs-12 left_padd'> 
            <div class='col-md-12 col-xs-12 pad-0'> 
                <?= $form->field($model, 'TRN')->textInput(['maxlength' => true, 'placeholder' => 'TRN']) ?>
            </div>
            <div class='col-md-12 col-xs-12 pad-0'> 
                <?= $form->field($model, 'status')->dropDownList(['1' => 'Enabled', '0' => 'Disabled']) ?>
            </div>
        </div>
        <div class='col-md-4 col-xs-12 left_padd'>    

        </div> </div>


    <div class="form-group action-btn-right">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success', 'id' => 'add_customer']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
<script>

    $('#add_customer').click(function (event) {
        event.preventDefault();
        if (valid()) {
            var company_name = $('#debtor-company_name').val();
            var reference_code = $('#debtor-reference_code').val();
            var phone_number = $('#debtor-phone_number').val();
            var email = $('#debtor-email').val();
            var address = $('#debtor-address').val();
            var contact_person = $('#debtor-contact_person').val();
            var contact_person_email = $('#debtor-contact_person_email').val();
            var contact_person_phone = $('#debtor-contact_person_phone').val();
            var nationality = $('#debtor-nationality').val();
            var comment = $('#debtor-comment').val();
            var TRN = $('#debtor-trn').val();
            $.ajax({
                url: '<?= Yii::$app->homeUrl ?>appointment/appointment/add-customer',
                type: "post",
                data: {TRN: TRN, comment: comment, nationality: nationality, contact_person_phone: contact_person_phone, contact_person_email: contact_person_email, reference_code: reference_code, company_name: company_name, email: email, address: address, phone_number: phone_number, contact_person: contact_person},
                success: function (data) {
                    var $data = JSON.parse(data);
                    alert($data.id);
                    if ($data.con === "1") {
                        var newOption = $('<option value="' + $data.id + '">' + $data.name + '</option>');
                        $('#appointment-customer').append(newOption);
                        $("#appointment-customer").val($data.id);
                        $('#modal').modal('hide');
                    } else {
                        alert($data.error);
                    }

                }, error: function () {

                }
            });
        } else {
//            alert('Please fill the Field');
        }

    });
    var valid = function () { //Validation Function - Sample, just checks for empty fields
        var valid;
        $("input").each(function () {
            if (!$('#debtor-company_name').val()) {
                $('#debtor-company_name').focus();
                valid = false;
            }
            if (!$('#debtor-email').val()) {
                $('#debtor-email').focus();
                valid = false;
            }
            if (!$('#debtor-phone_number').val()) {
                $('#debtor-phone_number').focus();
                valid = false;
            }
            if (!$('#debtor-contact_person').val()) {
                $('#debtor-contact_person').focus();
                valid = false;
            }
        });
        if (valid !== false) {
            return true;
        } else {
            return false;
        }
    }
</script>
