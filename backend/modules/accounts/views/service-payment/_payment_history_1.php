<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\Debtor;
use common\models\AppointmentServices;
use common\models\Sponsor;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AppointmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payment History';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Default box -->

<div class="box table-responsive">


	<div class="appointment-index">
		<div class="box-header with-border">
			<h3 class="box-title"><?= Html::encode($this->title) ?></h3>
			<a href="<?= Yii::$app->homeUrl ?>accounts/service-payment/payment?id=<?= $id ?>" class="button" style="    width: 16%;
			   float: right;">View Account</a>
		</div>

		<div class="box-body table-responsive">
			<table class="table table-bordered">
				<tr>
					<th></th>
					<th>Date</th>
					<th>Transaction Type</th>
					<th>Cheque Number</th>
					<th>Amount</th>
					<th>Comment</th>
				</tr>
				<?php foreach ($payment_model as $model) {
					?>
					<tr>
						<td></td>
						<td><?= $model->date ?></td>
						<td><?= $model->transaction_type == 1 ? 'Cheque Payment' : 'Cash Payment' ?></td>
						<td><?= $model->transaction_type == 1 ? $model->cheque_no : '' ?></td>
						<td><?= $model->amount; ?></td>
						<td><?= $model->comment; ?></td>
					</tr>

					<?php
				}
				?>



			</table>

		</div>
	</div>
	<!-- /.box-body -->
</div>

<script>

	$("document").ready(function () {



	});
</script>

