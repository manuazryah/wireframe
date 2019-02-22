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

$this->title = 'Cheque Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Default box -->

<div class="box table-responsive">


	<div class="appointment-index">
		<div class="box-header with-border">
			<h3 class="box-title"><?= Html::encode($this->title) ?></h3>

		</div>

		<div class="box-body table-responsive">
			<table class="table table-bordered">
				<tr>
					<th></th>
					<th>Date</th>
					<th>Cheque Number</th>
					<th>Amount</th>
					<th>Status</th>
				</tr>
				<?php foreach ($models as $model) {
					?>
					<tr>
						<td></td>
						<td><?= $model->due_date ?></td>
						<td><?= $model->cheque_no ?></td>
						<td><?= $model->amount ?></td>
						<td><?= $model->status; ?></td>
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

