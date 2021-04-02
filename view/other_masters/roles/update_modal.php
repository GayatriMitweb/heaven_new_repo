<?php

include "../../../model/model.php";



$role_id = $_POST['role_id'];

$sq_role = mysql_fetch_assoc(mysql_query("select * from role_master where role_id='$role_id'"));

?>

<form id="frm_update">

<input type="hidden" id="role_id" name="role_id" value="<?= $role_id ?>">



<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel" > 

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <h4 class="modal-title" id="myModalLabel">Update Role</h4>

      </div>

      <div class="modal-body">

        

          <div class="row">

            <div class="col-sm-6 mg_bt_10">

              <input type="text" id="role_name" name="role_name" onchange="fname_validate(this.id);" placeholder="*Role" title="Role Name" value="<?= $sq_role['role_name'] ?>">

            </div>     

            <div class="col-sm-6 mg_bt_10">

              <select name="active_flag" id="active_flag" title="Status">

                <option value="<?= $sq_role['active_flag'] ?>"><?= $sq_role['active_flag'] ?></option>

                <option value="Active">Active</option>

                <option value="Inactive">Inactive</option>

              </select>

            </div>       

          </div>



          <div class="row mg_tp_10 text-center">

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

$('#save_modal').modal('show');

$('#frm_update').validate({

    rules:{

          role_name : { required : true },

          active_flag : { required : true },

    },

    submitHandler:function(form){



        var role_id = $('#role_id').val();

        var role_name = $('#role_name').val();

        var active_flag = $('#active_flag').val();

       

        $('#btn_update').button('loading');



        $.ajax({

          type:'post',

          url:base_url()+'controller/other_masters/roles/update_role.php',

          data:{ role_id : role_id, role_name : role_name, active_flag : active_flag  },

          success:function(result){

              $('#btn_update').button('reset');

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