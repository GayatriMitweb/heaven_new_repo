<?php

include "../../model/model.php";
$package_id = $_POST['package_id'];

$sq_ser = mysql_fetch_assoc(mysql_query("select * from supplier_packages where package_id='$package_id'"));

?>

<form id="frm_update" enctype="multipart/form-data">

<input type="hidden" id="package_id" name="package_id" value="<?= $package_id ?>">



<div class="modal fade" id="update_modal" role="dialog" aria-labelledby="myModalLabel">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <h4 class="modal-title" id="myModalLabel">Update Package</h4>

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
			            <select name="supplier_id" id="supplier_id" title="Select Supplier Type" style="width:100%">
			               <option value="<?= $sq_ser['supplier_type'] ?>"><?= $sq_ser['supplier_type'] ?></option>	
						   <option value="">Supplier Type</option>		              
						   <option value="Hotel">Hotel</option>		              
						   <option value="Transport">Transport</option>	
						   <option value="Car Rental">Car Rental</option>	
						   <option value="DMC">DMC</option>	
						   <option value="Visa">Visa</option>	
						   <option value="Passport">Passport</option>	
						   <option value="Ticket">Ticket</option>	
						   <option value="Excursion">Excursion</option>	
						   <option value="Insuarance">Insuarance</option>	
						   <option value="Train Ticket">Train Ticket</option>	
						   <option value="Other">Other</option>	
						   <option value="Bus">Bus</option>	
						   <option value="Forex">Forex</option>	
			            </select>
			        </div>
			</div>
			<div class="row">		   	
				<div class="col-sm-6 mg_bt_10">

					<input type="text" id="supplier_name" name="supplier_name" placeholder="Supplier Name" title="Supplier Name" value="<?= $sq_ser['name'] ?>">

				</div>

			    <div class="col-sm-6 mg_bt_10">
					<input type="text" id="valid_from" name="valid_from" onchange="validate_validDate('valid_from' , 'valid_to')" placeholder="Valid From" value="<?php echo get_date_user($sq_ser['valid_from']);?>" title="Valid From">
				</div>
			</div>
			<div class="row">		   	
			    <div class="col-sm-6 mg_bt_10">
					<input type="text" id="valid_to" name="valid_to" onchange="validate_issueDate('valid_from' , 'valid_to')" placeholder="Valid To" value="<?php echo get_date_user($sq_ser['valid_to']);?>" title="Valid To">
				</div>

				<div class="col-sm-6 mg_bt_10">

	              <select name="active_flag" id="active_flag1" title="Status">

	                <option value="<?=$sq_ser['active_flag'] ?>"><?=$sq_ser['active_flag'] ?></option>

	                <option value="Active">Active</option>

	                <option value="Inactive">Inactive</option>

	              </select>

	            </div>
	         </div>
	         <div class="row">		   	
				<div class="col-sm-12 mg_bt_20">          

	                <div class="div-upload">

	                  <div id="photo_upload_btn_i" class="upload-button1"><span>Upload</span></div>

					  <input type="file" name="upload1[]" id="fileuploadingup" style="display:none" multiple="multiple">
	                  <span id="photo_status" ></span>

	                  <ul id="files" ></ul>

	                  <input type="hidden" id="photo_upload_url_i1" name="photo_upload_url_i1">

	                </div>

                </div> 
			</div>

			</div>



			<div class="row mg_bt_20 text-center">

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
city_lzloading('#city_id');
$('#valid_from,#valid_to').datetimepicker({timepicker:false, format:'d-m-Y'});

$('#update_modal').modal('show');
$('#photo_upload_btn_i').click(function(){ $('#fileuploadingup').trigger('click'); });
$('#fileuploadingup').change(function(){
	var ext = $(this).val().split('.').pop();
	if (! (ext && /^(xlsx|doc|docx|pdf)$/.test(ext))){ 
		error_msg_alert('Only Word,Excel or PDF files are allowed');
		return false;
	}
});
/*
upload_user_pic_attch();

function upload_user_pic_attch()
{

    var btnUpload=$('#photo_upload_btn_i');

    $(btnUpload).find('span').text('Upload');

    $("#photo_upload_url_i1").val('');
    new AjaxUpload(btnUpload, {

      action: 'upload_image_proof.php',

      name: 'uploadfile',

      onSubmit: function(file, ext)
      {  

        if (! (ext && /^(xlsx|doc|docx|pdf)$/.test(ext))){ 

         error_msg_alert('Only Word,Excel or PDF files are allowed');

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

	  var package_id = $('#package_id').val();



	  $.ajax({

	          type:'post',

	          url: base_url+'controller/supplier_packages/package_img_update.php',

	          data:{ img_upload_url : img_upload_url, package_id : package_id },

	          success:function(result)

	          {

	           // msg_alert(result);

	          }

	  });

	}
*/
$(function(){

	$('#frm_update').validate({

		rules:{

				city_id : { required : true },
				supplier_id : { required : true },
		},

		submitHandler:function(form){
			event.preventDefault();
			var package_id = $('#package_id').val();
			var city_id = $('#city_id').val();
			var supplier_id = $('#supplier_id').val();
			var active_flag = $('#active_flag1').val();
			var supplier_name = $('#supplier_name').val();
			var valid_from = $('#valid_from').val();
			var valid_to = $('#valid_to').val();
			var formDataup = new FormData($('#frm_update')[0]);
			$('#btn_update').button('loading');
			for(var value of formDataup.values()) {
				if(typeof(value) == "object"){
					var ext = value["name"].split('.').pop();
						if (! (ext && /^(xlsx|doc|docx|pdf)$/.test(ext))){ 
							error_msg_alert('Only Word,Excel or PDF files are allowed');
							$('#btn_update').button('loading');
							return false;
						}
				}
			 
			}


			$.ajax({

				type:'post',
				processData: false,
				contentType: false,

				url: base_url()+'controller/supplier_packages/package_update.php',

				/*data:{ package_id: package_id, city_id : city_id, supplier_id : supplier_id , supplier_name : supplier_name,valid_from : valid_from,valid_to: valid_to, active_flag : active_flag},*/
				data : formDataup,

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