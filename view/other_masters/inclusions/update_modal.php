<?php

include "../../../model/model.php";



$inclusion_id = $_POST['inclusion_id'];
$sq_inc = mysql_fetch_assoc(mysql_query("select * from inclusions_exclusions_master where inclusion_id='$inclusion_id'"));

?>

<form id="frm_update">

<input type="hidden" id="inclusion_id" name="inclusion_id" value="<?= $inclusion_id ?>">

<div class="modal fade" id="update_modal" role="dialog" aria-labelledby="myModalLabel">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <h4 class="modal-title" id="myModalLabel">Update Inclusion/Exclusion</h4>

      </div>

      <div class="modal-body">

        

          <div class="row mg_bt_10">

            <div class="col-md-12">

              <textarea class="feature_editor" id="inclusion" name="inclusion" placeholder="Description" title="Description"><?= $sq_inc['inclusion'] ?></textarea>

            </div>               

          </div>

          <div class="row">

            <div class="col-sm-6 mg_bt_10">

              <select name="for_value1" id="for_value1" title="For">

                <option value="<?=$sq_inc['for_value'] ?>"><?=$sq_inc['for_value'] ?></option>

                <option value="Group">Group Tour</option>

                <option value="Package">Package Tour</option>
                <option value="Both">Both</option>
                <option value="B2B Quotation">B2B Quotation</option>

              </select>

            </div>  

            <div class="col-sm-6 mg_bt_10">

              <select name="type1" id="type1" title="Type">

                <option value="<?=$sq_inc['type'] ?>"><?=$sq_inc['type'] ?></option>

                <option value="Inclusion">Inclusion</option>

                <option value="Exclusion">Exclusion</option>

              </select>

            </div>  

            <div class="col-sm-6 mg_bt_10">

              <select name="tour_type" id="tour_type" title="Tour Type">

                <option value="<?=$sq_inc['tour_type'] ?>"><?=$sq_inc['tour_type'] ?></option>

                <option value="Domestic">Domestic</option>

                <option value="International">International</option>

                <option value="Both">Both</option>

              </select>

            </div>

            <div class="col-sm-6 mg_bt_10">

              <select name="active_flag" id="active_flag" title="Status">

                <option value="<?=$sq_inc['active_flag'] ?>"><?=$sq_inc['active_flag'] ?></option>

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

$('#update_modal').modal('show');

$('#frm_update').validate({

    rules:{

            inclusion : { required : true },

            tour_type : { required : true },

            active_flag : { required : true },

            type1 : { required : true },

            for_value1 : { required : true },



    },

    submitHandler:function(form){



        var inclusion_id = $('#inclusion_id').val();

        var inclusion = $('#inclusion').val();

        var tour_type = $('#tour_type').val();

        var active_flag = $('#active_flag').val();

        var type = $('#type1').val();

        var for_value = $('#for_value1').val();

        $('#btn_update').button('loading');



        $.ajax({

          type:'post',

          url:base_url()+'controller/other_masters/inclusions/update_inclusion.php',

          data:{ inclusion_id : inclusion_id, inclusion : inclusion, tour_type : tour_type, active_flag : active_flag, type : type,for_value : for_value },

          success:function(result){

              $('#btn_update').button('reset');

              var msg = result.split('--');

              msg_alert(result);

              if(msg[0]!="error"){

                $('#update_modal').modal('hide');

                list_reflect();

              }

          }

        });







    }

});

</script>

<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>