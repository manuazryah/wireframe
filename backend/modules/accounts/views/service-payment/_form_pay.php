<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span></button>
	<h4 class="modal-title">Payment</h4>
</div>
<div class="modal-body">
	<form method="post" id="payment-submit">
		<input type="hidden" name="appointment_id" id="appointment_id" value="<?= $appointment_id ?>">
		<input type="hidden" name="due_amount" id="due_amount" value="<?= $balnce_to_pay ?>">

		<div class="row">
			<div class="col-md-6 col-sm-2 col-xs-12 left_padd">
				<div class="form-group">
					<label class="control-label" for="amount">Amount</label>
					<input type="text" id="transaction-amount" class="form-control" name="amount" value="<?= $balnce_to_pay ?>" aria-invalid="false" required>
				</div>
			</div>
			<div class="col-md-6 col-sm-2 col-xs-12 left_padd">
				<div class="form-group">
					<label class="control-label" for="transaction-date">Date</label>
					<input type="date" id="transaction-date" class="form-control" name="transaction_date" value="" aria-invalid="false" required>
				</div>
			</div>
			<!--			<div class="col-md-6 col-sm-2 col-xs-12 left_padd">
							<div class="form-group">
								<label class="control-label" for="transaction-type">Transaction Type</label>
								<input type="text" id="transaction-type" class="form-control" name="transaction_type" value="" aria-invalid="false" >
							</div>
						</div>
						<div class="col-md-6 col-sm-2 col-xs-12 left_padd">
							<div class="form-group">
								<label class="control-label" for="transaction-no">Transaction No</label>
								<input type="text" id="transaction-no" class="form-control" name="transaction_no" value="" aria-invalid="false" >
							</div>
						</div>-->
		</div>
		<div class="row">
			<div class="col-md-6 col-sm-2 col-xs-12 left_padd">
				<div class="form-group">
					<label class="control-label" for="transaction-comment">Comment</label>
					<input type="text" id="transaction-comment" class="form-control" name="comment" value="" aria-invalid="false">
				</div>
			</div>
			<!--			<div class="col-md-6 col-sm-2 col-xs-12 left_padd">
							<div class="form-group">
								<label class="control-label" for="amount">Amount</label>
								<input type="text" id="transaction-amount" class="form-control" name="amount" value="<?= $balnce_to_pay ?>" aria-invalid="false" required>
							</div>
						</div>-->
			<!--			<div class="col-md-6 col-sm-2 col-xs-12 left_padd">
							<div class="form-group">
								<label class="control-label" for="cheque-no">Cheque No</label>
								<input type="text" id="cheque-no" class="form-control" name="cheque_no" value="" aria-invalid="false">
							</div>
						</div>-->
		</div>
		<!--		<div class="row">
								<div class="col-md-6 col-sm-2 col-xs-12 left_padd">
									<div class="form-group">
										<label class="control-label" for="transaction-date">Date</label>
										<input type="date" id="transaction-date" class="form-control" name="transaction_date" value="" aria-invalid="false" required>
									</div>
								</div>
					<div class="col-md-6 col-sm-2 col-xs-12 left_padd">
						<div class="form-group">
							<label class="control-label" for="transaction-comment">Comment</label>
							<input type="text" id="transaction-comment" class="form-control" name="comment" value="" aria-invalid="false">
						</div>
					</div>
				</div>-->

		<div class="modal-footer">
			<button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="trigger_close">Close</button>
			<button type="submit" class="btn btn-primary">Save changes</button>
		</div>
	</form>
</div>

<script>
	$("document").ready(function () {
		$("#payment-submit").submit(function (e) {


			var str = $(this).serialize();

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

			e.preventDefault(); // avoid to execute the actual submit of the form.
		});
	});
</script>
