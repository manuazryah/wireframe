$("document").ready(function () {

    SetDateFormateCreate();

    /********************** Account payment details page start **********************************************/

    $('#appointment-license_expiry_date').inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'});
    $('#appointment-contract_start_date').inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'});
    $('#appointment-contract_end_date').inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'});
    $(document).on('change', '.payment-type', function (e) {
        var type = $(this).val();
        calculateTotal();
        chequeAmountTotal();
        checkOnetimePayment();
        checkMultiplePayment();
        calculateTaxTotal();
    });
    $(document).on('change keyup', '.mul_cheque_amt', function (e) {
//        chequeAmountTotal();
    });
    $(document).on('keyup', '#one-time-tot', function (e) {
//        $(".mul_cheque_amt").val('');
    });
    $(document).on('keyup', '#multiple-tot', function (e) {
        if ($(this).val == '' || $(this).val <= 0) {
            $("#cheque-details-content-multiple").html('');
            $("#multiple-cheque-count").val('');
        }
    });

    $(document).on('change keyup', '#one_time_amt', function (e) {
        var amt = $(this).val();
        var one_time_tot = $('#one-time-tot').val();
        if (parseFloat(amt) < parseFloat(one_time_tot)) {
            var balance = one_time_tot - amt;
            if ($("#bal-msg").length <= 0) {
                $('#cheque-details-content-one-time').after('<div id="bal-msg" style="color:red;">Balance Amount : <span id="bal-text"></span></div>');
            }
            $("#bal-text").text(balance);
        } else {
            $('#bal-msg').remove();
        }
        if (parseFloat(amt) > parseFloat(one_time_tot)) {
            alert('Amount exxeeds one time total');
            $('#one_time_amt').val(one_time_tot);
        }
    });
    $(document).on('change keyup', '#multiple-cheque-count', function (e) {
        var count = $(this).val();
        var mul_tot = $('#multiple-tot').val();
        var prev_count = $('#cheque_count').val();
        if (count > 0) {
            $("#cmprivacy").remove();
        }
        if (count > 15) {
            count = 15;
            $('#multiple-cheque-count').val(count);
        }
        if (count > prev_count) {
            if (mul_tot > 0) {
                showLoader();
                $.ajax({
                    type: 'POST',
                    cache: false,
                    async: false,
                    data: {count: count, prev_count: prev_count},
                    url: homeUrl + 'accounts/service-payment/multiple-cheque-details',
                    success: function (data) {
                        $("#cheque-details-content-multiple").append(data);
                        $('#cheque_count').val(count);
                        SetDateFormateCreate();
                    }
                });
                hideLoader();
            } else {
                $('#cheque-details-content-multiple').html('');
                $('#multiple-cheque-count').val(0);
            }
        } else {
            for (i = prev_count; i > count; i--) {
                $('#multiple_cheque_row-' + prev_count).remove();
                $('#cheque_count').val(prev_count - 1);
            }
        }
    });
    $(document).on('blur', '.service-amt-tot', function (e) {
        var amt_val = $(this).val();
        var service_id = $(this).attr('data-val').match(/\d+/); // 123456
        $.ajax({
            type: 'POST',
            cache: false,
            async: false,
            data: {amt_val: amt_val, service_id: service_id},
            url: homeUrl + 'accounts/service-payment/change-service-total',
            success: function (data) {
                $('.payment-type').trigger("change");
            }
        });
    });
    $(document).on('change', '#one-time-payment_type', function (e) {
        var type = $(this).val();
        var tot_amt = $('#one-time-tot').val();
        if (type == 2) {
            $.ajax({
                type: 'POST',
                cache: false,
                async: false,
                data: {total_amt: tot_amt},
                url: homeUrl + 'accounts/service-payment/one-time-cheque-details',
                success: function (data) {
                    $("#cheque-details-content-one-time").html(data);
                    $('#createone-cheque_date').inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'});
                }
            });
        } else {
            $("#cheque-details-content-one-time").html('');
        }
    });
    $(document).on('submit', '#account-form', function (e) {
        var status = '<?php echo $sub_status; ?>';
        if (status > 1) {
            if (confirm('Any changes made in this form will remove all related datas')) {
                var mul_tot_amt = $('#multiple-tot').val();
                var one_time_tot = $('#one-time-tot').val();
                var cheque_count = $('#multiple-cheque-count').val();
                var tot = calcchequeAmountTotal();
                var start = parseFloat(mul_tot_amt) - 1;
                var end = parseFloat(mul_tot_amt) + 1;
                var grand_tot = parseFloat(mul_tot_amt) + parseFloat(one_time_tot);
                if (tot > start && tot < end) {
                    var service_tot = parseFloat($('#grand-tot').val());
                    var grand_tot_start = parseFloat(grand_tot) - 1;
                    var grand_tot_end = parseFloat(grand_tot) + 1;
                    if (service_tot > grand_tot_start && service_tot < grand_tot_end) {

                    } else {
                        alert('One time and multiple total deos not match with the service total');
                        e.preventDefault();
                    }
                } else {
                    if (mul_tot_amt > 0 && cheque_count <= 0) {
                        $('#multiple-cheque-count').after('<div id="cmprivacy" style="color:red;">Enter Valid No of Cheques.</div>');
                    } else {
                        alert('Cheque amount total does not match with multiple total amount.Please Enter a valid amount.');
                    }
                    e.preventDefault();
                }
            } else {
                e.preventDefault();
            }
        } else {
            var mul_tot_amt = $('#multiple-tot').val();
            var one_time_tot = $('#one-time-tot').val();
            var cheque_count = $('#multiple-cheque-count').val();
            var tot = calcchequeAmountTotal();
            var start = parseFloat(mul_tot_amt) - 1;
            var end = parseFloat(mul_tot_amt) + 1;
            var grand_tot = parseFloat(mul_tot_amt) + parseFloat(one_time_tot);
            if (tot > start && tot < end) {
                var service_tot = parseFloat($('#grand-tot').val());
                var grand_tot_start = parseFloat(grand_tot) - 1;
                var grand_tot_end = parseFloat(grand_tot) + 1;
                if (service_tot > grand_tot_start && service_tot < grand_tot_end) {

                } else {
                    alert('One time and multiple total deos not match with the service total');
                    e.preventDefault();
                }
            } else {
                if (mul_tot_amt > 0 && cheque_count <= 0) {
                    $('#multiple-cheque-count').after('<div id="cmprivacy" style="color:red;">Enter Valid No of Cheques.</div>');
                } else {
                    alert('Cheque amount total does not match with multiple total amount.Please Enter a valid amount.');
                }
                e.preventDefault();
            }
        }
    });
    $('#security_cheque').change(function () {
        showLoader();
        if ($(this).is(":checked")) {
            $.ajax({
                type: 'POST',
                cache: false,
                async: false,
                data: {},
                url: homeUrl + 'accounts/service-payment/get-security-cheque-details',
                success: function (data) {
                    $("#security-cheque-details").html(data);
                    $('#security-cheque_date').inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'});
                }
            });
        } else {
            $('#security-cheque-details').html('');
        }
        hideLoader();
    });
    $('#appointment-tax_to_onetime').change(function ()
    {
        var tax_val = $('#multiple-tax-tot').val();
        var mul_total = $('#multiple-tot').val();
        var one_time_total = $('#one-time-tot').val();
        if ($(this).is(':checked')) {
            var new_mult = parseFloat(mul_total) - parseFloat(tax_val);
            var new_onetime = parseFloat(one_time_total) + parseFloat(tax_val);
            $('#one-time-tot').val(new_onetime.toFixed(2));
            $('#multiple-tot').val(new_mult.toFixed(2));
        } else {
            var new_mult = parseFloat(mul_total) + parseFloat(tax_val);
            var new_onetime = parseFloat(one_time_total) - parseFloat(tax_val);
            $('#one-time-tot').val(new_onetime.toFixed(2));
            $('#multiple-tot').val(new_mult.toFixed(2));
        }
        $("#cheque-details-content-multiple").html('');
        $("#cheque-details-content-one-time").html('');
        $("#multiple-cheque-count").val('');
    });
    /********************** Account payment details page end **********************************************/

});
/********************** Account payment details page **********************************************/

function chequeAmountTotal() {
    var row_count = $('#multiple-cheque-count').val();
    var tot_amt = $('#multiple-tot').val();
    var mul_tot = 0;
    var flag = 0;
    for (i = 1; i <= row_count; i++) {
        var row_tot = $('#mul_cheque_amt-' + i).val();
        var mul_tot_pre = parseFloat(mul_tot);
        mul_tot += parseFloat(row_tot);
        if (mul_tot > tot_amt) {
            flag = 1;
            var bal = tot_amt - mul_tot_pre;
            if (bal >= 0) {
                $('#mul_cheque_amt-' + i).val(bal.toFixed(2));
            } else {
                $('#mul_cheque_amt-' + i).val(0);
            }
        }
    }
    if (flag == 1) {
        alert('Cheque amount total does not match with multiple total amount');
    }
    var total_cheque_amt = $('#multiple-tot').val();
    if (mul_tot < total_cheque_amt) {
        var balance = total_cheque_amt - mul_tot;
        if ($("#bal-msg").length <= 0) {
            $('#cheque-details-content-multiple').after('<div id="bal-msg" style="color:red;">Balance Amount : <span id="bal-text"></span></div>');
        }
        $("#bal-text").text(balance);
    } else {
        $('#bal-msg').remove();
    }
    return mul_tot;
}

function calcchequeAmountTotal() {
    var row_count = $('#multiple-cheque-count').val();
    var tot_amt = $('#multiple-tot').val();
    var mul_tot = 0;
    for (i = 1; i <= row_count; i++) {
        var row_tot = $('#mul_cheque_amt-' + i).val();
        var mul_tot_pre = parseFloat(mul_tot);
        mul_tot += parseFloat(row_tot);
        if (mul_tot > tot_amt) {
            var bal = tot_amt - mul_tot_pre;
            if (bal >= 0) {
                $('#mul_cheque_amt-' + i).val(bal.toFixed(2));
            } else {
                $('#mul_cheque_amt-' + i).val(0);
            }
        }
    }
    return mul_tot;
}

function calculateTotal() {
    var row_count = $('#total-row_count').val();
    var mul_tot = 0;
    var one_tot = 0;
    for (i = 1; i <= row_count; i++) {
        var payment_type = $('.payment_type-' + i).val();
        var amt = $('#amount_total-' + i).val();
        if (payment_type != '' && amt != '' && amt > 0) {
            if (payment_type == 1) {
                mul_tot += parseFloat(amt);
            } else if (payment_type == 2) {
                one_tot += parseFloat(amt);
            }
        }

    }
    $('#multiple-tot').val(mul_tot);
    $('#one-time-tot').val(one_tot);
}

function calculateTaxTotal() {
    var row_count = $('#total-row_count').val();
    var mul_tax_tot = 0;
    for (i = 1; i <= row_count; i++) {
        var payment_type = $('.payment_type-' + i).val();
        var amt = $('#tax_amount_total-' + i).val();
        if (payment_type != '' && amt != '' && amt > 0) {
            if (payment_type == 1) {
                mul_tax_tot += parseFloat(amt);
            }
        }

    }
    $('#multiple-tax-tot').val(mul_tax_tot);
}

function checkOnetimePayment() {
    var one_time_tot = $('#one-time-tot').val();
    if (one_time_tot == 0 || one_time_tot == '') {
        $('#one-time-payment_type').val(1);
        $('#one-time-payment_type').trigger("change");
    }
}

function checkMultiplePayment() {
    var multi_tot = $('#multiple-tot').val();
    if (multi_tot == 0 || multi_tot == '') {
        $('#multiple-cheque-count').val(0);
        $('#multiple-cheque-count').trigger("change");
    }
}

function SetDateFormateCreate() {
    var row_count = $('#multiple-cheque-count').val();
    if (row_count >= 0) {
        for (i = 1; i <= row_count; i++) {
            $('#create-' + i).inputmask('dd/mm/yyyy', {'placeholder': 'dd/mm/yyyy'});
        }
    }
}

/********************** Account payment details page **********************************************/


