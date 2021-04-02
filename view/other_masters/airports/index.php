<?php include "../../../model/model.php";?>
<div class="row text-right mg_tp_20">
	<div class="col-md-12">
		<button class="btn btn-info btn-sm ico_left" onclick="save_modal()" id="btn_save_modal"><i class="fa fa-plus"></i>&nbsp;&nbsp;Airport</button>
	</div>
</div>
<hr/>

<div id="div_list">
	<!-- <div class="col-md-3 col-md-offset-9 text-right">
		<div class="col-md-9"><input type="text" name="searcha" id="searcha" placeholder="Search...." class="form-control"></div>
		<div class="col-md-1"><button class="btn btn-sm btn-info ico_right" onclick="SearchData(20,0);">Search&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button></div>
	</div> -->
	<div id="div_list_content" class="loader_parent">
		<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
			<table id="airport_table" class="table table-hover" style="margin: 20px 0 !important;">
			</table>
		</div></div></div>
	</div>
</div>
	<div id="div_modal"></div>
<script>
// var action = 'inactive'; //Check if current action is going on or not. If not then inactive otherwise active
var columns = [
          { title: "Airport_Id" },
          { title: "City" },
          { title: "Airport" },
          { title: "Code" },
		  { title: "Status" },
		  { title: "Actions" }
      ];
function list_reflect(){
	$('#div_list_content').append('<div class="loader"></div>');
  $.post('airports/list_reflect.php', {}, function(data){
	setTimeout(() => {
    	pagination_load(data,columns,true, false, 20, 'airport_table');
		$('.loader').remove();
    }, 1000);
  });
}list_reflect();

// function list_reflect(limit , start){
// //   $('#search_ap_table').hide();
// //   $('#tbl_list').show();
// //   $('#tbl_list tbody').append('<div class="loader"></div>');
//   $.post('airports/list_reflect.php', {limit:limit , start:start}, function(data){
// 	  $(".loader").remove();
//       $('#tbl_list tbody').append(data);
//       action = 'inactive';
//   });
// }

// if(action == 'inactive'){
// 	var limit = 20; //The number of records to display per request
// 	var start = 0; //The starting pointer of the data
// 	action = 'active';
// 	list_reflect(limit, start);
// }

// $("div.app_content_wrap").on('scroll' , function(event){
//   if($('#tbl_list').is(":visible")==true){
//     if($("div.app_content_wrap").scrollTop() + $("div.app_content_wrap").height() > $("#tbl_list tbody").height() && action == 'inactive'){
//       action = 'active';
//       start = start + limit;
//       setTimeout(function(){
//         list_reflect(limit, start);
//       }, 0);
//     }
//   }
// });

// function SearchData(limit, start){
// 	var search=$('#searcha').val();
	
// 	$('#search_ap_table').show();
// 	$('#tbl_list').hide();
//     $('#search_ap_table tbody').append('<div class="loader"></div>');
// 	$.post('airports/search_data.php', {limit : limit , start:start, search : search}, function(data){
// 		$(".loader").remove();
// 		$('#search_ap_table tbody').html(data);
// 	});
// }

function save_modal(){
	$('#btn_save_modal').button('loading');
	$.post('airports/save_modal.php', {}, function(data){
		$('#btn_save_modal').button('reset');
		$('#div_modal').html(data);
	});
}

function update_modal(airport_id){
	$.post('airports/update_modal.php', { airport_id : airport_id }, function(data){
		$('#div_modal').html(data);
	});
}
</script>