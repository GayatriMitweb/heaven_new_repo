<?php
include "../../../../model/model.php";
/*======******Header******=======*/
require_once('../../../layouts/admin_header.php');
?>

<div class="app_panel">
  <div class="app_panel_head">
      <h2 class="pull-left">Quotation Details</h2>
      <div class="pull-right header_btn">
        <button data-target="#quotation_hints_modal" data-toggle="modal">
          <a title="Help">
            <i class="fa fa-question" aria-hidden="true"></i>
          </a>
        </button>
      </div>
      <div class="pull-right header_btn">
        <button title="Help">
          <a href="http://itourscloud.com/User-Manual/" target="_blank" title="Manual">
            <i class="fa fa-info" aria-hidden="true"></i>
          </a>
        </button>
      </div>
  </div>
  <div class="header_bottom">
    <div class="row">
        <div class="col-md-12 text-center">  
            <label for="rd_car_tour" class="app_dual_button active">
                <input type="radio" id="rd_car_tour" name="app_id_proof" checked onchange="content_show()">
                &nbsp;&nbsp;Car Rental
            </label>   
            <label for="rd_flight_tour" class="app_dual_button ">
                <input type="radio" id="rd_flight_tour" name="app_id_proof"  onchange="content_show()" >
                &nbsp;&nbsp;Flight
            </label>   
        </div>
    </div>
  </div>
  <!--=======Header panel end======-->
  
<div class="app_panel_content">
    <div class="row">
        <div class="col-md-12">
            <div id="div_id_proof_content"></div>
        </div>
    </div>
</div>
    



<?= end_panel() ?>

<script>
function content_show()
{
    var id = $('input[name="app_id_proof"]').attr('id');

    if($("#rd_car_tour").is(':checked')){
        $.post('car_rental/index.php', {}, function(data){
            $('#div_id_proof_content').html(data);
        });
    }
    if($("#rd_flight_tour").is(':checked')){
        $.post('flight/index.php', {}, function(data){
            $('#div_id_proof_content').html(data);
        });
    }    
}
content_show();
</script>
<?php
/*======******Footer******=======*/
require_once('../../../layouts/admin_footer.php'); 
?>