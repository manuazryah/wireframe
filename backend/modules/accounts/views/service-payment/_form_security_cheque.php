<div class="row">
    <div class='col-md-12 col-xs-12 expense-head'>
        <span class="sub-heading">Security Cheque Details</span>
        <div class="horizontal_line"></div>
    </div>
</div>
<div class="row">
    <div class = 'col-md-4 col-sm-12 col-xs-12 left_padd'>
        <div class = "form-group">
            <label class="control-label" for="">Cheque Number</label>
            <input class="form-control" type = "text" name = "Security[cheque_num]" required>

        </div>
    </div>
    <div class='col-md-4 col-sm-12 col-xs-12 left_padd'>
        <div class="form-group">
            <label class="control-label" for="">Cheque Date</label>
            <input type="date" class="form-control" name="Security[cheque_date]" required>
        </div>
    </div>
    <div class='col-md-4 col-sm-12 col-xs-12 left_padd'>
        <div class="form-group">
            <label class="control-label" for="">Amount</label>
            <input class="form-control" type = "number" name = "Security[amount]" value="" required min="1">
        </div>
    </div>
</div>