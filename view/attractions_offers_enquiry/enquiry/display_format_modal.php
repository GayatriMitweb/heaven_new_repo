<?php 
include "../../../model/model.php";
$base_url = $_POST['base_url'];
?>
<script>
 $('#csv_upload_format_view_modal').modal('show');
</script>
<!-- CSV Fromat sample image  -->
<div class="modal fade" id="csv_upload_format_view_modal" role="dialog" aria-labelledby="myModalLabel"><div class="modal-dialog modal-lg" style="width: 100%" role="document"><div class="modal-content">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <img src="<?= $base_url ?>images/CSV_enquiry_import_format.PNG" class="img-responsive" alt="">
</div></div></div>
<!-- -->