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
        <h3>Service Tenancy and Sponsorship Contract</h3>
    </div>
    <div class="main-content">
        <p><strong>This contract is made on </strong><?= $model->date != '' ? date("d/m/Y", strtotime($model->date)) : '' ?> <strong>between</strong></p>
        <p><strong class="cmp-title">First:Universal Business Links LLC, </strong> located in 202,Al KazimBuilidng, Hor Al Anz East, Dubai.</p>
        <p><strong><i>Hereinafter referred collectively as "First Party”&</i></u></strong></p>
        <p><strong class="cmp-title">Second :</strong>  <?= $model->second_party_name ?> Dubai-UAE.,</p>
        <p><strong><i>Hereinafter referred to as "Second Party”</i></u></strong></p>

        <h4 class="sub-title">Preamble</h4>
        <p>Whereas the First Party is LLC company and engaged in numerous investment activities such as Technical Services . And whereas the First Party is the lessee of Office no.M06,Royal House Building, Hor Al Anz East, Dubai with a total area of Approx1500sqt.</p>
        <p>Whereas the Second Party desirous to invest and establish a company in Dubai to practice its activity in GIFTS TRADING use a portion of the aforesaid offices that are possessed by the First Party, in order to practice its intended company’s activity, both parties have agreed that the First Party shall be the trading license sponsor facilitator/coordinator for the intended company and the Sponsor shall be included in the intended company’s Memorandum of Association as the Emirati shareholder of 51% of the company share capital</p>
        <p>The First Party hereby declares and confirms that he has not invested anything whatsoever in the Company and that the Second, Party has paid all the share capital and the expenses of the formation of the Company and that the First Party has no right to claim any shares or benefits in the Company.</p>
        <p>Therefore the parties have agreed upon the following conditions and articles:</p>

        <h4 class="sub-title">Article (1)</h4>
        <p>The above preamble shall be considered as an integral part of the conditions of this contract and shall be read therewith.</p>

        <h4 class="sub-title">Article (2)</h4>
        <p>The second party shall pay the first party AED –10,000-- per year annum against the rent upon the Ejari starting from 04thof October, 2018 till 30th October, 2019 to be paid as follows</p>
        <?= $model->payment_details ?>

        <h4 class="sub-title">Article (3) Obligations of the First Party</h4>
        <p><strong>3.1</strong> To obtain, renew, modify and cancel upon the written request of the Second Party the necessary permissions, licenses and documents of registration at the Dubai Municipality, Department of Economic Development, the Dubai Chamber of Commerce and Industry or any other authorities.</p>
        <p><strong>3.2</strong> To acquire, renew and cancel, upon the written request of the Second Party, the relevant entry, visit and residence visas and work permits for the Second Party’s employees, and the employees and guests of the Company and to handle the procedure for the same at the Immigration department, Ministry of Labour and Social Affairs and other Governmental, Local and Federal authorities at the relevant cost agreed.</p>
        <p><strong>3.3</strong> The First party will not have any right on the administration, accounts or any day to day activity of the second party. The First party shall not in any way interfere in the administration, financial and management of the Company.</p>
        <p><strong>3.4</strong> Not enter into contract or any agreements with any fourth party on behalf of the Company whatever are the reasons.</p>
        <p><strong>3.5</strong> The First Party shall not object to the transfer of the shares appearing in his name in the Memorandum, if the second party decide to assign the same to any third  party, who is a U.A.E. National.</p>
        <p>The second party shall pay the Sponsor, the agreed amount of AED 8,000 (Eight Thousand) one equal payment only per annum for the services rendered to the second party’s company. The said payment shall be considered as full and final payment to the Sponsor towards all its rights. </p>

        <h4 class="sub-title">Article (4)</h4>
        <p>Both parties agree that the First party and Sponsor shall not be entitled to any of the second party’s company profits and income and on the other hand shall not bear or be liable to any losses that maybe incurred by the company which shall be actually and totally owned by the second  party and/or its partners, it is further agreed upon that the second party shall be solely and fully responsible towards third parties for any debts or financial obligations which might be incurred as a result of practicing its activities as the Emarati Shareholder is a trading license sponsor only. </p>
        <p>The First party declares that the First party and Sponsor has not invested any amount in the capital and the said amount is fully arranged by the second party.</p>
        <p>First Party further declares that, if the second party wants to transfer his shares or to remove the Sponsor name from the trade licence to another UAE National as selected by the Second Party, proper notifications to the First party is required and have no objection upon proceeding to any amendment and legality as prescribed by the DED regulations.</p>

        <h4 class="sub-title">Article (5)</h4>
        <p><strong>5.1</strong> The Second party, shall alone have the exclusive authority to manage the company solely in all respects with full and unlimited power without any interference by the First party.</p>
        <p><strong>5.2</strong> The second party shall have the full authority to sell, dispose of the company’s property and assets by selling assignment, lease, mortgage or any other dispositions of such kind.</p>
        <p><strong>5.3</strong> All bank accounts or any other monetary deposits, funds facilities of the Company shall solely belong to the Second party.</p>
        <p><strong>5.4</strong> The Second party, is the party who has the right to open, close, manage and operate the company bank accounts to obtain bank facilities, credits, drafts, loans and to sign and issue cheques and all other financial instruments in the name of and on behalf of the company.</p>
        <p><strong>5.5</strong> The Second party, is the only party who is authorized to appear and represent the company abroad and within the United Arab Emirates, including but not limited to the customs and immigration department, all other governmental and semi-governmental departments and authorities, companies and individuals and to prepare and sign all the related documents and contracts there of.</p>
        <p><strong>5.6</strong> The Second party shall be solely and fully responsible for any debts, expenses or financial obligations that arise out of the business of the company unless such debts or obligations resulted from the acts of the First party if such acts are proved to be contrary to the provisions of this Agreement.</p>
        <p>The second party undertakes it shall comply with all the conditions, laws and regulations that are related to health, Labour and/or work timing and any other prevailing regulations for practicing the commercial activities within UAE and it acknowledges that in the event it or any of its staff breaches such rules and/or regulations the second party shall be responsible for the consequences of such a breach, such as fines and/or penalties. The second party also undertakes not to misuse the premises and to use it and its facilities in a proper way and in its appropriate purpose only. The second party also complies that, if there is any breach of rules from their part, the first party can take a legal action against the second party as per UAE laws.</p>

        <h4 class="sub-title">Article (4)</h4>
        <p>The duration of this Contract shall be one Gregorian year commencing from 04/10/2018 and expires on 30/10/2019 and may be renewed according to mutual Agreement of both parties and in case any party desires not to renew the contract upon its expiry date, such party should give a two months’ notice to the First party.</p>
        <p>If not the Second Party Liability to pay penalty to first party.</p>

        <h4 class="sub-title">Article (5)</h4>
        <p>Any dispute which may arise in connection with the interpretation or implementation of the provisions of this contract shall be amicably settled between the Parties, failing which, Dubai courts shall be the competent authority to settle the same.</p>

        <h4 class="sub-title">Article (6)</h4>
        <p>The Sponsor thru the First Party is set to provide PRO/ VISA services for both Immigration and Labor accompanied with fees required by the Department and the service charge of AED 350/-. For the first 10 visa and additionally AED 550/- per visa beyond 10 visa.</p>

    </div>
    <div class="footer-content">
        <h3 class="party-title">First Party</h3>
        <p class="party-name">Universal Business Links LLC </p>
        <p class="party-designation">Represented By Mr Biby John</p>
        <p class="signature">Signature:</p>
        <h3 class="party-title">Second party</h3>
        <p class="party-name"><?= $model->second_party_name ?> </p>
        <p class="party-designation">Represented By <?= $model->represented_by ?></p>
        <p class="signature">Signature:</p>
    </div>
</div>
