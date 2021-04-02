<?php

include "../../../model/model.php";

?>

<div class="row text-right mg_tp_20 mg_bt_20">	

	<div class="col-md-12">

		<button class="btn btn-info btn-sm ico_left" onclick="save_modal()" id="btn_save_modal"><i class="fa fa-plus"></i>&nbsp;&nbsp;Image</button>

	</div>

</div>



<div class="app_panel_content Filter-panel">

	<div class="row">

		<div class="text-left col-md-3 col-sm-6">

			<select id="dest_id"  name="dest_name" title="Select Destination" class="form-control" onchange="list_reflect(this.value)" style="width:100%"> 

	            <option value="">Destination</option>

	             <?php 

	             $sq_query = mysql_query("select * from destination_master where status != 'Inactive'"); 

	             while($row_dest = mysql_fetch_assoc($sq_query)){ ?>

	                <option value="<?php echo $row_dest['dest_id']; ?>"><?php echo $row_dest['dest_name']; ?></option>

	                <?php } ?>

	         </select>

		</div>

	</div>

</div>



<div id="div_modal"></div>



<div class="main_block">	

	<div class="panel panel-default panel-body mg_tp_20">

		<div class="row"> 

			<div class="col-md-12 no-pad">

		    	<div id="div_list" class="loader_parent"></div>

			</div>

		</div>

	</div>

	

</div>



<div id="div_modal1"></div>

<script>

$('#dest_id').select2();

function save_modal()

{

	$('#btn_save_modal').button('loading');

	$.post('gallery/save_modal.php', {}, function(data){

		$('#btn_save_modal').button('reset');

		$('#div_modal').html(data);

	});

}



function list_reflect()

{
	$('#div_list').append('<div class="loader"></div>');
	var dest_id = $('#dest_id').val();

	$.post('gallery/list_reflect.php', {dest_id : dest_id }, function(data){

		$('#div_list').html(data);

	});

}

//list_reflect();

function display_image(entry_id)

{

	$.post('gallery/display_image_modal.php', {entry_id : entry_id}, function(data){

		$('#div_modal').html(data);

	});

}

function update_modal(entry_id)

{

	$.post('gallery/update_modal.php', { entry_id : entry_id }, function(data){

		$('#div_modal1').html(data);

	});

}

function delete_image(image_id)
{
    var base_url = $("#base_url").val();
    $.ajax({
          type:'post',
          url: base_url+'controller/other_masters/gallary/delete_dest_image.php',
          data:{ image_id : image_id },
          success:function(result)
          {
            msg_alert(result);
            list_reflect();
          }
  });    

}
</script>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>