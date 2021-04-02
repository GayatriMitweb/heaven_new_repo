<?php

include "../../../model/model.php";

?>

<form id="frm_save">

<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <h4 class="modal-title" id="myModalLabel">Inclusion/Exclusion</h4>

      </div>

      <div class="modal-body">

        

          <div class="row mg_bt_10">

            <div class="col-md-12">

              <textarea class="feature_editor" id="inclusion" name="inclusion" placeholder="*Description" title="Description"></textarea>

            </div>             

          </div>

          <div class="row">

            <div class="col-sm-4 mg_bt_10">

              <select name="for_value" id="for_value" title="For">

                <option value="">For</option>

                <option value="Group">Group Tour</option>

                <option value="Package">Package Tour</option>
                <option value="Both">Both</option>
                <option value="B2B Quotation">B2B Quotation</option>

              </select>

            </div>  

             <div class="col-sm-4 mg_bt_10">

              <select name="type" id="type" title="Type">

                <option value="">Type</option>

                <option value="Inclusion">Inclusion</option>

                <option value="Exclusion">Exclusion</option>

              </select>

            </div>  

            <div class="col-sm-4 mg_bt_10">

              <select name="tour_type" id="tour_type" title="Tour Type">

                <option value="">Tour Type</option>

                <option value="Domestic">Domestic</option>

                <option value="International">International</option>

                <option value="Both">Both</option>

              </select>

            </div>

          </div>

          <div class="row">

            <div class="col-sm-4">

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

            inclusion : { required : true },

            tour_type : { required : true },

            active_flag : { required : true },

            type : { required : true },

            for_value : { required : true },

    },

    submitHandler:function(form){



        var inclusion = $('#inclusion').val();

        var tour_type = $('#tour_type').val();

        var active_flag = $('#active_flag').val();

        var type = $('#type').val();

        var for_value = $('#for_value').val();



        $('#btn_save').button('loading');



        $.ajax({

          type:'post',

          url:base_url()+'controller/other_masters/inclusions/save_inclusion.php',

          data:{ inclusion : inclusion, tour_type : tour_type, active_flag : active_flag, type : type, for_value : for_value },

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