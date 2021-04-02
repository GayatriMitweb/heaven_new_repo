<form id="frm_upcoming_tour_offser_save" class="no-marg">
<div class="modal fade" id="upcoming_tours_save_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">New Upcoming Offer</h4>
      </div>
      <div class="modal-body text-center">
          
          <div class="row">
            <div class="col-md-6 mg_bt_10">
              <input type="text" class="form-control" id="txt_tour_offer_title"  onchange="validate_spaces(this.id);fname_validate(this.id);" name="txt_tour_offer_title" placeholder="*Tour Offer Title" title="Tour Offer Title" />    
            </div>
            <div class="col-md-6 mg_bt_10">
              <input type="text" class="form-control" id="txt_tour_offer_valid_date" name="txt_tour_offer_valid_date" placeholder="*Valid Date" title="Valid Date" value="<?= date('d-m-Y')?>"/>    
            </div>
            <div class="col-md-12 mg_bt_10">
              <textarea  class="form-control"  onchange="validate_spaces(this.id); validate_limit(this.id);" id="txt_tour_offer_description" name="txt_tour_offer_description" title="Tour Offer Description" placeholder="*Tour Offer Description" ></textarea>    
            </div>
          </div>
          <div class="row text-center"> 
            <div class="col-md-12">
              <button class="btn btn-sm btn-success" id="btn_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
            </div>
          </div>

      </div>      
    </div>
  </div>
</div>
</form>