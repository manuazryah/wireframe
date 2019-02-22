<?php
if ($total_amt != '' && $total_amt > 0) {
    ?>
    <div class="row">
        <div class = 'col-md-4 col-sm-12 col-xs-12 left_padd'>
            <div class = "form-group">
                <label class="control-label" for="">Cheque Number</label>
                <input class="form-control" type = "text" name = "createone[cheque_num]" required>

            </div>
        </div>
        <div class='col-md-4 col-sm-12 col-xs-12 left_padd'>
            <div class="form-group">
                <label class="control-label">Cheque Date</label>

                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input id="createone-cheque_date" name="createone[cheque_date]" type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask value="">
                </div>
                <!-- /.input group -->
            </div>
        </div>
        <div class='col-md-4 col-sm-12 col-xs-12 left_padd'>
            <div class="form-group">
                <label class="control-label" for="">Amount</label>
                <input class="form-control" id="one_time_amt" type="number" name="createone[amount]" value="<?= $total_amt ?>" step="any" required>
            </div>
        </div>
    </div>
    <?php
}
?>
