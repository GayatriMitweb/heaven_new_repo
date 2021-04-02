<form id="frm_tab2">



	<div class="row">

		<div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

                <select class="form-control" style="width:100%" id="cmb_tour_name" name="cmb_tour_name" onchange="tour_group_reflect(this.id, false);" title="Tour Name"> 

                      <option value="">*Tour Name</option>

                      <?php
                          $sq=mysql_query("select * from tour_master where active_flag = 'Active' order by tour_name asc");
                          while($row=mysql_fetch_assoc($sq)){
                            echo "<option value='$row[tour_id]'>".$row['tour_name']."</option>";
                          }
                      ?>

                </select>

        </div>

      

	    <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">

	        <select class="form-control" id="cmb_tour_group" Title="Tour Date" name="cmb_tour_group" onchange="seats_availability_reflect();"> 

	              <option value="">*Tour Date</option>        

	        </select>

	    </div>



    </div>

    

     <div id="div_seats_availability" class="reflect-seats" style=""></div>  



	<div class="row text-center mg_tp_20">

		<div class="col-xs-12">

			<button class="btn btn-info btn-sm ico_left" type="button" onclick="switch_to_tab1()"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Previous</button>

			&nbsp;&nbsp;

			<button class="btn btn-info btn-sm ico_right">Next&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>

		</div>

	</div>



</form>



<script>

/////// Reflect how many seats are available /////////////////////////////////////////////////

function seats_availability_reflect()

{

  var tour_id = $("#cmb_tour_name").val();

  var tour_group_id = $("#cmb_tour_group").val();



  if( tour_id == '' || tour_group_id == '')

  {

    document.getElementById("div_seats_availability").innerHTML= "";

    return false;

  }



  $.get('../group_tour/inc/seats_availability_reflect.php', { tour_id : tour_id, tour_group_id : tour_group_id }, function(data){

    $('#div_seats_availability').html(data);

  })





}



$('#cmb_tour_name').select2();

function switch_to_tab1(){ $('a[href="#tab1"]').tab('show'); }



$('#frm_tab2').validate({

	rules:{

			cmb_tour_name :{ required: true},
			cmb_tour_group :{ required: true},

	},

	submitHandler:function(form)

	{

		var base_url = $('#base_url').val();

		var group_id = $('#cmb_tour_group').val();

		var available_seats = $('#available_seats').val();	

		var total_seats = $('#total_seats').val();

		var tour_id = $("#cmb_tour_name").val();

		if(available_seats == '0'){
			alert("No Seats Available for this tour");
		}
		$.post('../group_tour/inc/inclusion_reflect.php', {tour_id : tour_id }, function(data){
		    var incl_arr = JSON.parse(data); 
		    var $iframe = $('#incl-wysiwyg-iframe');
			$iframe.contents().find("body").html('');
		      $iframe.ready(function() {
		        $iframe.contents().find("body").append(incl_arr['includes']);
		    });

		    var $iframe1 = $('#excl-wysiwyg-iframe');
			$iframe1.contents().find("body").html('');
		      $iframe1.ready(function() {
		        $iframe1.contents().find("body").append(incl_arr['excludes']);
		    });
		});

		$("#tour_group_id").val(tour_id);

		//Train Info
		$.ajax({

	      type:'post',
	      url: '../group_tour/save/get_train_info.php',
	      data:{ group_id : group_id },
	      success:function(result){
	      	var table = document.getElementById("tbl_package_tour_quotation_dynamic_train");
			  var train_arr = JSON.parse(result);
			  if(jQuery.isEmptyObject(train_arr)){
				  var f_row = table.rows[0];
				  f_row.cells[0].childNodes[0].removeAttribute('checked');
			  };   	
	      	if(table.rows.length!=train_arr.length){
	      		for(var i=1; i<train_arr.length; i++){
		      		addRow('tbl_package_tour_quotation_dynamic_train');
		      	}	
	      	}   	

	      	for(var i=0; i<train_arr.length; i++){
	      		var row = table.rows[i]; 
	      		row.cells[2].childNodes[0].value = train_arr[i]['from_location'];
	      		row.cells[3].childNodes[0].value = train_arr[i]['to_location'];
	      		row.cells[4].childNodes[0].value = train_arr[i]['class'];
	      		row.cells[5].childNodes[0].value =$('#train_dept_date_hidde').val();	      		

	      		$(row.cells[2].childNodes[0]).trigger('change');
	            $(row.cells[3].childNodes[0]).trigger('change');
	            $(row.cells[4].childNodes[0]).trigger('change');
	            $(row.cells[5].childNodes[0]).trigger('change');
	            $(row.cells[6].childNodes[0]).trigger('change');
	      	}
	      }
	    });

		//Flight Info
	      $.ajax({
	      type:'post',
	      url: '../group_tour/save/get_plane_info.php',
	      data:{ group_id : group_id },
	      success:function(result){
	      	var table = document.getElementById("tbl_package_tour_quotation_dynamic_plane");
			  var plane_arr = JSON.parse(result);
			  if(jQuery.isEmptyObject(plane_arr)){
				  var f_row = table.rows[0];
				  f_row.cells[0].childNodes[0].removeAttribute('checked');
			  };
	      	if(table.rows.length!=plane_arr.length){
		      	for(var i=1; i<plane_arr.length; i++){
		      		addRow('tbl_package_tour_quotation_dynamic_plane');
		      	}
	      	}
	      	for(var i=0; i<plane_arr.length; i++){
	      		var row = table.rows[i];
				
	      		row.cells[2].childNodes[0].value = plane_arr[i]['city_name']+' - '+plane_arr[i]['from_location'];
	      		row.cells[3].childNodes[0].value = plane_arr[i]['city_name1']+' - '+plane_arr[i]['to_location'];

	      		row.cells[4].childNodes[0].value = plane_arr[i]['airline_name'];
	      		row.cells[5].childNodes[0].value = plane_arr[i]['class'];
	      		row.cells[6].childNodes[0].value = $('#plane_dept_date_hidde').val();
				row.cells[7].childNodes[0].value = plane_arr[i]['arraval_time'];	
				row.cells[8].childNodes[0].value = plane_arr[i]['from_city'];
				row.cells[9].childNodes[0].value = plane_arr[i]['to_city'];

	            $(row.cells[4].childNodes[0]).trigger('change');
	            $(row.cells[5].childNodes[0]).trigger('change');
	            $(row.cells[6].childNodes[0]).trigger('change');
	            $(row.cells[7].childNodes[0]).trigger('change');
	      	}
	      }
	      });
		  //Hotel Info
		  $.ajax({
			type:'post',
	      url: '../group_tour/save/get_hotel_info.php',
	      data:{ group_id : group_id },
	      success:function(result){
	      	var table = document.getElementById("tbl_package_hotel_master");
			  var hotel_arr = JSON.parse(result);	   
			  if(jQuery.isEmptyObject(hotel_arr)){
				  var f_row = table.rows[0];
				  f_row.cells[0].childNodes[0].removeAttribute('checked');
			  };
	      	if(table.rows.length!=hotel_arr.length){
	      		for(var i=1; i<hotel_arr.length; i++){
		      		addRow('tbl_package_hotel_master');
		      	}	
			}

	      	for(var i=0; i<hotel_arr.length; i++){
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
		  })
	      //Cruise Info
	      $.ajax({

	      type:'post',
	      url: '../group_tour/save/get_cruise_info.php',
	      data:{ group_id : group_id },
	      success:function(result){
	      	var table = document.getElementById("tbl_dynamic_cruise_quotation");
			  var cruise_arr = JSON.parse(result);
			  if(jQuery.isEmptyObject(cruise_arr)){
				  var f_row = table.rows[0];
				  f_row.cells[0].childNodes[0].removeAttribute('checked');
			  };	      	
	      	if(table.rows.length!=cruise_arr.length){
	      		for(var i=1; i<cruise_arr.length; i++){
		      		addRow('tbl_dynamic_cruise_quotation');
		      	}	
			}

	      	for(var i=0; i<cruise_arr.length; i++){
	      		var row = table.rows[i]; 
	      		row.cells[2].childNodes[0].value = $('#cruise_dept_date_hidde').val();
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

	      // Costing Info
	      $.ajax({

	      type:'post',

	      url: '../group_tour/save/get_costing_info.php',

	      data:{ group_id : group_id },

	      success:function(result){
			console.log(result);
	      	var cost_arr = JSON.parse(result);   	

	      	var total_adult = $("#total_adult").val();
	      	var adult_cost = total_adult * cost_arr.adult_cost;
	      	$("#adult_cost").val(parseFloat(adult_cost));
			var total_wb_child = $("#children_without_bed").val();
	      	
			  if(total_wb_child == 0){
				$('#children_cost').val(0);
			  }else{
				var child_wb_cost = total_wb_child * cost_arr.children_wb_cost;
				$('#children_cost').val(child_wb_cost);
			  }
	      	//$("#children_cost").val(parseFloat(child_wb_cost));
			var total_infant = $("#total_infant").val();

	      	var infant_cost = total_infant * cost_arr.infant_cost;
	      	$("#infant_cost").val(parseFloat(infant_cost));


	      	var child_with_bed = $('#children_with_bed').val();

	      	if(child_with_bed==0){
	      		$("#with_bed_cost").val(0);
	      	}
	      	else{
				var with_bed_cost2 = child_with_bed * cost_arr.with_bed_cost;   
				$("#with_bed_cost").val(with_bed_cost2);
	      	}
	      	var adult_cost = $("#adult_cost").val();
	      	var children_cost = $("#children_cost").val();
	      	var infant_cost = $("#infant_cost").val();
	      	var with_bed_cost = $("#with_bed_cost").val();

	      	var total_cost = parseFloat(adult_cost) + parseFloat(child_wb_cost) + parseFloat(with_bed_cost2) + parseFloat(infant_cost) + parseFloat(with_bed_cost);     	 
	      	$("#tour_cost").val(parseFloat(total_cost));      	 

	      }

	    });		

		$('a[href="#tab3"]').tab('show');
		}      

	});		    

	





</script>



