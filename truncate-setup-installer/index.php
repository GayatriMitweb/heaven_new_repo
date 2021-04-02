<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Truncate setup installer</title>
	
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">

	<script src="assets/js/jquery-3.1.1.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/jquery.validate.min.js"></script>

</head>
<body>
<br>
<form id="frm_truncate_setup_installer" name="frm_truncate_setup_installer">

<div class="container">
	<div class="alert alert-danger" role="alert">
	Note : The truncate feature is use to delete all the dummy / original entries from the system. So, use this feature only when it is applicable. iTours will not responsible for the data once it is truncated. You need to make sure that the backup file is downloaded from Support module.
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">Truncate setup installer</div>	
		<div class="panel-body">

			<div class="row">
				<div class="col-md-2 text-right">
					<label for="">Database Name</label>
				</div>
				<div class="col-md-4">
					<input type="text" id="database_name" name="database_name" placeholder="Database Name" class="form-control">
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-2 text-right">
					<label for="">Username</label>
				</div>
				<div class="col-md-4">
					<input type="text" id="username" name="username" placeholder="Username" class="form-control">
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-2 text-right">
					<label for="">Password</label>
				</div>
				<div class="col-md-4">
					<input type="text" id="password" name="password" placeholder="Password" class="form-control">
				</div>
			</div>
			<br>
			<div class="row text-center">
				<div class="col-md-6">
					<button class="btn btn-success">Truncate Setup</button>
				</div>
			</div>

		</div>
	</div>	
</div>

</form>


<script>
$(function(){
	$('#frm_truncate_setup_installer').validate({
		rules:{
			product_link : { required: true },
			database_name : { required: true },
			username : { required: true },
			//password : { required: true },
		},
		submitHandler:function(form){
			var database_name = $('#database_name').val();
			var username = $('#username').val();
			var password = $('#password').val();

			var $btn = $('button').button('loading');

			$.ajax({
				type:'post',
				url:'installer/installer.php',
				data:{ database_name : database_name, username : username, password : password },
				success:function(result){
					$('button').button('reset');
					alert(result);
					window.loaction.reload();
				},
				error:function(result){
					console.log(result.responseText);
				}
			});
		}
	});
});
</script>


</body>
</html>