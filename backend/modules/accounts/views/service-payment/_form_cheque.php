<?php
if ($type != '' && $type > 0) {
    if ($type == 1) {
        $count = 12;
    } elseif ($type == 2) {
        $count = 4;
    } elseif ($type == 3) {
        $count = 6;
    } elseif ($type == 4) {
        $count = 1;
    }
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
                    <input class="form-control" type = "text" name = "creates[cheque_num][]" required>

                </div>
            </div>
            <div class='col-md-4 col-sm-12 col-xs-12 left_padd'>
                <div class="form-group">
                    <label class="control-label" for="">Cheque Date</label>
                    <input type="date" class="form-control" name="creates[expiry_date][]" required>
                </div>
            </div>
            <div class='col-md-4 col-sm-12 col-xs-12 left_padd'>
                <div class="form-group">
                    <label class="control-label" for="">Amount</label>
                    <input class="form-control" type = "number" name = "creates[amount][]" required>
                </div>
            </div>
        </div>
        <?php
    }
}
?>
