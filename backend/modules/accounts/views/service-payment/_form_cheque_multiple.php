<?php
if ($count != '' && $count > 0 && $total_amt != '' && $total_amt > 0 && $count <= 15) {
    $amt = $total_amt / $count;
    ?>
    <div class="row">
        <div class='col-md-12 col-xs-12 expense-head'>
            <span class="sub-heading">Cheque Details</span>
            <div class="horizontal_line"></div>
        </div>
    </div>
    <?php
    for ($i = 1; $i <= $count; $i++) {
        ?>
        <div class="row">
            <div class = 'col-md-4 col-sm-12 col-xs-12 left_padd'>
                <div class = "form-group">
                    <label class="control-label" for="">Cheque Number</label>
                    <input class="form-control" type = "text" name = "create[cheque_num][]">

                </div>
            </div>
            <div class='col-md-4 col-sm-12 col-xs-12 left_padd'>
                <div class="form-group">
                    <label class="control-label" for="">Cheque Date</label>
                    <input type="date" class="form-control" name="create[cheque_date][]" required>
                </div>
            </div>
            <div class='col-md-4 col-sm-12 col-xs-12 left_padd'>
                <div class="form-group">
                    <label class="control-label" for="">Amount</label>
                    <input class="form-control mul_cheque_amt" id="mul_cheque_amt-<?= $i ?>" type="number" name="create[amount][]" value="<?= $amt ?>" step="any" required>
                </div>
            </div>
        </div>
        <?php
    }
}
?>
