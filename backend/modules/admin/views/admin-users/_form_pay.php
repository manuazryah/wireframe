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
        <input type="hidden" name="sponsor_id" id="sponsor_id" value="<?= $salesman ?>">
        <input type="hidden" name="balance_amount" id="balance_amount" value="<?= $payment ?>">

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 left_padd">
                <div class="form-group">
                    <label class="control-label" for="amount">Amount</label>
                    <input type="text" id="transaction-amount" class="form-control" name="amount" value="<?= $payment ?>" aria-invalid="false" required>
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
        $("#payment-submit").submit(function (e) {
            var str = $(this).serialize();
            var bal = $('#balance_amount').val();
            var amount = $('#transaction-amount').val();
            if (parseFloat(amount) <= parseFloat(bal)) {
                $.ajax({
                    type: "POST",
                    url: '<?= Yii::$app->homeUrl; ?>admin/admin-users/ajax-payment',
                    data: str, // serializes the form's elements.
                    success: function (data)
                    {
                        $("#trigger_close").click();
                        $.pjax.reload({container: '#products-table', timeout: false});
                    }
                });
            } else {
                alert('Enter Valid Amount');
            }
            e.preventDefault(); // avoid to execute the actual submit of the form.
        });
    });
</script>
