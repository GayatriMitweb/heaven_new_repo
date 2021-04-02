<form id="frm_tab1">
    <div class="row">
        <div class="col-md-12">
          <div id="div_list" class="main_block loader_parent mg_tp_10">
            <table id="tbl_gds" name="tbl_gds" class="table table-hover" style="width:100% !important">       
		        </table>
          </div>
        </div>
    </div>
    <div class="row text-center mg_tp_20">

		<div class="col-xs-12">
      <a class="btn btn-info btn-sm ico_left" onclick="refresh_airlist();">Refresh List&nbsp;&nbsp;<i class="fa fa-refresh"></i></a>
			<button class="btn btn-info btn-sm ico_right" onclick="validate_fields();">Next&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>

		</div>

	</div>
</form>
<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>
<script>
  $('a[href="#tab1"]').tab('show');
  $('#frm_tab1').validate({
    submitHandler:function(form, event){
      event.preventDefault();
      var table = document.getElementById("tbl_gds");
      var rowCount = table.rows.length;
      var entryidArray = Array();
      var singlepnrArray = Array();
      for(var i=1; i<rowCount; i++){
        var row = table.rows[i];      
        if(row.cells[1].childNodes[0].checked){
          var entryId = row.cells[10].childNodes[0].value;
          var singlePnr = row.cells[2].childNodes[0].textContent;
          entryidArray.push(entryId);
          singlepnrArray.push(singlePnr);
        }      
      }
      if([...new Set(singlepnrArray)].length > 1){
        error_msg_alert("Please select only one PNR");
        return false;
      }
      if(!entryidArray.length){
        error_msg_alert("Please select atleast one PAX");
        return false;
      }
      $.ajax({url : 'home/pnr_invoice/pnr_to_invoice_reflect.php', data : { entryidArray : entryidArray}, dataType : 'JSON', success : function(data){
          var table = document.getElementById('tbl_dynamic_ticket_master_airfile');
          if (table.rows.length == 1) {
            for (var k = 1; k < table.rows.length; k++) {
              document.getElementById('tbl_dynamic_ticket_master_airfile').deleteRow(k);
            }
          }
          else {
            while (table.rows.length > 1) {
              document.getElementById('tbl_dynamic_ticket_master_airfile').deleteRow(k);
              table.rows.length--;
            }
          }
          if (table.rows.length != data.PAX_INFO.length) {
            for (var j = 0; j < data.PAX_INFO.length - 1; j++) {
              addRow('tbl_dynamic_ticket_master_airfile');
            }
          }
          var nconj = 0;
          for(var j = 0; j < data.PAX_INFO.length; j++){
            table.rows[j].cells[0].childNodes[0].setAttribute('disabled', true);
            table.rows[j].cells[2].childNodes[0].value = data.PAX_INFO[j].first_name;
            table.rows[j].cells[3].childNodes[0].value = data.PAX_INFO[j].middle_name;
            table.rows[j].cells[4].childNodes[0].value = data.PAX_INFO[j].last_name;
            table.rows[j].cells[5].childNodes[0].value = data.PAX_INFO[j].adolescence;
            table.rows[j].cells[5].childNodes[0].disabled = true; 
            table.rows[j].cells[6].childNodes[0].value = data.PAX_INFO[j].ticket_no;
            table.rows[j].cells[7].childNodes[0].value = data.PAX_INFO[j].gds_pnr;
            table.rows[j].cells[8].childNodes[0].value = data.PAX_INFO[j].conjunction;
            if(data.PAX_INFO[j].conjunction == ''){
              nconj++;
            }
          }
          $('#adult_fair').val(data.FARE_INFO[0].Adult * nconj);
          $('#children_fair').val(data.FARE_INFO[0].Child * nconj);
          $('#infant_fair').val(data.FARE_INFO[0].Infant * nconj);
          $('#yq_tax').val(data.FARE_INFO[0].yq_tax * nconj);
          $('#other_taxes').val(data.FARE_INFO[0].other_tax * nconj);
          $('.dynform-btn').trigger('click');
          if(data.SECTOR_INFO[0].arrival_city == data.SECTOR_INFO[data.SECTOR_INFO.length-1].departure_city){
            document.getElementById("type_of_tour-round_trip").checked = true;
          }
          else{
            document.getElementById("type_of_tour-one_way").checked = true;
          }
          let iterator = 1;
          let length = data.SECTOR_INFO.length;
          for(var i = 0; i < length; i++){
            $('#departure_datetime-' + iterator).val(data.SECTOR_INFO[0].departure_datetime);
            $('#arrival_datetime-' + iterator).val(data.SECTOR_INFO[0].arrival_datetime);
            $('#airlines_name-' + iterator).val(data.SECTOR_INFO[0].airlines_name);
            $('#airlines_name-' + iterator).trigger('change');
            $('#flightclass-' + iterator).val(data.SECTOR_INFO[0].class);
            $('#flight_no-' + iterator).val(data.SECTOR_INFO[0].flight_no);
            $('#airpf-' + iterator).val(data.SECTOR_INFO[0].from_city_show + ' - ' + data.SECTOR_INFO[0].departure_city );
            $('#airpt-' + iterator).val(data.SECTOR_INFO[0].to_city_show  + ' - ' + data.SECTOR_INFO[0].arrival_city );
            $('#from_city-' + iterator).val(data.SECTOR_INFO[0].from_city );
            $('#departure_city-' + iterator).val(data.SECTOR_INFO[0].departure_city );
            $('#to_city-' + iterator).val(data.SECTOR_INFO[0].to_city );
            $('#arrival_city-' + iterator).val(data.SECTOR_INFO[0].arrival_city );
            data.SECTOR_INFO.splice(0, 1);
            if(data.SECTOR_INFO.length > 0){
              addDyn('div_dynamic_ticket_info'); event_airport_su();
            }
            iterator = parseInt($('#div_dynamic_ticket_info').attr('data-counter'));
          }
        }
      });

      $('a[href="#tab2"]').tab('show');
    }
  });
  function validate_fields(){
    var table = document.getElementById("tbl_gds");
    var rowCount = table.rows.length;    
    for(var i=0; i<rowCount; i++){
      var row = table.rows[i];
      var flag = false;
      if(row.cells[0].childNodes[0].checked)  flag = true;
    }
    if(flag){
      error_msg_alert("Atleast Select One Unbilled PNR");
      return false;
    }
    else{
      return true;
    }  
  }
  function refresh_airlist(){
    var base_url = $('#base_url').val();  
    $('#div_list').append('<div class="loader"></div>');
    $.get(base_url + 'controller/airfiles/read_airfile.php', {}, function(result){
      result = JSON.parse(result);
      let msg = '';
      let clk_msg = '';
      var error_show = false;
      var file_present_show = 0;
      var airport = [];
      var airline = [];
      $.each(result, function(key, value){    
        if(!value.common.file_present){
          file_present_show++;
        }
        if(!value.common.file_read){
          return;
        }
        if(Object.keys(value.airport).length > 0){
          error_show = true;
          for (const [keys, values] of Object.entries(value.airport)) {
            airport.push(values);
          }
        }
        if(Object.keys(value.airline).length > 0){
          error_show = true;
          for (const [keys, values] of Object.entries(value.airline)) {
            airline.push(values);
            error_show = true;
          }
        }
        if(!value.common.save && !value.common.file_read){
          error_show = true;
        }
      });
      if(error_show){
        msg = "Data Read Unsuccessfull";
        if(airport.length > 0){
          let count = 0;
          msg = "Below Airport isn't present in the system<br>";
          msg += "<ul style='list-style-type: none;text-align: left;'>";
          for (let i=0; i < airport.length; i++) {
            msg += '<li>'+(++count)+'<a target="_blank" href="https://www.google.com/search?q='+airport[i]+'+airport">:&nbsp;&nbsp;&nbsp;'+airport[i]+'</a><li>';
          }
          msg += "</ul>";
          clk_msg = "<br><a target='_blank' href='../../other_masters/index.php'>Click Here to Add</a><br><br>";
          error_show = false;
          
        }
        if(airline.length > 0){
          let count = 0;
          msg += "<br>Below Airline isn't present in the system<br>";
          msg += "<ul style='list-style-type: none;text-align: left;'>";
          for (let i=0; i < airline.length; i++) {
            msg += '<li>'+(++count)+'<a target="_blank" href="https://www.google.com/search?q='+airline[i]+'+airlines">:&nbsp;&nbsp;&nbsp;'+airline[i]+'</a><li>';
          }
          msg += "</ul>";
          clk_msg = "<br><a target='_blank' href='../../other_masters/index.php'>Click Here to Add</a><br><br>";
          error_show = false;
        }
      }
      else if(file_present_show == 2){
        msg = "No Files To Read";
        $('#vi_confirm_box').vi_confirm_box({
          message: "<span style='font-size:16px'>"+msg+clk_msg+"</span>",
          false_btn: false,
		      true_btn_text: 'Ok'
        });
      }
      else{
        msg = "Data Read Successfull";
      }
      if(msg){
        $('#vi_confirm_box').vi_confirm_box({
          message: "<span style='font-size:16px'>"+msg+clk_msg+"</span>",
          false_btn: false,
		      true_btn_text: 'Ok'
				});
      }   
      var columns = [
        {title:"S_No"},
        {title:""},
        {title:"PNR_No"},
        {title:"Ticket_No.&nbsp;&nbsp;&nbsp;"},
        {title:"Pax_Name"},
        {title:"Issue_Date"},
        {title:"Trip&nbsp;&nbsp;&nbsp;"},
        {title:"Travel_Date"},
        {title:"Total_Fare"},
        {title:"PNR_Type"},
        {title:"", className:"hidden"},
      ];
      $.get('home/pnr_invoice/unbilled_pnr_reflect.php', {}, function(data){
        pagination_load(data,columns, true,false, 10,'tbl_gds');
			  $('.loader').remove();
	    });
    });
  }
  refresh_airlist();  //driver function
</script>