<?php 
 include "../../../model/model.php";
?>

<div class="modal fade profile_box_modal" id="view_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    	<div class="mg_bt_20">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    <div class="modal-body profile_box_padding">
	  	<div>
	  		<img class="img-responsive" src="<?php echo BASE_URL ?>images/templates/email-template.jpg">
	    </div>
    </div>
	</div>
  </div>
</div>

<script>
$('#view_modal').modal('show');
</script>

<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>

<script>
  $('#view_modal').modal('show');
</script>  

 

