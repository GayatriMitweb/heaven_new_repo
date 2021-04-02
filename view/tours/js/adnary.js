adnary_upload();
function adnary_upload()
{
	var type="adnary";
	var btnUpload=$('#adnary_upload');
	var status=$('#adnary_status');
	new AjaxUpload(btnUpload, {
	  action: 'upload_adnary_file.php',
	  name: 'uploadfile',
	  onSubmit: function(file, ext){

	  	 var tour_id = $("#cmb_tour_id").val();
		  var adnary_url = $("#txt_adnary_upload_dir").val();

		  
		  if(tour_id=="")
		  {
		    error_msg_alert('Please select tour name.');
		    return false;
		  }



	     if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
	                // extension is not allowed 
	      status.text('Only JPG, PNG or GIF files are allowed');
	      //return false;
	    }
	    status.text('Uploading...');
	  },
	  onComplete: function(file, response){
	    //On completion clear the status
	    status.text('');
	    //Add uploaded file to list
	    if(response==="error"){          
	      alert("File is not uploaded.");           
	      //$('<li></li>').appendTo('#files').html('<img src="./uploads/'+file+'" alt="" /><br />'+file).addClass('success');
	    } else{
	      ///$('<li></li>').appendTo('#files').text(file).addClass('error');
	      document.getElementById("txt_adnary_upload_dir").value = response;
	      upload_tour_adnary();
	    }
	  }
	});

}


///////////////////////***Upload Tour Adnary start*********//////////////

function upload_tour_adnary()
{
  var base_url = $("#base_url").val();
  var tour_id = $("#cmb_tour_id").val();
  var adnary_url = $("#txt_adnary_upload_dir").val();
  
  if(tour_id=='')
  {
    error_msg_alert('Please select tour name.');
    return false;
  } 
  if(adnary_url=='')
  {
    error_msg_alert('Please upload the adnary first.');
    return false;
  }  

  $.post( 
               base_url+"controller/group_tour/tours/upload_tour_adnary.php",
               { tour_id : tour_id, adnary_url : adnary_url },
               function(data) {  
                     msg_alert(data);                      
               });

} 

///////////////////////***Upload Tour Adnary start*********//////////////