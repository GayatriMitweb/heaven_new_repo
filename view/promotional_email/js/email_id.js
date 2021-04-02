function email_id_edit_modal(email_id_id){

	$.post('email_id/email_id_edit_modal.php', { email_id_id : email_id_id }, function(data){
		$('#div_mobile_no_edit_content').html(data);
	});

}