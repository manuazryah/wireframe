<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\CompanyManagement;
use common\models\Sponsor;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\RealEstateMaster */
/* @var $form yii\widgets\ActiveForm */
$plots = common\models\RealEstateDetails::find()->where(['master_id' => $model->id, 'category' => 2])->all();
$plots_arr = [];
if (!empty($plots)) {
    foreach ($plots as $plot) {
        $plots_arr[] = $plot->id;
    }
}
$licenses = common\models\RealEstateDetails::find()->where(['master_id' => $model->id, 'category' => 1])->all();
$license_arr = [];
if (!empty($licenses)) {
    foreach ($licenses as $license) {
        $license_arr[] = $license->id;
    }
}
$plot_count = common\models\Appointment::find()->where(['plot' => $plots_arr])->count();
$license_count = common\models\Appointment::find()->where(['space_for_license' => $license_arr])->count();
?>
<div class="real-estate-master-form form-inline">
    <?= \common\components\AlertMessageWidget::widget() ?>
    <?php $form = ActiveForm::begin(); ?>
    <!--    <div class="row">
            <div class='col-md-12 col-xs-12 expense-head'>
                <span class="sub-heading">General Details</span>
                <div class="horizontal_line"></div>
            </div>
        </div>-->
    <section id="tabs">
        <div class="card1">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <?php
                    echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">General Details</span>', ['update', 'id' => $model->id]);
                    ?>
                </li>
                <li role="presentation">
                    <?php
                    echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Real Estate Details</span>', ['real-estate-details', 'id' => $model->id]);
                    ?>
                </li>
            </ul>
        </div>
    </section>
    <div class="row">
        <div class='col-md-4  col-xs-12 left_padd'>
            <?= $form->field($model, 'type')->dropDownList(['1' => 'Istadama'], ['prompt' => 'Choose Type', 'readonly' => true, 'autofocus' => 'true']) ?>

        </div>
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
            <?= $form->field($model, 'number_of_license')->textInput(['type' => 'number', 'min' => 1, 'readonly' => $license_count > 0 ? TRUE : FALSE]) ?>

        </div>
        <div class='col-md-4  col-xs-12 left_padd'>    
            <?= $form->field($model, 'number_of_plots')->textInput(['type' => 'number', 'min' => 1, 'readonly' => $plot_count > 0 ? TRUE : FALSE]) ?>

        </div>
        <div class='col-md-4  col-xs-12 left_padd'>    
            <?= $form->field($model, 'number_of_istadama')->textInput(['type' => 'number', 'min' => 1, 'readonly' => $model->type == 0 || $plot_count > 0 ? TRUE : FALSE]) ?>

        </div>
        <div class='col-md-4  col-xs-12 left_padd'>    
            <?= $form->field($model, 'status')->dropDownList(['1' => 'Enabled', '0' => 'Disabled']) ?>

        </div>
    </div>
    <div class="row">
        <div class='col-md-12  col-xs-12 left_padd'>    
            <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>
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
            <div class="row">
                <div class='col-md-12 col-xs-12 expense-head'>
                    <span class="sub-heading">Cheque Details</span>
                    <div class="horizontal_line"></div>
                </div>
            </div>
            <?php
            if (!empty($cheque_details)) {
                foreach ($cheque_details as $cheque_detail) {
                    if (!empty($cheque_detail)) {
                        ?>
                        <div class="row">
                            <div class = 'col-md-4 col-sm-12 col-xs-12 left_padd'>
                                <div class = "form-group">
                                    <label class="control-label" for="">Cheque Number</label>
                                    <input class="form-control" type = "text" name = "updatee[<?= $cheque_detail->id ?>][cheque_num][]" value="<?= $cheque_detail->cheque_no ?>" required>

                                </div>
                            </div>
                            <div class='col-md-4 col-sm-12 col-xs-12 left_padd'>
                                <div class="form-group">
                                    <label class="control-label" for="">Expiry Date</label>
                                    <input type="date" class="form-control" name="updatee[<?= $cheque_detail->id ?>][expiry_date][]" required value="<?= $cheque_detail->due_date ?>">
                                </div>
                            </div>
                            <div class='col-md-3 col-sm-12 col-xs-12 left_padd'>
                                <div class="form-group">
                                    <label class="control-label" for="">Amount</label>
                                    <input class="form-control" type = "number" name = "updatee[<?= $cheque_detail->id ?>][amount][]" value="<?= $cheque_detail->amount ?>" required>
                                </div>
                            </div>
                            <div class='col-md-1 col-sm-12 col-xs-12 left_padd'>
                                <div class="form-group">
                                    <a><i class="fa fa-times cheque-details-delete" id="<?= $cheque_detail->id ?>"></i></a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
            }
            ?>
            <input type="hidden" id="cheque-count" value="<?= count($cheque_details) ?>" />
            <div id="cheque-details-content">

            </div>
            <a href="" id="add_another_line"><i class="fa fa-plus" aria-hidden="true"></i> Add New Cheque</a>
        </div>
    </div>
    <div class="row">
        <div class='col-md-12 col-xs-12 expense-head'>
            <span class="sub-heading">Attachments</span>
            <div class="horizontal_line"></div>
        </div>
    </div>
    <div class="row">
        <div class='col-md-3 col-xs-12 left_padd'>    
            <?= $form->field($model, 'aggrement')->fileInput(['multiple' => true]) ?>
            <?php
            if (!empty($model->aggrement)) {
                ?>
                <a href="<?= Yii::$app->homeUrl ?>uploads/real_estate/<?= $model->id; ?>/aggrement.<?= $model->aggrement; ?>" target="_blank">Aggrement</a>
                <?php
            }
            ?>
        </div>
        <div class='col-md-3 col-xs-12 left_padd'>    
            <?= $form->field($model, 'ejari')->fileInput(['multiple' => true]) ?>
            <?php
            if (!empty($model->ejari)) {
                ?>
                <a href="<?= Yii::$app->homeUrl ?>uploads/real_estate/<?= $model->id; ?>/ejari.<?= $model->ejari; ?>" target="_blank">Ejari</a>
                <?php
            }
            ?>
        </div>
        <div class='col-md-3  col-xs-12 left_padd'>   
            <?php
            if (!$model->isNewRecord) {
                $model->ejari_expiry = date('d-m-Y', strtotime($model->ejari_expiry));
            } else {
                $model->ejari_expiry = date('d-m-y');
            }
            ?>
            <?=
            $form->field($model, 'ejari_expiry')->widget(DatePicker::classname(), [
                'type' => DatePicker::TYPE_INPUT,
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd-m-yyyy'
                ]
            ]);
            ?>

        </div>
        <div class='col-md-3 col-xs-12 left_padd'>    
            <?= $form->field($model, 'cheque_copy')->fileInput(['multiple' => true]) ?>
            <?php
            if (!empty($model->cheque_copy)) {
                ?>
                <a href="<?= Yii::$app->homeUrl ?>uploads/real_estate/<?= $model->id; ?>/cheque_copy.<?= $model->cheque_copy; ?>" target="_blank">Cheque Copy</a>
                <?php
            }
            ?>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="form-group action-btn-right">
        <?= Html::a('<span> Cancel</span>', ['index'], ['class' => 'btn btn-block cancel-btn']) ?>
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
<script>
    $("document").ready(function () {
        $('#realestatemaster-type').attr("disabled", true);
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

        $(document).on('click', '#add_another_line', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                cache: false,
                async: false,
                data: {},
                url: '<?= Yii::$app->homeUrl; ?>masters/real-estate-master/update-cheque-details',
                success: function (data) {
                    $('#cheque-details-content').append(data);
                }
            });
        });

        $(document).on('click', '.cheque-details-delete', function (e) {
            e.preventDefault();
            var row_id = $(this).attr('id');
            if (row_id) {
                if (confirm('Are you sure you want to delete?')) {
                    $.ajax({
                        type: 'POST',
                        cache: false,
                        async: false,
                        data: {id: row_id},
                        url: '<?= Yii::$app->homeUrl; ?>masters/real-estate-master/remove-cheque-row',
                        success: function (data) {
                        }
                    });
                    $(this).closest("div.row").remove();
                }
            } else {
                $(this).closest("div.row").remove();
            }
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
    });

</script>
