<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Services;
use common\models\Tax;

/* @var $this yii\web\View */
/* @var $model common\models\AppointmentService */

$this->title = 'Add Services';
$this->params['breadcrumbs'][] = ['label' => 'Appointment Services', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Default box -->
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <div class="app-nav">
            <section id="tabs">
                <div class="card1">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation">
                            <?php
                            echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Appointment</span>', ['appointment/update', 'id' => $appointment->id]);
                            ?>
                        </li>
                        <li role="presentation" class="active">
                            <?php
                            echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Services</span>', ['appointment-service/add', 'id' => $appointment->id]);
                            ?>
                        </li>
                    </ul>
                </div>
            </section>
        </div>
        <div class="appointment-history">
            <table class="table table-responsive">
                <tr>
                    <th>Customer Name</th>
                    <td>: <?= $appointment->customer != '' ? \common\models\Debtor::findOne($appointment->customer)->company_name : '' ?></td>
                    <th>Service Type</th>
                    <td>: <?= $appointment->service_type != '' ? \common\models\AppointmentServices::findOne($appointment->service_type)->service : '' ?></td>
                </tr>
                <tr>
                    <th>Service ID</th>
                    <td>: <?= $appointment->service_id ?></td>
                    <th>Sponsor</th>
                    <td>: <?= $appointment->sponsor != '' ? \common\models\Sponsor::findOne($appointment->sponsor)->name : '' ?></td>
                </tr>
                <tr>
                    <th>Reference Code</th>
                    <td>: <?= $appointment->customer != '' ? \common\models\Debtor::findOne($appointment->customer)->reference_code : '' ?></td>
                    <th></th>
                    <td></td>
                </tr>
            </table>
        </div>
        <?= Html::a('<span> Generate Quotation</span>', ['quotation', 'id' => $appointment->id], ['class' => 'btn btn-block manage-btn', 'style' => 'float:right;', 'target' => '_blank']) ?>
        <?= \common\components\AlertMessageWidget::widget() ?>
        <div class="appointment-service-create">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>Particular</th>
                        <th>Comment</th>
                        <th>Amount</th>
                        <th>Tax</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($services)) {
                        $amount_tot = 0;
                        $tax_tot = 0;
                        $grand_tot = 0;
                        foreach ($services as $service) {
                            ?>
                            <tr>
                                <td><?= Services::findOne($service->service)->service_name ?></td>
                                <td class="edit_text" id="<?= $service->id ?>-comment" val="<?= $service->comment ?>">
                                    <?php
                                    if ($service->comment == '') {
                                        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                    } else {
                                        echo $service->comment;
                                    }
                                    ?>
                                </td>
                                <td style="text-align: right;" class="edit_text" id="<?= $service->id ?>-amount" val="<?= $service->amount ?>">
                                    <?php
                                    if ($service->amount == '') {
                                        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                    } else {
                                        echo $service->amount;
                                    }
                                    ?>
                                </td>
                                <td style="text-align: right;" class="edit_dropdown" drop_id="appointmentservice-tax" id="<?= $service->id ?>-tax" val="<?= $service->tax ?>">
                                    <?php
                                    if ($service->tax == '') {
                                        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                    } else {
                                        ?>
                                        <?= $service->tax_percentage != '' && $service->tax_percentage > 0 ? $service->tax_percentage : '' ?> <?= $service->tax_percentage != '' ? '%' : '' ?>
                                    <?php }
                                    ?>

                                </td>
                                <td style="text-align: right;" class="total-<?= $service->id ?>"><?= $service->total ?></td>
                                <td>
                                    <?= Html::a('<i class="fa fa-pencil"></i>', ['/appointment/appointment-service/add', 'id' => $id, 'prfrma_id' => $service->id], ['class' => '', 'tittle' => 'Edit']) ?>
                                    <?= Html::a('<i class="fa fa-remove"></i>', ['/appointment/appointment-service/delete-performa', 'id' => $service->id], ['class' => '', 'tittle' => 'Edit', 'data-confirm' => 'Are you sure you want to delete this item?']) ?>
                                </td>
                            </tr>
                            <?php
                            $amount_tot += $service->amount;
                            $tax_tot += $service->tax_amount;
                            $grand_tot += $service->total;
                        }
                        ?>
                        <tr>
                            <td colspan="2" style="text-align: right;">Total</td>
                            <td style="text-align: right;"><?= sprintf('%0.2f', $amount_tot); ?></td>
                            <td style="text-align: right;"><?= sprintf('%0.2f', $tax_tot); ?></td>
                            <td style="text-align: right;"><?= sprintf('%0.2f', $grand_tot); ?></td>
                            <td></td>
                        </tr>

                    <?php }
                    ?>
                    <?php $form = ActiveForm::begin(); ?>
                    <tr>
                        <td>
                            <?php $services = ArrayHelper::map(Services::findAll(['status' => 1]), 'id', 'service_name'); ?>
                            <?= $form->field($model, 'service')->dropDownList($services, ['prompt' => 'Choose Service', 'required' => TRUE])->label(FALSE) ?>
                        </td>
                        <td><?= $form->field($model, 'comment')->textInput()->label(FALSE) ?></td>
                        <td><?= $form->field($model, 'amount')->textInput(['maxlength' => true, 'required' => TRUE])->label(FALSE) ?></td>
                        <td>
                            <?php $taxes = ArrayHelper::map(Tax::findAll(['status' => 1]), 'id', 'name'); ?>
                            <?= $form->field($model, 'tax')->dropDownList($taxes, ['prompt' => 'Choose Tax'])->label(FALSE) ?>
                            <input type="hidden" value="<?= $model->tax != '' ? Tax::findOne($model->tax)->value : '' ?>" id="tax-val" />
                        </td>
                        <td><?= $form->field($model, 'total')->textInput(['maxlength' => true, 'readonly' => TRUE])->label(FALSE) ?></td>
                        <td><?= Html::submitButton($model->isNewRecord ? 'Add' : 'Update', ['class' => 'btn btn-success']) ?></td>
                    </tr>
                    <?php ActiveForm::end(); ?>
                </tbody>
            </table>
        </div>
        <?= Html::a('<span>Quotation approved and proceed to next</span>', ['quotation-approve', 'id' => $appointment->id], ['class' => 'btn btn-block btn-success btn-sm', 'style' => 'float:right;']) ?>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->
<script>
    $("document").ready(function () {

        $(document).on('keyup mouseup', '#appointmentservice-amount', function (e) {
            calculateTotal();
        });
        $(document).on('change', '#appointmentservice-tax', function (e) {
            var tax = $(this).val();
            $.ajax({
                type: 'POST',
                cache: false,
                async: false,
                data: {tax: tax},
                url: '<?= Yii::$app->homeUrl; ?>appointment/appointment-service/get-tax',
                success: function (data) {
                    $("#tax-val").val(data);
                    calculateTotal();
                }
            });
        });

        /*
         * Double click enter function
         * */

        $('.edit_text').on('dblclick', function () {
            var val = $(this).attr('val');
            var idd = this.id;
            var res_data = idd.split("-");
            if (res_data[1] == 'comment') {
                $(this).html('<textarea class="' + idd + '" value="' + val + '">' + val + '</textarea>');

            } else {
                $(this).html('<input class="' + idd + '" type="text" value="' + val + '"/>');

            }

            $('.' + idd).focus();
        });

        $('.edit_text').on('focusout', 'input,textarea', function () {
            var thiss = $(this).parent('.edit_text');
            var data_id = thiss.attr('id');
            var res_id = data_id.split("-");
            var res_val = $(this).val();
            $.ajax({
                type: 'POST',
                cache: false,
                data: {id: res_id[0], name: res_id[1], valuee: res_val},
                url: '<?= Yii::$app->homeUrl; ?>appointment/appointment-service/edit-service',
                success: function (data) {
                    if (data == '') {
                        data = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    }
                    thiss.html(res_val);
                    if (res_id[1] == 'amount') {
                        $('.total-' + data_id).text(data);
                    }
                    location.reload();
                }
            });

        });

        /*
         * Double click Dropdown
         * */

        $('.edit_dropdown').on('dblclick', function () {
            var val = $(this).attr('val');
            var drop_id = $(this).attr('drop_id');
            var idd = this.id;
            var option = $('#' + drop_id).html();
            $(this).html('<select class="' + drop_id + '" value="' + val + '">' + option + '</select>');
            $('.' + drop_id + ' option[value="' + val + '"]').attr("selected", "selected");
            $('.' + drop_id).focus();

        });
        $('.edit_dropdown').on('focusout', 'select', function () {
            var thiss = $(this).parent('.edit_dropdown');
            var data_id = thiss.attr('id');
            var res_id = data_id.split("-");
            var res_val = $(this).val();
            $.ajax({
                type: 'POST',
                cache: false,
                data: {id: res_id[0], name: res_id[1], valuee: res_val},
                url: '<?= Yii::$app->homeUrl; ?>appointment/appointment-service/edit-service-tax',
                success: function (data) {
                    if (data == '') {
                        data = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    }
                    thiss.html(data);
                    location.reload();
                }
            });

        });

    });
    function calculateTotal() {
        var tot = 0;
        var tax_amount = 0;
        var amount = $("#appointmentservice-amount").val();
        var tax_val = $("#tax-val").val();
        if (amount != '' && amount > 0) {
            if (tax_val != '' && tax_val > 0) {
                tax_amount = (parseFloat(amount) * parseFloat(tax_val)) / 100;
            }
            tot = (parseFloat(amount) + parseFloat(tax_amount));
        }
        $("#appointmentservice-total").val(tot.toFixed(2));
    }
</script>

