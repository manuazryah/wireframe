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
    <div class='col-md-3 col-sm-12 col-xs-12 left_padd'>
        <div class="form-group">
            <label class="control-label" for="">Amount</label>
            <input class="form-control" type = "number" name = "creates[amount][]" required>
        </div>
    </div>
    <div class='col-md-1 col-sm-12 col-xs-12 left_padd'>
        <div class="form-group">
            <a><i class="fa fa-times cheque-details-delete"></i></a>
        </div>
    </div>
</div>