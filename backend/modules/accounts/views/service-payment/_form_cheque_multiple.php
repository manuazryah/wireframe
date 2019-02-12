<?php
if ($count != '' && $count > 0 && $total_amt != '' && $total_amt > 0 && $count <= 15) {
    ?>
    <div class="row">
        <div class='col-md-12 col-xs-12 expense-head'>
            <span class="sub-heading">Cheque Details</span>
            <div class="horizontal_line"></div>
        </div>
    </div>
    <?php
    if ($count == 1) {
        $amt = $total_amt;
        ?>
        <div class="row">
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
                        <input id="create-1" name="create[cheque_date][]" type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask value="" required>
                    </div>
                    <!-- /.input group -->
                </div>
            </div>
            <div class='col-md-4 col-sm-12 col-xs-12 left_padd'>
                <div class="form-group">
                    <label class="control-label" for="">Amount</label>
                    <input class="form-control mul_cheque_amt" id="mul_cheque_amt-1" type="number" name="create[amount][]" value="<?= sprintf('%0.2f', $amt); ?>" step="any" required>
                </div>
            </div>
        </div>
        <?php
    } else {
        $j = 0;
        if ($total_tax_amt > 0 && $total_tax_amt != '') {
            $j = 2;
            if ($check == 1) {
                $amt = $total_amt / ($count);
                $cheque_amount = $amt;
            } else {
                $amt = ($total_amt - $total_tax_amt) / ($count);
                $cheque_amount = $total_tax_amt + $amt;
            }
            ?>
            <div class="row">
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
                            <input id="create-1" name="create[cheque_date][]" type="text" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask value="" required>
                        </div>
                        <!-- /.input group -->
                    </div>
                </div>
                <div class='col-md-4 col-sm-12 col-xs-12 left_padd'>
                    <div class="form-group">
                        <label class="control-label" for="">Amount</label>
                        <input class="form-control mul_cheque_amt" id="mul_cheque_amt-1" type="number" name="create[amount][]" value="<?= sprintf('%0.2f', ($cheque_amount)); ?>" step="any" required>
                    </div>
                </div>
            </div>
            <?php
        } else {
            $j = 1;
            $amt = $total_amt / $count;
        }
        for ($i = $j; $i <= $count; $i++) {
            ?>
            <div class="row">
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
}
?>
