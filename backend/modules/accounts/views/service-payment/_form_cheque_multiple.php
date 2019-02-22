<?php
if ($count_diff != '' && $count_diff > 0 && $count <= 15) {
    ?>
    <?php
    $j = $prev_count + 1;
    for ($i = $j; $i <= $count; $i++) {
        ?>
        <div class="row" id="multiple_cheque_row-<?= $j ?>">
            <div class = 'col-md-4 col-sm-12 col-xs-12 left_padd'>
                <div class = "form-group">
                    <label class="control-label" for="">Cheque Number</label>
                    <input class="form-control" type = "text" name = "create[cheque_num][]" required>

                </div>
            </div>
            <div class='col-md-4 col-sm-12 col-xs-12 left_padd'>
                <div class="form-group">
                    <label class="control-label">Cheque Date</label>

                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input id="create-<?= $i ?>" name="create[cheque_date][]" type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask value="" required>
                    </div>
                    <!-- /.input group -->
                </div>
            </div>
            <div class='col-md-4 col-sm-12 col-xs-12 left_padd'>
                <div class="form-group">
                    <label class="control-label" for="">Amount</label>
                    <input class="form-control mul_cheque_amt" id="mul_cheque_amt-<?= $i ?>" type="number" name="create[amount][]" value="<?= sprintf('%0.2f', $amt); ?>" step="any" required>
                </div>
            </div>
        </div>
        <?php
    }
}
?>
