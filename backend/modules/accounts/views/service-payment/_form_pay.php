<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" id="trigger_close" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Payment</h4>
</div>
<div class="modal-body">
    <form method="post" id="payment-submit">
        <input type="hidden" name="appointment_id" id="appointment_id" value="<?= $appointment_id ?>">
        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 left_padd">
                <div class="form-group">
                    <label class="control-label" for="amount">Amount</label>
                    <input type="text" id="transaction-amount" class="form-control" name="amount" value="<?= $balnce_to_pay ?>" aria-invalid="false" autocomplete="off" required>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12 left_padd">
                <div class="form-group">
                    <label class="control-label" for="transaction-date">Date</label>
                    <input type="date" id="transaction-date" class="form-control" name="transaction_date" value="<?= date('Y-m-d') ?>" aria-invalid="false" readonly>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12 left_padd">
                <div class="form-group">
                    <label class="control-label" for="amount">Payment Type</label>
                    <select id="payment-type" name="payment_type" class="form-control">
                        <option value="1">Cash</option>
                        <option value="2">Cheque</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12 left_padd">
                <div class="form-group">
                    <label class="control-label" for="amount">Cheque No</label>
                    <input type="text" id="cheque-no" class="form-control" name="cheque_no" value="" aria-invalid="false" autocomplete="off">
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12 left_padd">
                <div class="form-group">
                    <label class="control-label" for="amount">Cheque Date</label>
                    <input type="date" id="cheque-date" class="form-control" name="cheque_date" value="" aria-invalid="false">
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 left_padd">
                <div class="form-group">
                    <label class="control-label" for="transaction-comment">Comment</label>
                    <input type="text" id="transaction-comment" class="form-control" name="comment" value="" aria-invalid="false">
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>

<script>
    $("document").ready(function () {
        $("#cheque-no").prop('disabled', true);
        $("#cheque-date").prop('disabled', true);
        $(document).on('change', '#payment-type', function (e) {
            var type = $(this).val();
            if (type == 2) {
                $("#cheque-no").prop('disabled', false);
                $("#cheque-date").prop('disabled', false);
            } else {
                $("#cheque-no").val('');
                $("#cheque-date").val('');
                $("#cheque-no").prop('disabled', true);
                $("#cheque-date").prop('disabled', true);
            }
        });
//        $(document).on('change keyup', '#transaction-amount', function (e) {
//            var amt = $(this).val();
//            var tot = $('#transaction-amount-tot').val();
//            if (amt == '') {
//                amt = 0;
//            }
//            if (parseFloat(amt) < parseFloat(tot)) {
//                var balance = tot - amt;
//                $('#bal-amount').remove();
//                $('#transaction-amount').after('<div id="bal-amount" style="color:red;">Balance Amount : <span id="bal-text"></span></div>');
//                $("#bal-text").text(balance);
//            } else {
//                if (parseFloat(amt) > parseFloat(tot)) {
//                    if ($("#bal-amount").length > 0) {
//                        $('#bal-amount').remove();
//                        $('#transaction-amount').after('<div id="bal-amount" style="color:red;">Amount exeeds the total amount</div>');
//                    }
//                } else {
//                    $('#bal-amount').remove();
//                }
//            }
//        });
        $("#payment-submit").submit(function (e) {
            var amt = $('#transaction-amount').val();
            var tot = $('#transaction-amount-tot').val();
            var str = $(this).serialize();
            if (amt > 0) {
                $.ajax({
                    type: "POST",
                    url: '<?= Yii::$app->homeUrl; ?>accounts/service-payment/ajax-payment',
                    data: str, // serializes the form's elements.
                    success: function (data)
                    {
                        $("#trigger_close").click();
                        $.pjax.reload({container: '#products-table', timeout: false});
                    }
                });
            }
            e.preventDefault(); // avoid to execute the actual submit of the form.
        });
    });
</script>
