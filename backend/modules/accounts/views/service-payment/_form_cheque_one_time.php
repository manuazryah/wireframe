<?php
if ($total_amt != '' && $total_amt > 0) {
    ?>
    <div class="row">
        <div class='col-md-12 col-xs-12 expense-head'>
            <span class="sub-heading">Cheque Details</span>
            <div class="horizontal_line"></div>
        </div>
    </div>
    <div class="row">
        <div class = 'col-md-4 col-sm-12 col-xs-12 left_padd'>
            <div class = "form-group">
                <label class="control-label" for="">Cheque Number</label>
                <input class="form-control" type = "text" name = "createone[cheque_num]">

            </div>
        </div>
        <div class='col-md-4 col-sm-12 col-xs-12 left_padd'>
            <div class="form-group">
                <label class="control-label" for="">Cheque Date</label>
                <input type="date" class="form-control" name="createone[cheque_date]" required>
            </div>
        </div>
        <div class='col-md-4 col-sm-12 col-xs-12 left_padd'>
            <div class="form-group">
                <label class="control-label" for="">Amount</label>
                <input class="form-control" id="one_time_amt" type = "number" name = "createone[amount]" value="<?= $total_amt ?>" required>
            </div>
        </div>
    </div>
    <?php
}
?>
