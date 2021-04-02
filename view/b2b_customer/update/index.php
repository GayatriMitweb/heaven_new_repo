<?php 
include "../../../model/model.php";
global $secret_key, $encrypt_decrypt;
$register_id = $_POST['register_id'];
$sq_query = mysql_fetch_assoc(mysql_query("select * from b2b_registration where register_id='$register_id'"));
$username = $encrypt_decrypt->fnDecrypt($sq_query['username'], $secret_key);
$password = $encrypt_decrypt->fnDecrypt($sq_query['password'], $secret_key);
?>
<div class="modal fade" id="update_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document" style="width:65%">
    <div class="modal-content">
      <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Update B2B Agent</h4>
	  </div>
      <div class="modal-body" style='padding:10px !important;'>
        <section id="sec_ticket_save" name="">	
		  <!-- Nav tabs -->
		  <ul class="nav nav-tabs" role="tablist">
		    <li role="presentation" class="active"><a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab">Company Information</a></li>
		    <li role="presentation"><a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab">Contact Information</a></li>
		  </ul>
		  
		  <!-- Tab panes -->
		  <div class="tab-content col_pad">
		    <div role="tabpanel" class="tab-pane active" id="tab1">
		    	<?php  include_once('tab1.php'); ?>
		    </div>
		    <div role="tabpanel" class="tab-pane" id="tab2">
		    	<?php  include_once('tab2.php'); ?>
		    </div>
		  </div>
		</section>
      </div>  
    </div>
  </div>
</div>


<script>
$('#update_modal').modal('show');
</script>
 
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>