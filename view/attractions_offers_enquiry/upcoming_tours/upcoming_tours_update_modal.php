<?php 
include "../../../model/model.php";
$offer_id = $_POST['offer_id'];
$sq_offer = mysql_fetch_assoc(mysql_query("select * from upcoming_tour_offers_master where offer_id='$offer_id'"));
?>
<form id="frm_upcoming_tour_offser_update">
<input type="hidden" id="offer_id" name="offer_id" value="<?= $offer_id ?>">

<div class="modal fade" id="upcoming_tours_update_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Upcoming Offer</h4>
      </div>
      <div class="modal-body text-center">
          
          <div class="row">
            <div class="col-md-6 mg_bt_10">
              <input type="text" class="form-control"  onchange="validate_spaces(this.id);fname_validate(this.id);" id="txt_tour_offer_title1" name="txt_tour_offer_title1" placeholder="Tour Offer Title" title="Tour Offer Title" value="<?= $sq_offer['title'] ?>"/>    
            </div>
            <div class="col-md-6 mg_bt_10">
              <input type="text" class="form-control" id="txt_tour_offer_valid_date1" name="txt_tour_offer_valid_date1" placeholder="*Valid Date" title="Valid Date" value="<?= date("d-m-Y", strtotime($sq_offer['valid_date'])) ?>"/>    
            </div>
            <div class="col-md-12 mg_bt_10">
              <textarea  class="form-control"  onchange="validate_spaces(this.id);validate_limit(this.id);" id="txt_tour_offer_description1" name="txt_tour_offer_description1" placeholder="Tour Offer Description" ><?= $sq_offer['description'] ?></textarea>    
            </div>
          </div>
          <div class="row text-center"> 
            <div class="col-md-12">
              <button class="btn btn-sm btn-success"><i class="fa fa-pencil-square-o"></i>&nbsp;&nbsp;Update</button>
            </div>
          </div>

      </div>      
    </div>
  </div>
</div>
</form>

<script>
  $('#upcoming_tours_update_modal').modal('show');
  jQuery('#txt_tour_offer_valid_date1').datetimepicker({ timepicker:false, format:'d-m-Y' });

  $(function(){

  $('#frm_upcoming_tour_offser_update').validate({
    rules:{
        txt_tour_offer_title1 : { required:true },
        txt_tour_offer_description1 : { required:true },
        txt_tour_offer_valid_date1 : { required:true },
    },
    submitHandler:function(form){
        var base_url = $("#base_url").val();
        var offer_id = $("#offer_id").val();
        var title = $("#txt_tour_offer_title1").val();
        var description = $("#txt_tour_offer_description1").val();
        var valid_date = $("#txt_tour_offer_valid_date1").val();


        $.post( 
               base_url+"controller/attractions_offers_enquiry/upcoming_tour_offers_master_update.php",
               {  offer_id : offer_id,title : title, description : description, valid_date : valid_date },
               function(data) {  
                  msg_alert(data);
                  $('#upcoming_tours_update_modal').modal('hide');
                  upcoming_tour_offsers_list_reflect();
               });
    }
  });

});
</script>