<?php

include_once("../../../model/model.php");

?>

<form id="frm_save">



<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <h4 class="modal-title" id="myModalLabel">Image</h4>

      </div>

      <div class="modal-body">

        <div class="row mg_bt_10">

            <div class="col-sm-6 col-xs-7 mg_bt_10_sm_xs"> 

              <select id="dest_name"  name="dest_name" title="*Select Destination" class="form-control"  style="width:100%"> 

                <option value="">Destination</option>

                 <?php 

                 $sq_query = mysql_query("select * from destination_master where status != 'Inactive'"); 

                 while($row_dest = mysql_fetch_assoc($sq_query)){ ?>

                    <option value="<?php echo $row_dest['dest_id']; ?>"><?php echo $row_dest['dest_name']; ?></option>

                    <?php } ?>

              </select>

            </div>



        <div class="col-sm-6 col-xs-5 mg_bt_10_sm_xs text-right">

          <div class="div-upload">

                <div id="hotel_btn1" class="upload-button1"><span>Upload Image</span></div>

                <span id="id_proof_status" ></span>

                <ul id="files" ></ul>

                <input type="hidden" id="gallary_url" name="gallary_url">

          </div>

          

        </div>

        </div>

        <div class="row mg_bt_10">
          <div class="col-xs-12"> 
            <div style="color: red;">Note : Upload Image size below 300KB, resolution : 900X450.</div>
          </div>
        </div>

        <div class="row mg_bt_10">
          <div class="col-xs-12"> 
            <textarea id="description" onchange="fname_validate(this.id);" name="description" placeholder="*Description" title="Description" rows="4"></textarea>
          </div>
        </div>

        <div class="row mg_tp_10">

          <div class="col-md-12 text-center">

            <button class="btn btn-sm btn-success" id="btn_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>

          </div>

        </div>

      </div>      

    </div>

  </div>

</div>



</form>

<script src="<?= BASE_URL ?>js/ajaxupload.3.5.js"></script>

<script>

$('#save_modal').modal('show');

$('#dest_name').select2();



upload_pic_attch();

function upload_pic_attch()

{

    var btnUpload=$('#hotel_btn1');

    $(btnUpload).find('span').text('Image');

    $("#gallary_url").val('');

    new AjaxUpload(btnUpload, {

      action: 'gallery/upload_ticket.php',

      name: 'uploadfile',

      onSubmit: function(file, ext){  



        if (! (ext && /^(jpg|png|jpeg)$/.test(ext))){ 

         error_msg_alert('Only JPG, PNG or GIF files are allowed');

         return false;

        }
         
        $(btnUpload).find('span').text('Uploading...');

      },

      onComplete: function(file, response){

        if(response==="error"){          

          error_msg_alert("File is not uploaded.");           

          $(btnUpload).find('span').text('Upload Image');

        }else

        { 

          if(response=="error1")

          {

            $(btnUpload).find('span').text('Upload Image');

            error_msg_alert('Maximum size exceeds');

            return false;

          }else

          {

            $(btnUpload).find('span').text('Uploaded');

            $("#gallary_url").val(response);

           // upload_pic();

          }

        }

      }

    });

}

/*

function upload_pic()

{

  var base_url = $("#base_url").val();

  var gallary_url = $('#gallary_url').val();



  $.ajax({

          type:'post',

          url: base_url+'controller/other_masters/gallary/gallary_img_save.php',

          data:{ gallary_url : gallary_url },

          success:function(result)

          {

            msg_alert(result);

          }

  });

}*/



$('#frm_save').validate({

  rules :

  {

    dest_name : { required : true },

    description : { maxlength : 100, required : true}

  },

    submitHandler:function(form){

      

       var base_url = $("#base_url").val();

       var dest_id = $('#dest_name').val();

       var description = $('#description').val();

       var gallary_url = $('#gallary_url').val();

       if(gallary_url == '') { error_msg_alert("Select image to Upload");  return false;  }

       $('#btn_save').button('loading');



        $.ajax({

          type:'post',

          url:base_url+'controller/other_masters/gallary/gallary_img_save.php',

          data:{dest_id : dest_id, description : description, gallary_url : gallary_url },

          success:function(result){

              var msg = result.split('--');

              msg_alert(result);               

                $('#btn_save').button('reset');

                $('#save_modal').modal('hide');

                list_reflect();
                update_b2c_cache();

              

          }

        });







    }

});

</script>

<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>