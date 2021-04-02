<?php 
include "../../model.php";
$newurl = $_POST['newurl'];
?>
  <div class="modal fade" id="single_img_modal"  role="dialog" style="background: rgba(0, 0, 0, 0.64);" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">    
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <div class="modal-content">
          <img src="<?php echo $newurl; ?>" class="img-responsive">
      </div>
    </div>
  </div>
  <Script>
  	$('#single_img_modal').modal('show');
  </Script>