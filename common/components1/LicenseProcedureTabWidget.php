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

class LicenseProcedureTabWidget extends Widget {

    public $id;
    public $step;

    public function init() {
        parent::init();
        if ($this->id === null) {
            return '';
        }
    }

    public function run() {
        $license_master = \common\models\LicencingMaster::findOne($this->id);
        return $this->render('license_procedure_tab', [
                    'license_master' => $license_master,
                    'step' => $this->step,
        ]);
    }

}

?>
