function package_tour_checklist_reflect()
{
	var booking_id = $('#booking_id').val();

	$.post('package_tour/checklist_reflect.php', { booking_id : booking_id }, function(data){
		$('#div_checklist_reflect').html(data);
	});
}

function package_tour_checklist_save()
{
	var booking_id = $('#booking_id').val();
	var branch_admin_id = $('#branch_admin_id1').val();

	var entity_id_arr = new Array();

	$('input[name="chk_package_tour_checklist"]:checked').each(function(){

		var entity_id = $(this).attr('data-entity-id');
		entity_id_arr.push(entity_id);

	});
	
	if(entity_id_arr.length == 0){ error_msg_alert('Atleast select one entity'); return false; }
	var base_url = $('#base_url').val();

	$.ajax({
		type:'post',
		url: base_url+'controller/checklist/package_tour/package_tour_checklist_save.php', 
		data:{ booking_id : booking_id, entity_id_arr : entity_id_arr , branch_admin_id : branch_admin_id},
		success:function(result){
			msg_alert(result);
			package_tour_checklist_reflect();
		}
	});
}