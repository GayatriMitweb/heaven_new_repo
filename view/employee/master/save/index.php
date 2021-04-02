<?php 
include "../../../../model/model.php";
$login_id = $_SESSION['login_id'];
$role = $_SESSION['role'];
$emp_id = $_SESSION['emp_id'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_POST['branch_status'];
?>
<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document" style="width:1200px!important">
    <div class="modal-content">
      <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <div class="modal-body">
        <section id="sec_ticket_save" name="">	
		  <!-- Nav tabs -->
		  <ul class="nav nav-tabs" role="tablist">
		    <li role="presentation" class="active"><a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab">Personal Information</a></li>
		    <li role="presentation"><a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab">Salary Information</a></li>
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

$('#save_modal').modal('show');
</script>
 
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>