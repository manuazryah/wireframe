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
                    <p><?= $message ?></p>
                </div>
            </div>
        </div>



    </body>
</html>