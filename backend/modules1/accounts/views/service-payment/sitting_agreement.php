<?php

use yii\helpers\Html;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="side-agreement">
    <div class="header">
        <h3>Service Tenancy Contract</h3>
    </div>
    <div class="main-content">
        <p><strong>This contract is made on </strong><?= $model->date != '' ? date("d/m/Y", strtotime($model->date)) : '' ?> <strong>between</strong></p>
        <p><strong class="cmp-title">First:Universal Business Links LLC, </strong> located in 202,Al KazimBuilidng, Hor Al Anz East, Dubai.</p>
        <p><strong><i>Hereinafter referred collectively as "First Party”&</i></u></strong></p>
        <p><strong class="cmp-title">Second :</strong>  <?= $model->company_name ?></p>
        <p><strong><i>Hereinafter referred to as "Second Party”</i></strong></p>

        <h4 class="sub-title">Preamble</h4>
        <p>Whereas the First Party is LLC company and engaged in numerous investment activities such as establishing, investing and managing commercial, industrial and agricultural enterprises. And whereas the First Party is the lessee of Office no <?= $model->office_no ?>, <?= $model->office_address ?> <?= $model->location ?> with a total area of Approx1300sqt.</p>
        <p>Whereas the Second Party desirous to invest and establish a company in UAE to practice its activity <?= $model->activity ?>  and use a portion of the aforesaid offices that are possessed by the First Party, in order to practice its intended company’s activity.</p>
        <p>Therefore the parties have agreed upon the following conditions and articles:</p>

        <h4 class="sub-title">Article (1)</h4>
        <p>The above preamble shall be considered as an integral part of the conditions of this contract and shall be read therewith.</p>

        <h4 class="sub-title">Article (2)</h4>
        <p>Both parties have agreed that the second party shall get from the first party the right to renting of the office no <?= $model->office_no ?>  that is located in <?= $model->office_address ?>, <?= $model->location ?>, Dubai</p>

        <h4 class="sub-title">Article (3)</h4>
        <p>First party also declares that, if there will be any variation occurring from the part of Land Lord regarding the rent or any expenses pertaining to Office no <?= $model->office_no ?> will also reflect in the rental amount of second party in the second year.</p>

        <h4 class="sub-title">Article (4)</h4>
        <p>Both parties agree that the Second party shall pay the first party AED 300/- for DEWA and Internet connection per month. </p>

        <h4 class="sub-title">Article (5)</h4>
        <p>The Second party shall be solely and fully responsible for any debts, expenses or financial obligations that arise out of the business of the company unless such debts or obligations resulted from the acts of the First party if such acts are proved to be contrary to the provisions of this Agreement.</p>
        <p>The second party undertakes it shall comply with all the conditions, laws and regulations that are related to health, labor and/or work timing and any other prevailing regulations for practicing the commercial activities within UAE and it acknowledges that in the event it or any of its staff breaches such rules and/or regulations the second party shall be responsible for the consequences of such a breach, such as fines and/or penalties. The second party also undertakes not to misuse the premises and to use it and its facilities in a proper way and in its appropriate purpose only. The second party undertakes also that in case of vacating the office for any reason to return the office to its original state as it was upon receiving it. The Second Party may not remove any decorations that it might have done in the office unless upon the First Party’s request.</p>
        <p>The second party also complies that, if there is any breach of rules from their part, the first party can take a legal action against the second party as per UAE laws.</p>

        <h4 class="sub-title">Article (6)</h4>
        <p>The duration of this Contract shall be one Gregorian year commencing from 01/12/2018 and expires on 30/11/2019 and may be renewed according to mutual Agreement of both parties and in case any party desires not to renew the contract upon its expiry date, such party should give a two months’ notice to the First party.</p>
        <p>In the event that the second party desires to discontinue the contract and vacate the office prior to the contract expiry date, the second party shall pay a Two months’ rent as compensation to the First party, at the time of vacating the office.</p>

        <h4 class="sub-title">Article (7)</h4>
        <p>Any dispute which may arise in connection with the interpretation or implementation of the provisions of this contract shall be amicably settled between the Parties, failing which, Dubai courts shall be the competent authority to settle the same.</p>

    </div>
    <div class="footer-content">
        <h3 class="party-title">First Party</h3>
        <p class="party-name">Universal Business Links LLC </p>
        <p class="party-designation">Represented By Mr Biby John</p>
        <p class="signature">Signature:</p>
        <h3 class="party-title">Second party</h3>
        <p class="party-name"><?= $model->company_name ?> </p>
        <p class="party-designation">Represented By <?= $model->represented_by ?></p>
        <p class="signature">Signature:</p>
    </div>
</div>
