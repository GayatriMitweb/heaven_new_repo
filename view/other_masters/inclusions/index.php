<?php

include "../../../model/model.php";

?>

<div class="row text-right mg_tp_20">

	<div class="col-md-12">
		<button class="btn btn-info btn-sm ico_left" onclick="display_modal()" id="btn_display_modal"><i class="fa fa-eye"></i>&nbsp;&nbsp;View</button>
		<button class="btn btn-info btn-sm ico_left" onclick="save_modal()" id="btn_save_modal"><i class="fa fa-plus"></i>&nbsp;&nbsp;Inclusion/Exclusion</button>
	</div>

</div>



<div id="div_modal"></div>
<div id="div_modal_d"></div>
<div id="div_list"></div>

<script>
function display_modal()
{
	$('#btn_display_modal').button('loading');

	$.post('inclusions/display_modal.php', {}, function(data){

		$('#btn_display_modal').button('reset');

		$('#div_modal_d').html(data);

	});

}
function save_modal()

{

	$('#btn_save_modal').button('loading');

	$.post('inclusions/save_modal.php', {}, function(data){

		$('#btn_save_modal').button('reset');

		$('#div_modal').html(data);

	});

}

function list_reflect()

{

	$.post('inclusions/list_reflect.php', {}, function(data){

		$('#div_list').html(data);

	});

}

list_reflect();

function update_modal(inclusion_id)

{

	$.post('inclusions/update_modal.php', { inclusion_id : inclusion_id }, function(data){

		$('#div_modal').html(data);

	});

}

</script>