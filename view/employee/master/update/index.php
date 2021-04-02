<?php
include "../../../../model/model.php";
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];
$emp_id = $_POST['emp_id'];

$emp_info = mysql_fetch_assoc(mysql_query("select * from emp_master where emp_id='$emp_id'"));
$username = $encrypt_decrypt->fnDecrypt($emp_info['username'], $secret_key);
$password = $encrypt_decrypt->fnDecrypt($emp_info['password'], $secret_key);
?>
<div class="modal fade" id="update_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document" style="width:65%">
    <div class="modal-content">
      <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <div class="modal-body">
      	<section id="sec_ticket_save" name="">
		  <!-- Nav tabs -->
		  <ul class="nav nav-tabs" role="tablist">
		    <li role="presentation" class="active"><a href="#tab1u" aria-controls="tab1u" role="tab" data-toggle="tab">Personal Information</a></li>
			<li role="presentation"><a href="#tab2u" aria-controls="tab2u" role="tab" data-toggle="tab">Salary Information</a></li>
		  </ul>

		  <!-- Tab panes -->
		  <div class="tab-content col_pad">
		    <div role="tabpanel" class="tab-pane active" id="tab1u">
		    	<?php  include_once('tab1.php'); ?>
		    </div>
		    <div role="tabpanel" class="tab-pane" id="tab2u">
		    	<?php  include_once('tab2.php'); ?>
		    </div>
		  </div>
		</section>
      </div> 
	  </div> 
    </div>
  </div>
</div>


<script>
	$('#update_modal').modal('show');
</script>
 
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>