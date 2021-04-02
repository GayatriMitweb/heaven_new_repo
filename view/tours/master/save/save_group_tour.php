<?php 
include "../../../../model/model.php";
?>
<div class="modal fade" id="save_modal1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Group Tour</h4>
      </div>
      <div class="modal-body">

        <section id="sec_ticket_save" name="frm_ticket_save">

            <div>

              <!-- Nav tabs -->
              <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab">Tour</a></li>
                <li role="presentation"><a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab">Travelling</a></li>
                <li role="presentation"><a href="#tab3" aria-controls="tab3" role="tab" data-toggle="tab">Daywise Images</a></li>
                <li role="presentation"><a href="#tab4" aria-controls="tab4" role="tab" data-toggle="tab">Costing</a></li>
              </ul>

              <!-- Tab panes -->
              <div class="tab-content" style="padding:20px 10px;">
                <div role="tabpanel" class="tab-pane active" id="tab1">
                    <?php  include_once('package_tab1.php'); ?>
                </div>
                <div role="tabpanel" class="tab-pane" id="tab2">
                    <?php  include_once('travelling_tab2.php'); ?>
                </div>
                <div role="tabpanel" class="tab-pane" id="tab3">
                    <?php  include_once('dayswise_tab3.php'); ?>
                </div>
                 <div role="tabpanel" class="tab-pane" id="tab4">
                    <?php  include_once('costing_tab4.php'); ?>
                </div>
              </div>
            </div>       
        </section>
      </div>  
    </div>
  </div>
</div>

<script src="../js/master.js"></script>
<script>
$('#save_modal1').modal('show');

$('#airline_name1,#airline_name-1').select2();
$('#train_from_location1,#train_to_location1').select2({minimumInputLength: 1});

$('#plane_from_location1,#plane_to_location1,#train_to_location1,#airline_name1,#plane_from_location-1,#plane_to_location-1,#airline_name-1').select2();

</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>