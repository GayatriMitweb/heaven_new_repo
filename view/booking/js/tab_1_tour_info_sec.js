/////// Reflect how many seats are available /////////////////////////////////////////////////
function seats_availability_reflect() {
  var tour_id = $("#cmb_tour_name").val();
  var tour_group_id = $("#cmb_tour_group").val();

  if (tour_id == '' || tour_group_id == '') {
    document.getElementById("div_seats_availability").innerHTML = "";
    return false;
  }

  $.get('../inc/seats_availability_reflect.php', { tour_id: tour_id, tour_group_id: tour_group_id }, function (data) {
    $('#div_seats_availability').html(data);

  })
}


//////////////////Seats availability check start /////////////////////////////
function seats_availability_check() {
  var tour_id = $("#cmb_tour_name").val();
  var tour_group_id = $("#cmb_tour_group").val();

  $.get("../inc/seats_availability_check.php", { tour_id: tour_id, tour_group_id: tour_group_id }, function (data) {
    // data1 = data.trim();
    var tour_info_arr = JSON.parse(data);

    $('#txt_available_seats').val(tour_info_arr[0]['available_seats']);
    $('#txt_total_seats1').val(tour_info_arr[0]['total_seats']);
    $('#seats_booked').val(tour_info_arr[0]['seats_booked']);
    if (tour_info_arr[0]['available_seats'] == '0') {
      alert("All the bookings are done in this tour.");
      return false;
      //window.location.href = '../index.php';
    }
    else {
      $('#txt_available_seats').val(tour_info_arr[0]['available_seats']);
      $('#txt_total_seats1').val(tour_info_arr[0]['total_seats']);
    }
  });




}
//////////////////Seats availability check end /////////////////////////////

//////////////////Due date reflect start/////////////////////////////
function due_date_reflect() {
  var text = $("#cmb_tour_group option:selected").text();
  var text_arr = text.split(' ');
  var start_date = text_arr[0].trim();
  var date_arr = start_date.split('-');

  var d = new Date();
  d.setDate(date_arr[0]);
  d.setMonth(date_arr[1] - 1);
  d.setFullYear(date_arr[2]);

  var yesterdayMs = d.getTime() - 1000 * 60 * 60 * 24; // Offset by one day;
  d.setTime(yesterdayMs);
  var month = d.getMonth() + 1;

  var due_date = d.getDate() + '-' + month + '-' + d.getFullYear();
  $('#txt_balance_due_date').val(due_date);
}

//////////////////Due date reflect end/////////////////////////////

//////////////////Tain and plane date reflect start/////////////////////////////

function tour_type_reflect(tour_id, offset = '') {
  var tour_id = $('#' + tour_id).val();
  $.post('../inc/tour_type_reflect.php', { tour_id: tour_id }, function (data) {

    if (data == "Domestic") {
      $('input[name="txt_m_passport_no"]').prop('disabled', true);
      $('input[name="txt_m_passport_issue_date"]').prop('disabled', true);
      $('input[name="txt_m_passport_expiry_date"]').prop('disabled', true);
    }

    else {
      $('input[name="txt_m_passport_no"]').prop('disabled', false);
      $('input[name="txt_m_passport_issue_date"]').prop('disabled', false);
      $('input[name="txt_m_passport_expiry_date"]').prop('disabled', false);
      //$('input[name="txt_m_passport_issue_date"]').val('');
      //$('input[name="txt_m_passport_expiry_date"]').val('');
    }
    $('#tour_type_r').val(data);
  });
}

/////Traveling dates validation///////
function validate_travelingDates(id) {
  var group_id = $('#cmb_tour_group').val();
  var chk_date = $('#' + id).val();
  $.ajax({
    type: 'post',
    url: '../inc/get_tour_dates.php',
    data: { group_id: group_id, chk_date: chk_date },
    success: function (result) {
      if (result == 'Error') {
        error_msg_alert("Date should be in between tour dates");
        $('#' + id).css({ 'border': '1px solid red' });
        document.getElementById(id).value = "";
        $('#' + id).focus();
        g_validate_status = false;
        return false;
      }
      else {
        $('#' + id).css({ 'border': '1px solid #ddd' });
        return (true);
      }
      console.log(result);
    }
  });
}
///////End Traveling dates validation//////////


function tour_details_reflect(cmb_tour_group) {
  var group_id = $('#' + cmb_tour_group).val();
  /////////////// Train ////////////////
  $.ajax({
    type: 'post',
    url: '../inc/get_train_info.php',
    data: { group_id: group_id },
    success: function (result) {

      // Train Info////
      var table = document.getElementById("tbl_train_travel_details_dynamic_row");
      var train_arr = JSON.parse(result);
      if (jQuery.isEmptyObject(train_arr)) {
        var f_row = table.rows[0];
        f_row.cells[0].childNodes[0].removeAttribute('checked');
        document.getElementById('chk_train_select_all').removeAttribute('checked');
      };
      if (table.rows.length != train_arr.length) {
        for (var i = 1; i < train_arr.length; i++) {
          addRow('tbl_train_travel_details_dynamic_row');
        }
      }
      for (var i = 0; i < train_arr.length; i++) {
        var row = table.rows[i];
        row.cells[0].childNodes[0].setAttribute('checked', 'true');
        row.cells[3].childNodes[0].value = train_arr[i]['from_location'];
        row.cells[4].childNodes[0].value = train_arr[i]['to_location'];
        row.cells[8].childNodes[0].value = train_arr[i]['class'];

        $(row.cells[3].childNodes[0]).trigger('change');
        $(row.cells[4].childNodes[0]).trigger('change');
        $(row.cells[8].childNodes[0]).trigger('change');

      }
    }
  });

  /////////// Plane ////////////////
  $.ajax({
    type: 'post',
    url: '../inc/get_plane_info.php',
    data: { group_id: group_id },
    success: function (result) {

      var table = document.getElementById("tbl_plane_travel_details_dynamic_row");

      var plane_arr = JSON.parse(result);
      if (jQuery.isEmptyObject(plane_arr)) {
        var f_row = table.rows[0];
        f_row.cells[0].childNodes[0].removeAttribute('checked');
        document.getElementById('chk_plane_select_all').removeAttribute('checked');
      };
      if (table.rows.length != plane_arr.length) {
        for (var i = 1; i < plane_arr.length; i++) {
          addRow('tbl_plane_travel_details_dynamic_row');
        }
      }
      for (var i = 0; i < plane_arr.length; i++) {

        var row = table.rows[i];
        row.cells[0].childNodes[0].setAttribute('checked', 'true');

        row.cells[2].childNodes[0].value = plane_arr[i]['dapart_time'];
        row.cells[3].childNodes[0].value = plane_arr[i]['from_city'] + ' - ' + plane_arr[i]['from_location'];
        row.cells[4].childNodes[0].value = plane_arr[i]['to_city'] + ' - ' + plane_arr[i]['to_location'];
        row.cells[5].childNodes[0].value = plane_arr[i]['airline_name'];
        row.cells[8].childNodes[0].value = plane_arr[i]['arraval_time'];
        $(row.cells[5].childNodes[0]).trigger('change');
        $(row.cells[8].childNodes[0]).trigger('change');
        row.cells[9].childNodes[0].value = plane_arr[i]['from_city_id'];
        row.cells[10].childNodes[0].value = plane_arr[i]['to_city_id'];

      }
    }
  });

  /////////////// Cruise ////////////////
  $.ajax({
    type: 'post',
    url: '../inc/get_cruise_info.php',
    data: { group_id: group_id },
    success: function (result) {

      // Cruise Info////
      var table = document.getElementById("tbl_dynamic_cruise_package_booking");
      var cruise_arr = JSON.parse(result);
      if (jQuery.isEmptyObject(cruise_arr)) {
        var f_row = table.rows[0];
        f_row.cells[0].childNodes[0].removeAttribute('checked');
        document.getElementById('chk_cruise_select_all').removeAttribute('checked');
      };

      if (table.rows.length != cruise_arr.length) {
        for (var i = 1; i < cruise_arr.length; i++) {
          addRow('tbl_dynamic_cruise_package_booking');
        }
      }

      for (var i = 0; i < cruise_arr.length; i++) {
        var row = table.rows[i];
        row.cells[0].childNodes[0].setAttribute('checked', 'true');

        row.cells[2].childNodes[0].value = cruise_arr[i]['dept_datetime'];
        row.cells[3].childNodes[0].value = cruise_arr[i]['arrival_datetime'];
        row.cells[4].childNodes[0].value = cruise_arr[i]['route'];
        row.cells[5].childNodes[0].value = cruise_arr[i]['cabin'];

        $(row.cells[2].childNodes[0]).trigger('change');
        $(row.cells[3].childNodes[0]).trigger('change');
        $(row.cells[4].childNodes[0]).trigger('change');
        $(row.cells[5].childNodes[0]).trigger('change');

      }
    }
  });

  ////Hotel Reflecet///
  $.ajax({
    type: 'post',
    url: '../inc/get_hotel_info.php',
    data: { group_id: group_id },
    success: function (result) {

      var table = document.getElementById("tbl_package_hotel_master");

      var hotel_arr = JSON.parse(result);
      if (jQuery.isEmptyObject(hotel_arr)) {
        var f_row = table.rows[0];
        f_row.cells[0].childNodes[0].removeAttribute('checked');
      };
      if (table.rows.length != hotel_arr.length) {
        for (var i = 1; i < hotel_arr.length; i++) {
          addRow('tbl_package_hotel_master');
        }
      }
      for (var i = 0; i < hotel_arr.length; i++) {
        var row = table.rows[i];
        row.cells[2].childNodes[0].value = hotel_arr[i]['city_names'];
        row.cells[3].childNodes[0].value = hotel_arr[i]['hotel_names'];
        row.cells[4].childNodes[0].value = hotel_arr[i]['hotel_type'];
        row.cells[5].childNodes[0].value = hotel_arr[i]['total_nights'];

        row.cells[0].childNodes[0].setAttribute('disabled', 'disabled');
        $(row.cells[2].childNodes[0]).trigger('change');
        $(row.cells[3].childNodes[0]).trigger('change');
        $(row.cells[4].childNodes[0]).trigger('change');
        $(row.cells[5].childNodes[0]).trigger('change');
      }
    }
  });

  /////// Costing ////////////////
  $.ajax({
    type: 'post',
    url: '../inc/get_visa_info.php',
    data: { group_id: group_id },
    success: function (result) {
      var visa_arr = JSON.parse(result);
      $('#visa_country_name').val(visa_arr.visa_country_name);
      $('#insuarance_company_name').val(visa_arr.company_name);
    }
  });

}