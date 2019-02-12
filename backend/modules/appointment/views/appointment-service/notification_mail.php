<?php

use yii\helpers\Html;
?>

<html>
    <head>
        <title>Appointment Notification</title>
    </head>
    <body>
        <div class="mail-body">
            <div class="content" style="margin: 0px 15%;border: 1px solid #d4d1d1;">
                <div class="content-detail" style="padding: 0px 10%;">
                    <p>Hi <?= $user->name ?>,</p>
                    <p>Appointment <span style="color: #FF9800;font-weight: 600;"><?= $model->service_id ?></span> has to been completed and proceed to accounts.</p>
                </div>
            </div>
        </div>



    </body>
</html>