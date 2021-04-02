<?php
include "../../../model/model.php";
$sq_settings = mysql_fetch_assoc(mysql_query("select * from app_settings"));
?>
<form id="frm_cred_info">
<div class="row mg_tp_20 mg_bt_20 text-right">
	<div class="col-xs-12">
		<button type="button" class="btn btn-sm btn-success ico_left" data-toggle="modal" data-target="#c_view_modal" id="btn_view">&nbsp;&nbsp;View<i class="fa fa-eye"></i></button>
	</div>
</div>
<div class="panel panel-default panel-body app_panel_style feildset-panel mg_bt_30">
	<legend>Mailing Details</legend>
	<div class="row mg_tp_20 mg_bt_20">
		<div class="col-md-2 text-right"><label for="app_smtp_status">SMTP Status</label></div>
		<div class="col-md-4">
			<select id="app_smtp_status" name="app_smtp_status" title="SMTP Status">
				<?php if($sq_settings['app_smtp_status']!=""){ ?>
				<option value="<?= $sq_settings['app_smtp_status'] ?>"><?= $sq_settings['app_smtp_status'] ?></option>
				<?php } ?>
				<option value="No">No</option>
				<option value="Yes">Yes</option>
			</select>
			<small>Note : Pls select whether do you want smtp mailing</small>
		</div>
		<div class="col-md-2 text-right"><label for="app_smtp_host">SMTP Host</label></div>
		<div class="col-md-4">
			<input type="text" id="app_smtp_host" onchange="fname_validate(this.id)" name="app_smtp_host" placeholder="SMTP Host" title="SMTP Host" value="<?= $sq_settings['app_smtp_host'] ?>">
			<small>Note : Pls enter smtp host name Ex. mail.itourscloud.com</small>
		</div>
	</div>

	<div class="row mg_bt_20">
		<div class="col-md-2 text-right"><label for="app_smtp_port">SMTP Port</label></div>
		<div class="col-md-4">
			<input type="text" onchange="validate_alphanumeric(this.id);" id="app_smtp_port" name="app_smtp_port" placeholder="SMTP Port" title="SMTP Port" value="<?= $sq_settings['app_smtp_port'] ?>">
			<small>Note : Pls enter smtp port name Ex. 587</small>
		</div>
		<div class="col-md-2 text-right"><label for="app_smtp_password">SMTP Password</label></div>
		<div class="col-md-4">
			<input type="password" id="app_smtp_password" name="app_smtp_password" class="form-control" placeholder="SMTP Password" title="SMTP Password" value="<?= $sq_settings['app_smtp_password'] ?>">
			<small>Note : Pls enter smtp password</small>
		</div>
	</div>

	<div class="row mg_bt_20">
		<div class="col-md-2 text-right"><label for="app_smtp_method">SMTP Method</label></div>
		<div class="col-md-4">
			<input type="text" id="app_smtp_method" onchange="fname_validate(this.id);" name="app_smtp_method" placeholder="SMTP Method" title="SMTP Method" value="<?= $sq_settings['app_smtp_method'] ?>">
			<small>Note : Pls enter smtp method name Ex. SSL</small>
		</div>
		<div class="col-md-2 text-right"><label for="app_email_id">Email ID</label></div>
				<div class="col-md-4">
					<input type="text" id="app_email_id" name="app_email_id" placeholder="Email ID" title="Email ID" value='<?= $sq_settings['app_email_id'] ?>' onchange="validate_email(this.id)">
					<small>Note : Pls enter webmail Email ID. eg. info@example.com</small>

				</div>
		</div>
</div>

<div class="panel panel-default panel-body app_panel_style feildset-panel mg_bt_30">
	<legend>SMS Details</legend>
	<div class="row mg_tp_20 mg_bt_20">
		<div class="col-md-2 text-right"><label for="sms_username">SMS API Username</label></div>
		<div class="col-md-4">
			<input type="text" id="sms_username" name="sms_username" placeholder="SMS API Username" title="SMS API Username" value="<?= $sq_settings['sms_username'] ?>">
		</div>
		<div class="col-md-2 text-right"><label for="sms_password">SMS API Password</label></div>
		<div class="col-md-3">
			<input type="password" id="sms_password" name="sms_password" class="form-control" placeholder="SMS API Password" title="SMS API Password" value="<?= $sq_settings['sms_password'] ?>">
		</div>
		<div class="col-md-1">
			<a onclick="show_password('sms_password')" target="_BLANK" class="btn btn-info btn-sm" title="View Password" style="background-color: #009898;"><i class="fa fa-eye"></i></a>
		</div>
	</div>
</div>

<div class="panel panel-default panel-body app_panel_style feildset-panel mg_bt_30">
	<legend>Change Password</legend>
	<div class="row mg_tp_20 mg_bt_20">
		<div class="col-md-2 text-right"><label for="current_password">Current Password</label></div>
		<?php 
		$sq_password = mysql_fetch_assoc(mysql_query("select * from roles where emp_id='0'"));
		$password = $encrypt_decrypt->fnDecrypt($sq_password['password'], $secret_key); ?>
		<div class="col-md-4">
			<input type="password" id="current_password" name="current_password" onchange="validate_password(this.id)" class="form-control" placeholder="Current password" title="Current password" value="<?= $password ?>">
		</div>
			<a onclick="show_password('current_password')" target="_BLANK" class="btn btn-sm app_btn" title="View Password"><i class="fa fa-eye"></i></a>
			<a id="forgot_password" href="<?= BASE_URL?>model/app_settings/send_admin_password.php?app_email_id=<?=$sq_settings['app_email_id']?>" onclick="return yes_js_login('<?=$sq_settings['app_email_id']?>');"><u>Forgot Password?</u></a>
		
	</div>
	<div class="row mg_bt_20">
		<div class="col-md-2 text-right"><label for="new_password">New password</label></div>
		<div class="col-md-4">
			<input type="password" class='form-control' id="new_password" onchange="validate_password(this.id)" placeholder="New password" title="New password">
		</div>
		<div class="col-md-2 text-right"><label for="re_password">Confirm password</label></div>
		<div class="col-md-4">
			<input type="password" class='form-control' id="re_password" onchange="validate_password(this.id)" placeholder="Confirm password" title="Confirm password">
		</div>
	</div>
</div>

<div class="panel panel-default panel-body app_panel_style feildset-panel mg_bt_30">
	<legend>IP Address Authentication</legend>
	<div class="row mg_tp_20 mg_bt_20">
		<div class="col-md-2 text-right"><label for="ip_address">IP Addresses</label></div>
		<div class="col-md-5">
			<input name="ip_address" class="form-control" onchange="ValidateIPaddress(this.id);" title="Enter Ip Addresses" id="ip_address" data-role="tagsinput" value="<?= $sq_settings['ip_addresses'] ?>"/>
		</div>
		<div class="col-md-5 no-pad"><h6 style="color:red;">Note : Use this IP address field only when you don't want to enable login for outside IP addresses.(e.g-192.168.2.1). If not so then keep this field blank</h6></div>
	</div>
</div>

<div class="row text-center mg_tp_20">
	<div class="col-md-12">
		<button class="btn btn-info btn-sm ico_left" type="button" onclick="run_reminders()"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Run Reminders</button>&nbsp;&nbsp;
		<button class="btn btn-sm btn-success"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
	</div>
</div>

</form>

<div class="modal fade profile_box_modal" id="c_view_modal" role="dialog" aria-labelledby="myModalLabel">

  <div class="modal-dialog modal-lg" role="document">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">View Format</h4>
      </div>

      <div class="modal-body profile_box_padding">
      	<?php
      	 $newUrl1 = BASE_URL.'images/cred_info.jpg'; 
      	?>
      	<img src="<?= $newUrl1 ?>" class="img-responsive"/>

      	<div>
      	</div>
      </div>
  </div>
</div>
</div>

<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>

<script type="text/javascript">
$("#ip_address").tagsinput('items');
var global_valid = true;
$('#ip_address').on('change', function(){
	global_valid = ValidateIPaddress($(this).attr('id'));
});

yes_js_login = function(app_email_id){
	
	var base_url = $('#base_url').val();
	$('#forgot_password').button('loading');
	$.ajax({
		type:'post',
		url:base_url+'model/app_settings/send_admin_password.php',
		data:{ app_email_id : app_email_id },
		success:function(result){
			msg_alert(result);
			$('#forgot_password').button('reset');
		}
	});
     return false;
}
function run_reminders(){

	var status = confirm('Do you want to run reminders?');

	if(status){

		var url = '<?= BASE_URL ?>view/layouts/reminders_home.php'

		window.open(url, '_blank', 'toolbar=0,location=0,menubar=0');

	}	

}

$(function(){

	$('#frm_cred_info').validate({

		rules:{
			app_email_id: { required	: true},
		},

		submitHandler:function(form){

			var sms_username = $('#sms_username').val();
			var sms_password = $('#sms_password').val();
			var app_smtp_status = $('#app_smtp_status').val();
			var app_smtp_host = $('#app_smtp_host').val();
			var app_smtp_port = $('#app_smtp_port').val();
			var app_smtp_password = $('#app_smtp_password').val();
			var app_smtp_method = $('#app_smtp_method').val();
			var current_password = $('#current_password').val();
			var new_password = $('#new_password').val();
			var re_password = $('#re_password').val();
			var ip_address = $('#ip_address').val();
			var app_email_id = $('#app_email_id').val();

			var base_url = $('#base_url').val();

			if(new_password!=''){

				if(re_password==''){

					alert("Retype New password");

					return false;	

				}

			}

			if (new_password!=re_password) {
				error_msg_alert('Both Current password and Confirm password should be same! ');
				return false;
			}
			if($('#frm_cred_info').valid()  && global_valid){
			$('#vi_confirm_box').vi_confirm_box({

			    callback: function(data1){

				if(data1=="yes"){

					$.ajax({

					type:'post',

					url:base_url+'controller/app_settings/setting/app_cred_info_save.php',

					data:{ sms_username : sms_username, sms_password : sms_password, app_email_id : app_email_id, app_smtp_status : app_smtp_status, app_smtp_host : app_smtp_host, app_smtp_port : app_smtp_port, app_smtp_password : app_smtp_password, app_smtp_method : app_smtp_method,current_password : current_password,new_password : new_password,re_password : re_password,ip_address:ip_address },

					success:function(result){
						update_b2c_cache();
						msg_popup_reload(result);

					}

					});

				}

			      }

			});	
			}


			return false;			

		}

	});

});



</script>