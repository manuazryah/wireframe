<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Test */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="test-form form-inline">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <section id="tabs">
                <div class="card">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#step1" aria-controls="home" role="tab" data-toggle="tab">Step 1</a></li>
                        <li role="presentation"><a href="#step2" aria-controls="profile" role="tab" data-toggle="tab">Step 2</a></li>
                        <li role="presentation"><a href="#step3" aria-controls="messages" role="tab" data-toggle="tab">Step 3</a></li>
                        <li role="presentation"><a href="#step4" aria-controls="settings" role="tab" data-toggle="tab">Step 4</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="step1">
                            <h3 class="heading">Trade name & initial approval</h3>
                            <div class="customer-info">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 content-box">
                                    <ul>
                                        <li>Customer name / ID</li>
                                        <li>Manu KO</li>
                                    </ul>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 content-box">
                                    <ul>
                                        <li>Email / Phone</li>
                                        <li>Manu KO</li>
                                    </ul>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 content-box">
                                    <ul>
                                        <li>Service ID</li>
                                        <li>Manu KO</li>
                                    </ul>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 content-box">
                                    <ul>
                                        <li>Service type</li>
                                        <li>Manu KO</li>
                                    </ul>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 content-box">
                                    <ul>
                                        <li>Sponsor</li>
                                        <li>Manu KO</li>
                                    </ul>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 content-box">
                                    <ul>
                                        <li>Space ID</li>
                                        <li>Manu KO</li>
                                    </ul>
                                </div>
                            </div>
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
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 pad-0 fright">
                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 form-group action-btn-right fright">
                                    <?= Html::submitButton($model->isNewRecord ? 'Completed and procced to next' : 'Update', ['class' => 'button green']) ?>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="step2">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</div>
                        <div role="tabpanel" class="tab-pane" id="step3">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</div>
                        <div role="tabpanel" class="tab-pane" id="step4">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passage..</div>
                    </div>
                </div>

            </section>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="right-box">
                <h3 class="heading">Documents</h3>
                <div class="panel-group" id="accordionMenu" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordionMenu" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Menu 0
                                </a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body">
                                <ul class="nav">
                                    <li><a href="#">item 1</a></li>
                                    <li><a href="#">item 2</a></li>
                                    <li><a href="#">item 3</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingTwo">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionMenu" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                    Menu 1
                                </a>
                            </h4>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
                            <div class="panel-body">
                                <ul class="nav">
                                    <li><a href="#">item 1</a></li>
                                    <li><a href="#">item 2</a></li>
                                    <li><a href="#">item 3</a></li>
                                    <li><a href="#">item 4</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingThree">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionMenu" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                    Menu 2
                                </a>
                            </h4>
                        </div>
                        <div id="collapseThree" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingThree">
                            <div class="panel-body">
                                <ul class="nav">
                                    <li><a href="#">item 1</a></li>
                                    <li><a href="#">item 2</a></li>
                                    <li><a href="#">item 3</a></li>
                                    <li><a href="#">item 4</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>


                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingFour">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordionMenu" href="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                    Menu 3
                                </a>
                            </h4>
                        </div>
                        <div id="collapseFour" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingFour">
                            <div class="panel-body">
                                <ul class="nav">
                                    <li><a href="#">item 1</a></li>
                                    <li><a href="#">item 2</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>
