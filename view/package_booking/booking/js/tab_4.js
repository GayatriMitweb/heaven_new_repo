$('#txt_payment_date1, #txt_payment_date2, #txt_balance_due_date').datetimepicker({ timepicker: false, format: 'd-m-Y' });
$('#txt_booking_date').datetimepicker({ format: 'd-m-Y H:i:s' });
destinationLoading('select[name^=pickup_from]', 'Pickup Location');
destinationLoading('select[name^=drop_to]', 'Drop-off Location');
/////////////////////////////////////Package Tour Master Tab4 validate start/////////////////////////////////////
function package_tour_booking_tab4_validate() {
  g_validate_status = true;

  var payment_mode1 = $("#cmb_payment_mode1").val();
  var payment_mode2 = $("#cmb_payment_mode2").val();

  if (payment_mode1 != "Cash" && payment_mode1 != "Credit Note" && payment_mode1 != "" && payment_mode1 != "Credit Card") {
    validate_empty_fields('txt_bank_name1');
    validate_empty_fields('txt_transaction_id1');
  }

  if (payment_mode2 != "Cash" && payment_mode2 != "Credit Note" && payment_mode2 != "") {
    validate_empty_fields('txt_bank_name2');
    validate_empty_fields('txt_transaction_id2');
  }

  if (g_validate_status == false) { return false; }

}
/////////////////////////////////////Package Tour Master Tab4 validate end/////////////////////////////////////

function back_to_tab_3() {
  $('#tab_4_head').removeClass('active');
  $('#tab_3_head').addClass('active');
  $('.bk_tab').removeClass('active');
  $('#tab_3').addClass('active');
  $('html, body').animate({ scrollTop: $('.bk_tab_head').offset().top }, 200);
}