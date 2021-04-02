<?php

include "../../model/model.php";



$service_id = $_POST['service_id'];



$sq_ser = mysql_fetch_assoc(mysql_query("select * from itinerary_paid_services where service_id='$service_id'"));

?>

<form id="frm_update">

<input type="hidden" id="service_id" name="service_id" value="<?= $service_id ?>">



<div class="modal fade" id="update_modal" role="dialog" aria-labelledby="myModalLabel">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <h4 class="modal-title" id="myModalLabel">Update Activity</h4>

      </div>

      <div class="modal-body">

        	

			<div class="row">

				<div class="col-sm-6 mg_bt_10">

					<select name="city_id" id="city_id" title="City Name" style="width:100%">

					  <?php 

					  $sq_city = mysql_fetch_assoc(mysql_query("select * from city_master where city_id='$sq_ser[city_id]'"));

					  ?>

					  <option value="<?= $sq_ser['city_id'] ?>" selected="selected"><?= $sq_city['city_name'] ?></option>
		            </select>

				</div>

				<div class="col-sm-6 mg_bt_10">

					<input type="text" id="service_name" name="service_name" placeholder="*Activity Name" title="Activity Name" value="<?= $sq_ser['service_name'] ?>">

				</div>

			</div>
			<div class="row mg_bt_10">
				<div class="col-sm-6">
					<input type="text" id="service_amount" value="<?= $sq_ser['adult_cost'] ?>" name="service_amount" placeholder="Adult Cost" title="Adult Cost" onchange="validate_balance(this.id);">
				</div>
				<div class="col-sm-6">
					<input type="text" id="service_amount1" value="<?= $sq_ser['child_cost'] ?>" name="service_amount1" placeholder="Children Cost" title="Children Cost" onchange="validate_balance(this.id);">
				</div>
		    </div>

			<div class="row mg_bt_10">

				<div class="col-sm-6 mg_bt_10">

	              <select name="active_flag" id="active_flag1" title="Status">

	                <option value="<?=$sq_ser['active_flag'] ?>"><?=$sq_ser['active_flag'] ?></option>

	                <option value="Active">Active</option>

	                <option value="Inactive">Inactive</option>

	              </select>

	            </div>
				<div class="col-md-6 col-sm-6 mg_bt_10 text-left">          

	                <div class="div-upload">

	                  <div id="photo_upload_btn_i" class="upload-button1"><span>Image</span></div>

	                  <span id="photo_status" ></span>

	                  <ul id="files" ></ul>

	                  <input type="hidden" id="photo_upload_url_i1" name="photo_upload_url_i1">

	                </div>

                </div> 
			</div>
			<div class="row">
				<div class="col-sm-12 mg_bt_10">
					<textarea id="description" name="description" onchange="validate_spaces(this.id);" placeholder="Description" title="Description"><?= $sq_ser['description'] ?></textarea>
				</div>
			</div>

			</div>



			<div class="row mg_bt_20 text-center">

				<div class="col-md-12">

					<button class="btn btn-sm btn-success" id="btn_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Update</button>

				</div>

			</div>



      </div>      

    </div>

  </div>

</div>



</form>



<script>

city_lzloading('#city_id');

$('#update_modal').modal('show');

upload_user_pic_attch();

function upload_user_pic_attch()
{

    var btnUpload=$('#photo_upload_btn_i');

    $(btnUpload).find('span').text('Image');

    $("#photo_upload_url_i1").val('');
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
          $("#photo_upload_url_i1").val(response);
          upload_pic();

        }

      }

    });

}

function upload_pic()
	{
	  var base_url = $("#base_url").val();

	  var img_upload_url = $('#photo_upload_url_i1').val();

	  var service_id = $('#service_id').val();



	  $.ajax({

	          type:'post',

	          url: base_url+'controller/paid_services/paid_service_img_update.php',

	          data:{ img_upload_url : img_upload_url, service_id : service_id },

	          success:function(result)

	          {

	           // msg_alert(result);

	          }

	  });

	}

$(function(){

	$('#frm_update').validate({

		rules:{

				city_id : { required : true },

				service_name : { required : true },

		},

		submitHandler:function(form){

			var service_id = $('#service_id').val();

			var city_id = $('#city_id').val();

			var service_name = $('#service_name').val();

			var adult_cost = $('#service_amount').val();
			var child_cost = $('#service_amount1').val();

			var active_flag = $('#active_flag1').val();
			var description = $('#description').val();



			$('#btn_save').button('loading');



			$.ajax({

				type:'post',

				url: base_url()+'controller/paid_services/paid_service_update.php',

				data:{ service_id  :service_id, city_id : city_id, service_name : service_name , adult_cost : adult_cost,child_cost : child_cost, active_flag : active_flag,description : description },

				success:function(result){

					msg_alert(result);

					$('#update_modal').modal('hide');

					list_reflect();

				}

			});



		}

	});

});

</script>

<script src="<?= BASE_URL ?>js/app/footer_scripts.js"></script>