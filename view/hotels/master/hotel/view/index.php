<?php 
include "../../../../../model/model.php";
global $encrypt_decrypt, $secret_key;
$hotel_id = $_POST['hotel_id'];
$sq_hotel = mysql_fetch_assoc(mysql_query("select * from hotel_master where hotel_id='$hotel_id'"));
$mobile_no = $encrypt_decrypt->fnDecrypt($sq_hotel['mobile_no'], $secret_key);
$email_id = $encrypt_decrypt->fnDecrypt($sq_hotel['email_id'], $secret_key);
$email_id1 = $encrypt_decrypt->fnDecrypt($sq_hotel['alternative_email_1'], $secret_key);
$email_id2 = $encrypt_decrypt->fnDecrypt($sq_hotel['alternative_email_2'], $secret_key);
?>

<div class="modal fade profile_box_modal" id="hotel_view_modal" role="dialog" aria-labelledby="myModalLabel">

  <div class="modal-dialog modal-lg" role="document">

    <div class="modal-content">

      <div class="modal-body profile_box_padding">

      	

      	<div>

			  <!-- Nav tabs -->

			  <ul class="nav nav-tabs responsive" role="tablist">

			    <li role="presentation" class="active"><a href="#basic_information" aria-controls="home" role="tab" data-toggle="tab" class="tab_name">Hotel Supplier Information</a></li>

			    <li role="presentation"><a href="#hotel_images" aria-controls="profile" role="tab" data-toggle="tab" class="tab_name">Hotel Images</a></li>
			    <li class="pull-right"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></li>


			  </ul>



				  <!-- Tab panes1 -->

				  <div class="tab-content responsive">



				    <!-- *****TAb1 start -->

				    <div role="tabpanel" class="tab-pane active no-pad-sm" id="basic_information">
				     <?php include "view_modal.php"; ?>
				    </div>

				    <!-- ********Tab1 End******** --> 

	                   

	                <!-- ***Tab2 Start*** -->

				    <div role="tabpanel" class="tab-pane no-pad-sm" id="hotel_images">
				     <div class="panel panel-default panel-body fieldset profile_background no-pad-sm">
				       <?php include "tab2.php"; ?>
					 </div>
				    </div>

	                <!-- ***Tab2 End*** -->

				  </div>

        </div>

        

	   </div>

     

      </div>

    </div>

  

</div>

<script>
$('#hotel_view_modal').modal('show');
$('#hotel_view_modal').on('shown.bs.modal', function () {
	fakewaffle.responsiveTabs(['xs', 'sm']);
});
</script>

<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>


 

