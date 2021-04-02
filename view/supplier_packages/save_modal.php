<?php

include "../../model/model.php";

?>

<form id="frm_save" enctype="multipart/form-data">



<div class="modal fade" id="save_modal" role="dialog" aria-labelledby="myModalLabel">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

        <h4 class="modal-title" id="myModalLabel">New Package</h4>

      </div>

      <div class="modal-body">        	
			<div class="row mg_bt_10">
				<div class="col-sm-6 mg_bt_10_xs">
					<select name="city_id" id="city_id" title="Select City" style="width:100%">
		            </select>
				</div>
				<div class="col-sm-6 mg_bt_10_xs">
					<select name="supplier_id" id="supplier_id" title="Select Supplier Type" style="width:100%">
					   <option value="">*Supplier Type</option>		              
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
		   <div class="row mg_bt_10">		   	
				<div class="col-sm-6 mg_bt_10_xs">
					<input type="text" id="supplier_name" name="supplier_name" placeholder="Supplier Name" title="Supplier Name">
				</div>
				<div class="col-sm-6 mg_bt_10_xs">
					<input type="text" id="valid_from" name="valid_from" onchange="get_to_date(this.id , 'valid_to')" placeholder="Valid From" title="Valid From" value="<?= date('d-m-Y') ?>">
				</div>
			</div>
			<div class="row mg_bt_10">		   	
			    <div class="col-sm-6 mg_bt_10_xs">
					<input type="text" id="valid_to" name="valid_to" placeholder="Valid To" title="Valid To" value="<?= date('d-m-Y') ?>">
				</div>
				<div class="col-sm-6">					
	              <select name="active_flag" id="active_flag" title="Status" class="hidden">
	                <option value="Active">Active</option>
	                <option value="Inactive">Inactive</option>
	              </select>
				</div>
			
				<div class="col-md-6 col-sm-6 text-left">          

	                <div class="div-upload">

	                  <div id="photo_upload_btn_i" class="upload-button1"><span>Upload</span></div>

	                  <input type="file" name="upload[]" id="fileuploading" style="display:none" multiple="multiple">
					  <span id="photo_status" ></span>

	                  <ul id="files" ></ul>

	                  <input type="hidden" id="photo_upload_url_i" name="photo_upload_url_i">

	                </div>

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
$('#valid_from,#valid_to').datetimepicker({timepicker:false, format:'d-m-Y'});

$('#save_modal').modal('show');

$('#photo_upload_btn_i').click(function(){ $('#fileuploading').trigger('click'); });
$('#fileuploading').change(function(){
	var ext = $(this).val().split('.').pop();
	if (! (ext && /^(xlsx|doc|docx|pdf)$/.test(ext))){ 
		error_msg_alert('Only Word,Excel or PDF files are allowed');
		return false;
	}
});

/*
	function upload_user_pic_attch()
{

    var btnUpload=$('#photo_upload_btn_i');

    $(btnUpload).find('span').text('Upload');

    $("#photo_upload_url_i").val('');
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
			console.log(response);
          //$("#photo_upload_url_i").val(response);

        }

      }

    });

}
*/

$(function(){

	$('#frm_save').validate({

		rules:{

				city_id : { required : true },
				supplier_id : { required : true },
		},

		submitHandler:function(form){
			event.preventDefault();
			var city_id = $('#city_id').val();
			var supplier_id = $('#supplier_id').val();
			var active_flag = $('#active_flag').val();
			var supplier_name = $('#supplier_name').val();
			var valid_from = $('#valid_from').val();
			var valid_to = $('#valid_to').val();
			//var photo_upload_url = $('#photo_upload_url_i').val();

			var formData = new FormData($('#frm_save')[0]);
			$('#btn_save').button('loading');
			for(var value of formData.values()) {
				if(typeof(value) == "object"){
					var ext = value["name"].split('.').pop();
						if (! (ext && /^(xlsx|doc|docx|pdf)$/.test(ext))){ 
							error_msg_alert('Only Word,Excel or PDF files are allowed');
							$('#btn_save').button('loading');
							return false;
						}
				}
			 
			}
			$.ajax({

				type:'post',
				processData: false,
				contentType: false,
				url: base_url()+'controller/supplier_packages/package_save.php',

				/*data:{ city_id : city_id, supplier_id : supplier_id , supplier_name : supplier_name,valid_from : valid_from,valid_to: valid_to, active_flag : active_flag,photo_upload_url : photo_upload_url},*/
				data: formData,

				success:function(result){
					console.log(result);
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