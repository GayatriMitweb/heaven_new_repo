<?php

include "../../model/model.php";

?>

<form id="frm_save">



<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <h4 class="modal-title" id="myModalLabel">Activity</h4>

      </div>

      <div class="modal-body">

			<div class="row mg_bt_10">

				<div class="col-sm-6 mg_bt_10_xs">

					<select name="city_id" id="city_id" title="Select City" style="width:100%">
		            </select>

				</div>

				<div class="col-sm-6 mg_bt_10_xs">

					<input type="text" id="service_name" name="service_name" placeholder="*Activity Name" title="Activity Name">

				</div>

			</div>

			<div class="row mg_bt_10">
				<div class="col-sm-6">
					<input type="text" id="service_amount" name="service_amount" placeholder="Adult Cost" title="Adult Cost" onchange="validate_balance(this.id);">
				</div>
				<div class="col-sm-6">
					<input type="text" id="service_amount1" name="service_amount1" placeholder="Children Cost" title="Children Cost" onchange="validate_balance(this.id);">
				</div>
		   </div>
		    <div class="row mg_bt_10">
				<div class="col-sm-12">
					<textarea id="description" name="description" onchange="validate_spaces(this.id)" placeholder="Description" title="Description"/>
				</div>
			</div>	

        	<div class="row mg_bt_10">
		   		<div class="col-sm-12">          
	                <div class="div-upload">
	                  <div id="photo_upload_btn_i" class="upload-button1"><span>Image</span></div>
	                  <span id="photo_status" ></span>
	                  <ul id="files" ></ul>
	                  <input type="hidden" id="photo_upload_url_i" name="photo_upload_url_i">
	                </div>
                </div>
        	</div>
		   <div class="row mg_bt_10"> 		   		
				<div class="col-sm-6">					
	              <select name="active_flag" id="active_flag" title="Status" class="hidden">
	                <option value="Active">Active</option>
	                <option value="Inactive">Inactive</option>
	              </select>
				</div>
				
			</div>		
		  



			<div class="row mg_tp_20 text-center">

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

city_lzloading('#city_id');
$('#save_modal').modal('show');


upload_user_pic_attch();

function upload_user_pic_attch()
{

    var btnUpload=$('#photo_upload_btn_i');

    $(btnUpload).find('span').text('Image');

    $("#photo_upload_url_i").val('');
    new AjaxUpload(btnUpload, {

      action: 'upload_image_proof.php',

      name: 'uploadfile',

      onSubmit: function(file, ext)
      {  

        if (! (ext && /^(jpg|png|jpeg)$/.test(ext))){ 

         error_msg_alert('Only JPG, PNG or GIF files are allowed');

         return false;

        }

        $(btnUpload).find('span').text('Uploading...');

      },

      onComplete: function(file, response){
        if(response==="error"){          

          error_msg_alert("File is not uploaded.");           

          $(btnUpload).find('span').text('Upload');

        }else

        { 

          $(btnUpload).find('span').text('Uploaded');

          $("#photo_upload_url_i").val(response);

        }

      }

    });

}


$(function(){

	$('#frm_save').validate({

		rules:{

				city_id : { required : true },
				service_name : { required : true },
				
		},

		submitHandler:function(form){

			var city_id = $('#city_id').val();
			var service_name = $('#service_name').val();
			var adult_cost = $('#service_amount').val();
			var child_cost = $('#service_amount1').val();
			var active_flag = $('#active_flag').val();
			var description = $('#description').val();
			var photo_upload_url = $('#photo_upload_url_i').val();
			$('#btn_save').button('loading');

			$.ajax({

				type:'post',

				url: base_url()+'controller/paid_services/paid_service_save.php',

				data:{ city_id : city_id, service_name : service_name , adult_cost : adult_cost,child_cost : child_cost, active_flag : active_flag,description : description,photo_upload_url : photo_upload_url},

				success:function(result){

					msg_alert(result);

					$('#save_modal').modal('hide');

					list_reflect();

				}

			});



		}

	});

});

</script>

<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>