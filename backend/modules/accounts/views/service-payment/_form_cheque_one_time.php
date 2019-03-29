<?php
if ($total_amt != '' && $total_amt > 0) {
    ?>
    <div class="row">
        <div class = 'col-md-3 col-sm-12 col-xs-12 left_padd'>
            <div class = "form-group">
                <label class="control-label" for="">Cheque Number</label>
                <input class="form-control" type = "text" name = "createone[cheque_num]" required>

            </div>
        </div>
        <div class='col-md-3 col-sm-12 col-xs-12 left_padd'>
            <div class="form-group">
                <label class="control-label">Cheque Date</label>
                <div class="input-group">
                    <input id="createone-cheque_date" name="createone[cheque_date]" type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask value="">
                </div>
                <!-- /.input group -->
            </div>
        </div>
        <div class='col-md-3 col-sm-12 col-xs-12 left_padd'>
            <div class="form-group">
                <label class="control-label" for="">Bank</label>
                <select class="form-control" id="createone_bank" name="createone[bank]" value="">
                    <option value="">Choose Bank</option>
                    <?php
                    if (!empty($banks)) {
                        foreach ($banks as $bank) {
                            if ($bank->bank_name != '') {
                                ?>
                                <option value="<?= $bank->id ?>" ><?= $bank->bank_name ?></option>
                                <?php
                            }
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class='col-md-3 col-sm-12 col-xs-12 left_padd'>
            <div class="form-group">
                <label class="control-label" for="">Amount</label>
                <input class="form-control" id="one_time_amt" type="number" name="createone[amount]" value="<?= $total_amt ?>" step="any" required>
            </div>
        </div>
    </div>
    <?php
}
?>
