<form id="frm_location_save">
<div class="modal fade" id="location_save_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Location</h4>
      </div>
      <div class="modal-body">
        
          <div class="row">
            <div class="col-sm-6 col-sm-offset-3 mg_bt_10">
              <input type="text" id="location_name" name="location_name" onchange="locationname_validate(this.id);" placeholder="*Location i.e Pune" title="Location Name">
            </div>
            <div class="col-sm-6 hidden">
              <select name="active_flag" id="active_flag" title="Status">
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
              </select>
            </div>            
          </div>  
          <div class="row text-center mg_tp_30">
            <div class="col-md-12">
              <button class="btn btn-sm btn-success" id="location_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>            
            </div>
          </div>        
      </div>      
    </div>
  </div>
</div>
</form>
