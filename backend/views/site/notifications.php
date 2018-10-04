<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AppointmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Notifications';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
	.switch {
		position: relative;
		display: inline-block;
		width: 90px;
		height: 34px;
	}

	.switch input {display:none;}

	.slider {
		position: absolute;
		cursor: pointer;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background-color: #ca2222;
		-webkit-transition: .4s;
		transition: .4s;
		border-radius: 34px;
	}

	.slider:before {
		position: absolute;
		content: "";
		height: 26px;
		width: 26px;
		left: 4px;
		bottom: 4px;
		background-color: white;
		-webkit-transition: .4s;
		transition: .4s;
		border-radius: 50%;
	}

	input:checked + .slider {
		background-color: #2ab934;
	}

	input:focus + .slider {
		box-shadow: 0 0 1px #2196F3;
	}

	input:checked + .slider:before {
		-webkit-transform: translateX(26px);
		-ms-transform: translateX(26px);
		transform: translateX(55px);
	}

	/*------ ADDED CSS ---------*/
	.slider:after
	{
		content:'OFF';
		color: white;
		display: block;
		position: absolute;
		transform: translate(-50%,-50%);
		top: 50%;
		left: 50%;
		font-size: 10px;
		font-family: Verdana, sans-serif;
	}

	input:checked + .slider:after
	{
		content:'ON';
	}

	/*--------- END --------*/
</style>
<!-- Default box -->

<div class="box table-responsive">


	<div class="appointment-index">
		<div class="box-header with-border">
			<h3 class="box-title"><?= Html::encode($this->title) ?></h3>

		</div>

		<div class="box-body table-responsive">
			<?php Pjax::begin(['id' => 'notification-list']); ?>
			<table class="table table-bordered">
				<tr>
					<th></th>
					<th>Notification Type</th>
					<th>Content</th>
					<th>date</th>
					<th>Status</th>
				</tr>
				<?php
				foreach ($models as $model) {
					if ($model->notification_type == 1)
						$type = "Real Estate Cheque";
					elseif ($model->notification_type == 2)
						$type = "Appointment service cheque";
					elseif ($model->notification_type == 3)
						$type = "New Appointment created";
					?>
					<tr>
						<td></td>
						<td><?= $type ?></td>
						<td><?= $model->notification_content ?></td>
						<td><?= $model->date ?></td>
						<td><label class="switch"><input type="checkbox" id="<?= $model->id ?>" class="notification_check" <?= $model->status == 1 ? 'checked' : '' ?>><div class="slider round"></div></label></td>
					</tr>

					<?php
				}
				?>



			</table>
			<?php Pjax::end(); ?>

		</div>
	</div>
	<!-- /.box-body -->
</div>

<script>

	$(document).ready(function () {
		$(document).on('click', '.notification_check', function (e) {
			var notification_id = this.id;
			$.ajax({
				type: 'POST',
				cache: false,
				async: false,
				data: {id: notification_id},
				url: '<?= Yii::$app->homeUrl; ?>site/ajax-notification-status',
				success: function (response) {
//					$.pjax.reload({container: '#notification-list', timeout: false});
				},
				error: function (response) {
					console.log(response);
				}
			});

		});

	});
</script>

