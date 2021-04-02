<?php 
include "../../../../../model/model.php";

$booking_id = $_POST['booking_id'];
$sql_booking_date = mysql_fetch_assoc(mysql_query("select * from forex_booking_master where booking_id = '$booking_id'")) ;
$booking_date = $sql_booking_date['created_at'];
$yr = explode("-", $booking_date);
$year =$yr[0];
?>
<div class="modal fade profile_box_modal" id="visa_display_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Booking Information(<?= get_forex_booking_id($booking_id,$year) ?>)</h4>
      </div>
      <div class="modal-body profile_box_padding">
	     <div class="row">    
		  	<div class="col-xs-12">
		  		<div class="profile_box">
		          <h3 class="editor_title">Document Information</h3>
              <div class="panel panel-default panel-body app_panel_style">
                <?php $sq_booking = mysql_fetch_assoc(mysql_query("select * from forex_booking_master where booking_id='$booking_id'")); ?>
                <span class="main_block">
                  <ul style="padding: 0px; margin: 0px; font-weight: 500;">
                    <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
                  Mandatory Documents
                  <ol style="font-weight: 300;padding: 0px;margin-left: 15px">
                    <i class="fa fa-circle-o" aria-hidden="true" style="font-size: 8px; width: 10px;"></i>
                  <?= ($sq_booking['manadatory_docs']=="" ? 'NA' :$sq_booking['manadatory_docs']) ; ?>
                  </ol>
                  </ul>  
              </span> 
              <span class="main_block">
                  <ul style="padding: 0px; margin: 0px; font-weight: 500;">
                    <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
                  Photo Proof Given
                  <ol style="font-weight: 300;padding: 0px;margin-left: 15px">
                    <i class="fa fa-circle-o" aria-hidden="true" style="font-size: 8px; width: 10px;"></i>
                  <?php echo ($sq_booking['photo_proof_given']=="" ? 'NA' :$sq_booking['photo_proof_given']) ;?>
                  </ol>
                  </ul>  
              </span>
              <span class="main_block">
                  <ul style="padding: 0px; margin: 0px; font-weight: 500;">
                    <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
                  Residence Proof
                  <ol style="font-weight: 300;padding: 0px;margin-left: 15px">
                    <i class="fa fa-circle-o" aria-hidden="true" style="font-size: 8px; width: 10px;"></i>
                  <?php echo ($sq_booking['residence_proof']=="" ? 'NA' :$sq_booking['residence_proof'])?>
                  </ol>
                  </ul>  
              </span>
              </div>     
		      </div>  
		    </div>
		</div>	

</div>

</div>
</div>
</div>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script>
$('#visa_display_modal').modal('show');
</script>