<?php 
include "../../../../model/model.php";

$emp_id = $_POST['emp_id'];
$query = "select * from emp_master where emp_id='$emp_id'";

?>
<div class="modal fade profile_box_modal" id="display_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
  	
    <div class="modal-content">
      <div class="modal-body profile_box_padding">
      	
      	<div>
			  <!-- Nav tabs -->
			  <ul class="nav nav-tabs" role="tablist">
			    <li role="presentation" class="active"><a href="#basic_information" aria-controls="home" role="tab" data-toggle="tab" class="tab_name">Personal Information</a></li>
			    <li role="presentation"><a href="#salary_information" aria-controls="profile" role="tab" data-toggle="tab" class="tab_name">Salary Information</a></li>
			    <li class="pull-right"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></li>
			  </ul>

				<div class="panel panel-default panel-body fieldset profile_background">
					<!-- Tab panes1 -->
					<div class="tab-content">
						<!-- *****TAb1 start -->
						<div role="tabpanel" class="tab-pane active" id="basic_information">
						<?php include "tab1.php"; ?>
						</div>
						<!-- ********Tab1 End******** --> 
						<!-- ***Tab2 Start*** -->
						<div role="tabpanel" class="tab-pane" id="salary_information">
						<?php include "tab2.php"; ?>
						</div>
						<!-- ***Tab2 End*** -->
					</div>
				</div>

        </div>
        
	   </div>
     
      </div>
    </div>
  
</div>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script>
$('#display_modal').modal('show');
</script>