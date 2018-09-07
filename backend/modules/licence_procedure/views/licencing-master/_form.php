<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Test */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="test-form form-inline">

    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <section id="tabs">
                <div class="card">

                    <?= common\components\LicenseProcedureTabWidget::widget(['id' => $license_master->id, 'step' => 1]) ?>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="step1">
                            <h3 class="heading">Trade name & initial approval</h3>
                            <?= common\components\AppointmentWidget::widget(['id' => $license_master->appointment_id]) ?>
                            <div class="customer-info-footer">
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                    <ul>
                                        <li>Total Received</li>
                                        <span>8000.00</span>
                                    </ul>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                    <ul>
                                        <li>Total Expense</li>
                                        <span>11000.00</span>
                                    </ul>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                    <ul>
                                        <li>Balance</li>
                                        <span style="color: #939b21">-3000.00</span>
                                    </ul>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <ul>
                                        <li><a href="" class="button">View payment history</a></li>
                                        <li><a href="" class="button">Make a payment</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pad-0">
                                <ul>
                                    <li><a href="" class="button" style="width: fit-content">View quotation</a></li>
                                </ul>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pad-0">
                                <div class="form-box">
                                    <?php $form = ActiveForm::begin(); ?>
                                    <div class="row">
                                        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>    
                                            <?= $form->field($model, 'payment_amount')->textInput(['maxlength' => true]) ?>

                                        </div>
                                        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>  
                                            <?= $form->field($model, 'payment_receipt')->fileInput(['class' => 'form-control']) ?>

                                        </div>
                                        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'> 
                                            <?= $form->field($model, 'certificate')->fileInput(['class' => 'form-control']) ?>

                                        </div>
                                        <div class='col-md-4 col-sm-6 col-xs-12 left_padd'>  
                                            <?= $form->field($model, 'sponsor_family_book')->fileInput(['class' => 'form-control']) ?>

                                        </div>
                                        <div class='col-md-8 col-sm-6 col-xs-12 left_padd'>   
                                            <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

                                        </div>    
                                    </div>


                                    <div class="form-group action-btn-right">
                                        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                                    </div>


                                    <?php ActiveForm::end(); ?>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="next-step">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 pad-0 fright">
                                    <?= Html::a('<span> Completed and procced to next</span>', ['moa', 'id' => $license_master->id], ['class' => 'button green']) ?>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 fright">
                                    <div class="dropdown">
                                        <button class="btn btn-primary dropdown-toggle next-step-btn" type="button" data-toggle="dropdown">Select Step
                                            <span class="caret"></span></button>
                                        <ul class="dropdown-menu next-step-drpdwn">
                                            <li>
                                                <?= Html::a('MOA', ['moa', 'id' => $license_master->id], ['class' => '']) ?>
                                                <?= Html::a('Municipality Approval', ['moa', 'id' => $license_master->id], ['class' => '']) ?>
                                                <?= Html::a('RTA', ['rta', 'id' => $license_master->id], ['class' => '']) ?>
                                                <?= Html::a('DPS', ['dps', 'id' => $license_master->id], ['class' => '']) ?>
                                                <?= Html::a('Police NOC', ['police-noc', 'id' => $license_master->id], ['class' => '']) ?>
                                                <?= Html::a('Others', ['others', 'id' => $license_master->id], ['class' => '']) ?>
                                                <?= Html::a('Payment Voucher', ['payment-voucher', 'id' => $license_master->id], ['class' => '']) ?>
                                                <?= Html::a('Licence', ['licence', 'id' => $license_master->id], ['class' => '']) ?>
                                                <?= Html::a('New Stamp', ['new-stamp', 'id' => $license_master->id], ['class' => '']) ?>
                                                <?= Html::a('Labour Card', ['labour-card', 'id' => $license_master->id], ['class' => '']) ?>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </section>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="right-box">
                <h3 class="heading">Documents</h3>
                <div class="panel-group" id="accordionMenu" role="tablist" aria-multiselectable="true">
                    <?= common\components\DocumentLinksWidget::widget(['id' => $license_master->id]) ?>
                </div>
            </div>
        </div>

    </div>

</div>
