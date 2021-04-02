<?php
include "../../../model/model.php";
$register_id = $_POST['register_id'];
$query = mysql_fetch_assoc(mysql_query("select * from b2b_registration where register_id = '$register_id'"));
$sq_currency = mysql_fetch_assoc(mysql_query("select * from currency_name_master where id='$query[currency]'"));
$sq_country = mysql_fetch_assoc(mysql_query("select * from country_list_master where country_id='$query[country]'"));
?>
<div class="modal fade profile_box_modal" id="display_modal_tour" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" style="width:60%" role="document">
    <div class="modal-content">
      <div class="modal-body profile_box_padding">
      	
      	<div>
			  <!-- Nav tabs -->
			  <ul class="nav nav-tabs" role="tablist">
			    <li role="presentation" class="active"><a href="#basic_information" aria-controls="home" role="tab" data-toggle="tab" class="tab_name">Company Information</a></li>
			    <li role="presentation"><a href="#contact_information" aria-controls="home" role="tab" data-toggle="tab" class="tab_name">Contact and Deposit Information</a></li>
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
				    <!-- *****TAb2 start -->
				    <div role="tabpanel" class="tab-pane" id="contact_information">
				     <?php include "tab2.php"; ?>
				    </div>
				    <!-- ********Tab2 End******** --> 
	                

				  </div>

			  </div>
        </div>
        
	   </div>
     
      </div>
    </div>
  
</div>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script>
$('#display_modal_tour').modal('show');
</script>