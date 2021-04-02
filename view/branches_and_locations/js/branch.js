function branches_list_reflect(location_id='')
{
	$.post('branches/branches_list_reflect.php', { location_id : location_id }, function(data){
		$('#branch_list_div').html(data);
	});
}
branches_list_reflect();

function branch_edit_modal(branch_id)
{
	$.post('branches/branch_edit_modal.php', { branch_id : branch_id }, function(data){
		$('#div_branch_edit_modal').html(data);
	});
}

