<?php include "../../../model/model.php"; ?>

<form id="frm_save">

<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <h4 class="modal-title" id="myModalLabel">Role</h4>

      </div>

      <div class="modal-body">

        

          <div class="row">

            <div class="col-sm-6 col-sm-offset-3 mg_bt_10">

              <input type="text" id="role_name" onchange="fname_validate(this.id);" name="role_name" placeholder="*Role" title="Role Name">
                <small>Note : Enter new role eg. Account.</small>
            </div>     

            <div class="col-sm-6">

              <select name="active_flag" id="active_flag" title="Status" class="hidden">

                <option value="Active">Active</option>

                <option value="Inactive">Inactive</option>

              </select>

            </div>       

          </div>



          <div class="row mg_tp_10 text-center">

            <div class="col-md-12">

              <button class="btn btn-sm btn-success" id="btn_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>

            </div>

          </div>



      </div>      

    </div>

  </div>

</div>



</form>



<script>

$('#save_modal').modal('show');



$('#frm_save').validate({

    rules:{

          role_name : { required : true },

          active_flag : { required : true },

    },

    submitHandler:function(form){



        var role_name = $('#role_name').val();

        var active_flag = $('#active_flag').val();

       

        $('#btn_save').button('loading');



        $.ajax({

          type:'post',

          url:base_url()+'controller/other_masters/roles/save_role.php',

          data:{ role_name : role_name, active_flag : active_flag  },

          success:function(result){

              $('#btn_save').button('reset');

              var msg = result.split('--');

              msg_alert(result);

              if(msg[0]!="error"){

                $('#save_modal').modal('hide');

                list_reflect();

              }

          }

        });







    }

});

</script>

<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>