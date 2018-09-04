<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AppointmentWidget
 *
 * @author
 * JIthin Wails
 */

namespace common\components;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use common\models\Product;

class DocumentLinksWidget extends Widget {

    public $id;

    public function init() {
        parent::init();
        if ($this->id === null) {
            return '';
        }
    }

    public function run() {
        $initial_approval = \common\models\LiceTrdnameIntlapro::find()->where(['licensing_master_id' => $this->id])->one();
        $moa_documents = \common\models\Moa::find()->where(['licensing_master_id' => $this->id])->one();
        $payment_voucher = \common\models\PaymentVoucher::find()->where(['licensing_master_id' => $this->id])->one();
        return $this->render('document_list', [
                    'initial_approval' => $initial_approval,
                    'moa_documents' => $moa_documents,
                    'payment_voucher' => $payment_voucher,
        ]);
    }

}

?>
