<?php
include "../../../model/model.php";

$entry_id = $_POST['entry_id'];

$sq_gallary =  mysql_fetch_assoc(mysql_query("select * from gallary_master where entry_id = '$entry_id'"));
$sq_dest =  mysql_fetch_assoc(mysql_query("select * from destination_master where dest_id = '$sq_gallary[dest_id]'"));
?>
<form id="frm_update">
<div class="modal fade" id="update_desc_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Description</h4>
      </div>
      <div class="modal-body"> 
      <input type="hidden" name="entry_id" id="entry_id" value="<?php echo $entry_id; ?>">
      <div class="row mg_bt_10">  
        <div class="col-md-4 col-sm-6">
          <input type="text" value="<?php echo $sq_dest['dest_name'];?>"readonly/>   
        </div>
      </div>
      <div class="row mg_bt_10">  
        <div class="col-md-12"> 
            <textarea id="description1" name="description1" placeholder="Description" rows="4" title="Description"><?php echo $sq_gallary['description']; ?></textarea>
        </div>
      </div>
        <div class="row mg_tp_20 text-center">
            <div class="col-md-12">
                <button class="btn btn-sm btn-success" id="btn_update"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>
            </div>
        </div>
        
      </div>
    </div>
  </div>
</div>

</form>

<script>
$('#update_desc_modal').modal('show');

$('#frm_update').validate({
    rules:{
      description1 : { maxlength : 100, required : true}
    },
    submitHandler:function(form){

        var description = $('#description1').val();
        var entry_id = $('#entry_id').val();
        

        $('#btn_update').button('loading');

        $.ajax({
          type:'post',
          url:base_url()+'controller/other_masters/gallary/gallary_img_update.php',
          data:{ entry_id : entry_id,description : description },
          success:function(result){
              $('#btn_update').button('reset');
              var msg = result.split('--');
              msg_alert(result);
              if(msg[0]!="error"){
                $('#btn_update').button('reset');
                $('#update_desc_modal').modal('hide');
                list_reflect();
              }
          }
        });



    }
});
</script>
<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>