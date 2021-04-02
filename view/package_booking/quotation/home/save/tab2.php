<form id="frm_tab2">

<div class="app_panel"> 

<!--=======Header panel======-->
    <div class="app_panel_head mg_bt_20">
      <div class="container">
          <h2 class="pull-left"></h2>
          <div class="pull-right header_btn">
            <button>
                <a>
                    <i class="fa fa-arrow-right"></i>
                </a>
            </button>
          </div>
      </div>
    </div> 
<!--=======Header panel end======-->
        <div class="container">

		<div class="row">

			<div class="col-md-3 col-sm-4 col-xs-12 mg_bt_20" id="package_div">

		    	<?php
		        $sq_tours = mysql_query("select * from custom_package_master where status !='Inactive'"); ?>
		        <select name="dest_name" id="dest_name" title="Select Destination" onchange="package_dynamic_reflect(this.id)" style="width:100%">
		            <option value="">*Select Destination</option>
		            <?php
	                 $sq_query = mysql_query("select * from destination_master where status != 'Inactive'"); 
	                 while($row_dest = mysql_fetch_assoc($sq_query)){ ?>
	                    <option value="<?php echo $row_dest['dest_id']; ?>"><?php echo $row_dest['dest_name']; ?></option>
	                    <?php } ?>
		        </select>
	   		</div>
			<div class="col-md-7 col-sm-4 col-xs-12 mg_bt_20">
				<small class="note">Note - The Package is not available for this Destination.Please create here.  <a href="../../../../custom_packages/master/index.php" target='_blank'><i class="fa fa-plus"></i>&nbsp;&nbsp;Package Tour</a></small>
			</div>
	   		<div class="col-md-12 col-sm-8 col-xs-12 no-pad" id="package_name_div">

	   		</div>	

		</div>

	

	<div class="row text-center mg_tp_20">

		<div class="col-xs-12">

			<button class="btn btn-info btn-sm ico_left" type="button" onclick="switch_to_tab1()"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp Previous</button>

			&nbsp;&nbsp;

			<button class="btn btn-info btn-sm ico_right">Next&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>

		</div>
	</div>
	<input type="hidden" id="pckg_daywise_url" name="pckg_daywise_url"/>

</form>
<?= end_panel() ?>

<script>
$('#dest_name').select2();
function switch_to_tab1(){ 
	$('#tab2_head').removeClass('active');
	$('#tab1_head').addClass('active');
	$('.bk_tab').removeClass('active');
	$('#tab1').addClass('active');
	$('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);
 }
function package_save_modal(){
	var base_url = $('#base_url').val();
	window.href = base_url+'view/custom_packages/master/package/index.php';
}
$('#frm_tab2').validate({

	rules:{

	},

	submitHandler:function(form,e)
	{
e.preventDefault();
		var base_url = $('#base_url').val();

		var incl_arr = new Array();
		var excl_arr = new Array();
		var package_id_arr = new Array();

		$('input[name="custom_package"]:checked').each(function(){

			package_id_arr.push($(this).val());
			var package_id = $(this).val();
			//Incl & Excl
			var table = document.getElementById("dynamic_table_incl"+package_id);
			var rowCount = table.rows.length;	
			for(var i=0; i<rowCount; i++)
			{
			    var row = table.rows[i];	
				var inclusion = $('#inclusions'+package_id).val();
				var exclusion = $('#exclusions'+package_id).val();

				incl_arr.push(inclusion);
				excl_arr.push(exclusion);
		    }
			
		});
		if(package_id_arr.length==0){
			error_msg_alert('Please select at least one Package!');
			return false;
		}

		var attraction_arr = new Array();
		var program_arr = new Array();
		var stay_arr = new Array();
		var meal_plan_arr = new Array();
		var package_p_id_arr = new Array();
		var day_count_arr = new Array();
		var count = 0;

		for(var j=0;j<package_id_arr.length;j++)
		{
		  var table = document.getElementById("dynamic_table_list_p_"+package_id_arr[j]);
		  var rowCount = table.rows.length;	
		  for(var i=0; i<rowCount; i++){ 
				var row = table.rows[i];
			    if(row.cells[0].childNodes[0].checked){
				   count++;
			       var attraction = row.cells[2].childNodes[0].value;         
			       var program = row.cells[3].childNodes[0].value;         
			       var stay = row.cells[4].childNodes[0].value;         
			       var meal_plan = row.cells[5].childNodes[0].value;  
			       var package_id1 = row.cells[7].childNodes[0].value;  

			       if(program==""){
			          error_msg_alert('Daywise program is mandatory in row'+(i+1));
			          return false;
				   }
				   
				    var flag1 = validate_spattration(row.cells[2].childNodes[0].id);
					var flag2 = validate_dayprogram(row.cells[3].childNodes[0].id);
					var flag3 = validate_onstay(row.cells[4].childNodes[0].id);
					if(!flag1 || !flag2 || !flag3){
						return false;
					}
					attraction_arr.push(attraction);
					program_arr.push(program);
					stay_arr.push(stay);
					meal_plan_arr.push(meal_plan);
					package_p_id_arr.push(package_id1);
				}
			}
			day_count_arr.push(count);
			count = 0;
		}	

		var total_adult = $('#total_adult').val();
		var total_children = $('#total_children').val();
		var from_date = $('#from_date').val();

		$.ajax({

		type:'post',

		url: '../save/package_hotel_info.php',

		data:{ package_id_arr : package_id_arr, from_date : from_date},

		success:function(result){

			//Hotel Info
			var table = document.getElementById("tbl_package_tour_quotation_dynamic_hotel");
			if(table.rows.length == 1){
				for(var k=1; k<table.rows.length; k++){
					document.getElementById("tbl_package_tour_quotation_dynamic_hotel").deleteRow(k);
				}
			}else{
				while(table.rows.length > 1){
					document.getElementById("tbl_package_tour_quotation_dynamic_hotel").deleteRow(k);
					table.rows.length--;
				}
			}

			var hotel_arr = JSON.parse(result);
			if(table.rows.length!=hotel_arr.length){
				for(var j=0; j<hotel_arr.length-1; j++){
					addRow('tbl_package_tour_quotation_dynamic_hotel');
				}
			}

			for(var i=0; i<hotel_arr.length; i++){

				var row = table.rows[i]; 
				city_lzloading(row.cells[2].childNodes[0]);
				var $newOption = $("<option selected='selected'></option>").val(hotel_arr[i]['city_id']).text(hotel_arr[i]['city_name']);
				$(row.cells[2].childNodes[0]).append($newOption).trigger('change.select2');
				$(row.cells[3].childNodes[0]).html('<option value="'+hotel_arr[i]['hotel_id1']+'">'+hotel_arr[i]['hotel_name']+'</option>');
				row.cells[7].childNodes[0].value = hotel_arr[i]['hotel_type'];
				row.cells[11].childNodes[0].value = hotel_arr[i]['package_name'];
				row.cells[13].childNodes[0].value = hotel_arr[i]['package_id'];
			}
		}
	    });
			
		//Transport Info
		$from_date = $('#from_date').val();
		$to_date = $('#to_date').val();
		$.ajax({

		type:'post',

		url: '../save/package_transport_info.php',

		data:{ package_id_arr : package_id_arr,from_date:from_date },

		success:function(result){

			var table = document.getElementById("tbl_package_tour_quotation_dynamic_transport");
			if(table.rows.length == 1){
				for(var k=1; k<table.rows.length; k++){
					document.getElementById("tbl_package_tour_quotation_dynamic_transport").deleteRow(k);
				}
			}else{
				while(table.rows.length > 1){
					document.getElementById("tbl_package_tour_quotation_dynamic_transport").deleteRow(k);
					table.rows.length--;
				}
			}
			var transport_arr = JSON.parse(result);
			if(table.rows.length!=transport_arr.length){
				for(var i=0; i<transport_arr.length-1; i++){
					addRow('tbl_package_tour_quotation_dynamic_transport');
				}
			}
			for(var i=0; i<transport_arr.length; i++){

				var row = table.rows[i];
				
				row.cells[2].childNodes[0].value = transport_arr[i]['bus_id'];

				row.cells[3].childNodes[0].value = $from_date;
				$(row.cells[4].childNodes[0]).prepend('<optgroup value='+transport_arr[i]['pickup_type']+' label="'+(transport_arr[i]['pickup_type']).charAt(0).toUpperCase()+(transport_arr[i]['pickup_type']).slice(1)+ ' Name"><option value="'+transport_arr[i]['pickup_type']+'-'+transport_arr[i]['pickup_id']+'">'+transport_arr[i]['pickup']+'</option></optgroup>');
				document.getElementById(row.cells[4].childNodes[0].id).value = transport_arr[i]['pickup_type']+'-'+transport_arr[i]['pickup_id'];

				$(row.cells[5].childNodes[0]).prepend('<optgroup value='+transport_arr[i]['drop_type']+' label="'+(transport_arr[i]['drop_type']).charAt(0).toUpperCase()+(transport_arr[i]['drop_type']).slice(1)+' Name"><option value="'+transport_arr[i]['drop_type']+'-'+transport_arr[i]['drop_id']+'">'+transport_arr[i]['drop']+'</option></optgroup>');
				document.getElementById(row.cells[5].childNodes[0].id).value = transport_arr[i]['drop_type']+'-'+transport_arr[i]['drop_id'];

				row.cells[7].childNodes[0].value = transport_arr[i]['total_cost'];
				row.cells[8].childNodes[0].value = transport_arr[i]['package_name'];
				row.cells[9].childNodes[0].value = transport_arr[i]['package_id'];
				row.cells[10].childNodes[0].value = transport_arr[i]['pickup_type'];
				row.cells[11].childNodes[0].value = transport_arr[i]['drop_type'];

				$('#' + row.cells[2].childNodes[0].id).select2().trigger("change");
				$('#' + row.cells[4].childNodes[0].id).select2().trigger("change");
				$('#' + row.cells[5].childNodes[0].id).select2().trigger("change");
				destinationLoading($(row.cells[4].childNodes[0]), 'Pickup Location');
				destinationLoading($(row.cells[5].childNodes[0]), 'Drop-off Location');	

			}
		}
		});
	

		$.ajax({
		type:'post',
		url: '../save/package_costing_info.php',
		data:{ package_id_arr : package_id_arr },
		success:function(result){

			//Tour Costing
			var table = document.getElementById("tbl_package_tour_quotation_dynamic_costing");	      	
			if(table.rows.length == 1){
				for(var k=1; k<table.rows.length; k++){
						document.getElementById("tbl_package_tour_quotation_dynamic_costing").deleteRow(k);
				}
			}else{
				while(table.rows.length > 1){
						document.getElementById("tbl_package_tour_quotation_dynamic_costing").deleteRow(k);
						table.rows.length--;
				}
			}
			
			var costing_arr = JSON.parse(result);
			if(table.rows.length!=costing_arr.length){
				for(var i=1; i<costing_arr.length; i++){

					addRow('tbl_package_tour_quotation_dynamic_costing');
				} 
			} 
			for(var i=0; i<costing_arr.length; i++){
				var row = table.rows[i];
				row.cells[9].childNodes[1].value = costing_arr[i]['package_name'];
				row.cells[10].childNodes[1].value = costing_arr[i]['package_id'];
			}

			//Adult & Child Costing
			var table = document.getElementById("tbl_package_tour_quotation_adult_child");
					if(table.rows.length == 1){
						for(var k=1; k<table.rows.length; k++){
							document.getElementById("tbl_package_tour_quotation_adult_child").deleteRow(k);
						}
					}else{
						while(table.rows.length > 1){
							document.getElementById("tbl_package_tour_quotation_adult_child").deleteRow(k);
							table.rows.length--;
						}
					}
			if(table.rows.length!=costing_arr.length){
				for(var i=1; i<costing_arr.length; i++){

					addRow('tbl_package_tour_quotation_adult_child');
				} 
			}

			for(var i=0; i<costing_arr.length; i++){
				var row = table.rows[i];
				row.cells[0].childNodes[0].value = costing_arr[i]['package_name'];
				row.cells[5].childNodes[0].value = costing_arr[i]['package_id'];
			}
		}
		});

		//Selected Packages days reflect
		var dest_id = $('#dest_name').val();
		$.ajax({
		type:'post',
		url: '../../inc/get_packages_days.php',
		data: { dest_id : dest_id,day_count_arr : day_count_arr,package_id_arr : package_id_arr},
		success: function(result){
			$('#daywise_image_select').html(result);
		},
		error:function(result){
			console.log(result.responseText);
		}
		});
	
	get_hotel_cost();
	get_excursion_amount();
	get_transport_cost();
	$('#tab2_head').addClass('done');
	$('#tab_daywise_head').addClass('active');
	$('.bk_tab').removeClass('active');
	$('#tab_daywise').addClass('active');
	$('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);
	}

});
</script>