<?php if ($no_of_cheque != '' && $no_of_cheque > 0) { ?>
    <?php
    for ($i = 1; $i <= $no_of_cheque; $i++) {
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
                    <label class="control-label" for="">Expiry Date</label>
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
