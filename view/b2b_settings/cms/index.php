<?php
include "../../../model/model.php";
?>
<div class="div_left">
  <ul class="nav nav-pills">
    <li role="presentation" class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
          Index Page <i class="right"></i>
        </a>
        <ul id="index_page" class="dropdown-menu">
          <li>1-Banner Images</li>
          <li>2-Why Choose Us ?</li>
          <li>3-Amazing Destination Ideas for you!</li>
          <li>4-Popular Destinations</li>
          <li>5-Popular Hotels for Honeymoon</li>
          <li>6-Popular Activities</li>
          <li>7-Call To Action</li>
          <li>8-Popular Hotels</li>
          <li>9-Popular Destinations for Honeymoon</li>
          <li>10-Footer</li>
        </ul>
    </li>
    <li role="presentation" class="dropdown">
      <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
        About Us&nbsp;&nbsp; <i class="right"></i>
      </a>
      <ul class="dropdown-menu">
        <li>one</li>
        <li>one</li>
        <li>one</li>
        <li>one</li>
      </ul>
    </li>
  </ul>
</div>
<div class="div_right">
     <form id="section_data_form">
     </form>
</div>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>
<script type="text/javascript">
var ul = document.getElementById('index_page');
ul.onclick = function(event) {
    var e = event || window.event;
    var selected = e.target.innerHTML || e.srcElement.innerHTML;
    var selected_item =  selected.split('-');
    $.post('cms/get_selected_section.php', { section_name : selected_item[0]}, function(data){
      $('#section_data_form').html(data);
    });
};
$(function(){
$('#section_data_form').validate({
  rules:{
  },
  submitHandler:function(form){
    var base_url = $('#base_url').val();
    var section_name = $('#section_name').val();
    var display_status = $('#display_status').val();
    var banner_uploaded_count = $('#banner_uploaded_count').val();
    var activeTab = '';
    if(section_name == '1'){
    // Banner's Images
      var images_array = new Array();
      var image_count = $('#banner_count').val();
      for(var i=1;i<=image_count;i++){
        banner_uploaded_count = parseInt(banner_uploaded_count) + 1;
        var image_url = $("#image_upload_url"+parseInt(i-1)).val();
        if(image_url!=''){
          images_array.push({
            'banner_count' : banner_uploaded_count,
            'image_url'    : image_url
          })
        }
      }
    // Banner's Images End
    }
    else if(section_name == '2'){
    // Why choose us
      if(display_status==''){
        error_msg_alert("Please Select Display Status"); return false;
      }
      var images_array = new Array();
      for(var j=0;j<5;j++){
        var image_url = $("#imagel"+parseInt(j)).val();
        var title = $("#titlel"+parseInt(j)).val();
        var description = $("#descriptionl"+parseInt(j)).val();
        if(image_url==''){
          error_msg_alert("Please Select Image "+parseInt(j+1)); return false;
        }
        if(title == ''){
          error_msg_alert("Please Enter Title at row "+parseInt(j+1)); return false;
        }
        if(description == ''){
          error_msg_alert("Please Enter Description at row "+parseInt(j+1)); return false;
        }
        var flag1 = validate_char_size("titlel"+parseInt(j),40);
        var flag2 = validate_char_size("descriptionl"+parseInt(j),85);
        if(!flag1 || !flag2 ){
          return false;
        }
        images_array.push({
          'banner_count' : (j+1),
          'image_url'    : image_url,
          'title'        : title,
          'description'  : description
        })
      }
    // Why choose us End
    }
    else if(section_name == '3'){
    // Amazing destination ideas for you
      if(display_status==''){
        error_msg_alert("Please Select Display Status"); return false;
      }
      var heading = $("#heading").val();
      var images_array = new Array();
      var temp_array1 = new Array();
      var uploaded_count = $('#uploaded_count').val();
      var ideas_count = $('#ideas_count').val();
      if(heading == ''){
        error_msg_alert("Please Enter Heading"); return false;
      }
      var flag1 = validate_char_size("heading",50);
      if(!flag1){
        return false;
      }
      if(uploaded_count>0){
        for(var j=0;j<(uploaded_count);j++){
          var icon = $("#image"+parseInt(j)).val();
          var title = $("#title"+parseInt(j)).val();
          var description = $("#description"+parseInt(j)).val();
          if(icon==''){
            error_msg_alert("Please Select Icon "+parseInt(j)); return false;
          }
          if(title == ''){
            error_msg_alert("Please Enter Title at row "+parseInt(j)); return false;
          }
          if(description == ''){
            error_msg_alert("Please Enter Description at row "+parseInt(j)); return false;
          }
          var flag1 = validate_char_size("title"+parseInt(j),20);
          var flag2 = validate_char_size("description"+parseInt(j),60);
          if(!flag1 || !flag2){
            return false;
          }
          temp_array1.push({
            'icon' : icon,
            'title'        : title,
            'description'  : description
          });        
        }
      }
      if(ideas_count>0){      
        var temp_array = new Array();
        var ideas_count = $('#ideas_count').val();
        for(var j=1;j<=ideas_count;j++){
          var icon = $("#imagel"+parseInt(j)).val();
          var title = $("#titlel"+parseInt(j)).val();
          var description = $("#descriptionl"+parseInt(j)).val();
          if(icon==''){
            error_msg_alert("Please Select Icon "+parseInt(j)); return false;
          }
          if(title == ''){
            error_msg_alert("Please Enter Title at row "+parseInt(j)); return false;
          }
          if(description == ''){
            error_msg_alert("Please Enter Description at row "+parseInt(j)); return false;
          }
          var flag1 = validate_char_size("titlel"+parseInt(j),20);
          var flag2 = validate_char_size("descriptionl"+parseInt(j),60);
          if(!flag1 || !flag2){
            return false;
          }
          temp_array.push({
            'icon' : icon,
            'title'        : title,
            'description'  : description
          });
        }
      }
        
      images_array.push({
          'heading':heading,
          'icon_list':(temp_array1.concat(temp_array))
      });
    //Amazing destination ideas for you End
    }
    else if(section_name == '4'){
      // Popular destinations
      if(display_status==''){
        error_msg_alert("Please Select Display Status"); return false;
      }
      var images_array = new Array();
      var table = document.getElementById("tbl_dest_packages");
      var rowCount = table.rows.length;
      for(var i=0; i<rowCount; i++){
        var row = table.rows[i];
        var destination = row.cells[2].childNodes[0].value;
        var package = row.cells[3].childNodes[0].value;

        if(row.cells[0].childNodes[0].checked){
          if(destination==""){ error_msg_alert("Select Destination at row "+(i+1)); return false; }
          if(package==""){ error_msg_alert("Select Package at row "+(i+1)); return false;}
          images_array.push({          
                          'dest_id':destination,
                          'package_id':package
          });
        }
      }
      // Popular destinations End
    }
    else if(section_name == '5'){
      // Popular hotels for honeymoon 
      if(display_status==''){
        error_msg_alert("Please Select Display Status"); return false;
      }
      var images_array = new Array();
      var hotel_array = new Array();
      var heading = $('#heading').val();
      var title = $('#title').val();
      
      if(heading==''){
        error_msg_alert('Enter Heading'); return false;
      }
      if(title==''){
        error_msg_alert('Enter Title'); return false;
      }
      var flag1 = validate_char_size("heading",30);
      var flag2 = validate_char_size("title",120);
      if(!flag1 || !flag2){
        return false;
      }

      for(var i=1;i<=4;i++){
        var city_name = $('#city_name-'+i).val();
        var hotel_name = $('#hotel_name-'+i).val();
        if(city_name!='' && hotel_name==''){
          error_msg_alert('Select Hotel name in row '+i); return false;
        }
        hotel_array.push({          
                        'city_id':city_name,
                        'hotel_id':hotel_name
        });
      }
      images_array.push({
        'heading'  : heading,
        'title'    : title,
        'hotel'    : hotel_array
      });
      // Popular hotels for honeymoon End
    }
    else if(section_name == '6'){
      // Popular activities
      if(display_status==''){
        error_msg_alert("Please Select Display Status"); return false;
      }
      var images_array = new Array();
      var table = document.getElementById("tbl_activities");
      var rowCount = table.rows.length;
      for(var i=0; i<rowCount; i++){
        var row = table.rows[i];
        var city = row.cells[2].childNodes[0].value;
        var exc = row.cells[3].childNodes[0].value;

        if(row.cells[0].childNodes[0].checked){
          if(city==""){ error_msg_alert("Select City at row "+(i+1)); return false; }
          if(exc==""){ error_msg_alert("Select Excursion at row "+(i+1)); return false;}
          images_array.push({          
                          'city_id':city,
                          'exc_id':exc
          });
        }
      }
      // Popular activities End
    }
    else if(section_name == '7'){
    //Call To Action
      if(display_status==''){
        error_msg_alert("Please Select Display Status"); return false;
      }
      var images_array = new Array();
      var image_url = $("#image_upload_url").val();
      var subtitle = $("#subtitle").val();
      var title = $("#title").val();
      if(image_url==''){
        error_msg_alert("Please Select Image"); return false;
      }
      if(title == ''){
        error_msg_alert("Please Enter Title"); return false;
      }
      if(subtitle == ''){
        error_msg_alert("Please Enter Subtitle"); return false;
      }
      var flag1 = validate_char_size("title",105);
      var flag2 = validate_char_size("subtitle",75);
      if(!flag1 || !flag2){
        return false;
      }
      images_array.push({
        'image_url'    : image_url,
        'title'        : title,
        'subtitle'  : subtitle
      });
    // Call To Action End
    }
    else if(section_name == '8'){
      // Popular hotels
      if(display_status==''){
        error_msg_alert("Please Select Display Status"); return false;
      }
      var images_array = new Array();
      var table = document.getElementById("tbl_hotels");
      var rowCount = table.rows.length;
      for(var i=0; i<rowCount; i++){
        var row = table.rows[i];
        var city = row.cells[2].childNodes[0].value;
        var hotel = row.cells[3].childNodes[0].value;

        if(row.cells[0].childNodes[0].checked){
          if(city==""){ error_msg_alert("Select City at row "+(i+1)); return false; }
          if(hotel==""){ error_msg_alert("Select Hotel at row "+(i+1)); return false;}
          images_array.push({          
                          'city_id':city,
                          'hotel_id':hotel
          });
        }
      }
      // Popular hotels End
    }
    else if(section_name == '9'){
      // Popular destinations for honeymoon 
      if(display_status==''){
        error_msg_alert("Please Select Display Status"); return false;
      }

      var images_array = new Array();
      var destination_array = new Array();
      var description = $('#description').val();
      if(description=='') { error_msg_alert('Enter Description'); return false;}
      for(var i=1;i<=3;i++){
        var dest_id = $('#dest_name'+i).val();
        var image_url = $('#imagel'+i).val();
        if(dest_id!=''&&image_url==''){
          error_msg_alert('Please select Image at row '+i); return false;
        }
        if(dest_id!=''){
          destination_array.push({          
                          'dest_id':dest_id,        
                          'image_url':image_url
          });
        }
      }
      images_array.push({
        'description'  : description,
        'destination'    : destination_array
      });
      // Popular destinations for honeymoon End
    }
    else if(section_name == '10'){
      activeTab = $("ul.footer_tab li.active a")[0].hash;
      activeTab = activeTab.split('#');
      //Best selling hotels
      if(activeTab[1] == 'hotels'){
        display_status = $('#display_status1').val();
        // Footer CMS
        if(display_status==''){
          error_msg_alert("Please Select Display Status"); return false;
        }
        var images_array = new Array();
        var hotels_array = new Array();
        var table = document.getElementById("tbl_hotels");
        var rowCount = table.rows.length;
        //Max 6 hotels validation
        var count = 0;
        for(var i=0; i<rowCount; i++){
          var row = table.rows[i];
          if(row.cells[0].childNodes[0].checked){
            count++;
          }
        }
        if(count > 6){
          error_msg_alert('Max 6 hotels can add,you can deselect some of them!'); return false;
        }
        for(var i=0; i<rowCount; i++){
          var row = table.rows[i];
          var city = row.cells[2].childNodes[0].value;
          var hotel = row.cells[3].childNodes[0].value;

          if(row.cells[0].childNodes[0].checked){
            if(city==""){ error_msg_alert("Select City at row "+(i+1)); return false; }
            if(hotel==""){ error_msg_alert("Select Hotel at row "+(i+1)); return false;}
            hotels_array.push({          
                            'city_id':city,
                            'hotel_id':hotel
            });
          }
        }
        images_array.push({
          'display_status'  : display_status,
          'hotels'    : hotels_array
        });
      }
      //Best selling activities
      else if(activeTab[1] == 'activities'){
        display_status = $('#display_status2').val();
        // Footer CMS
        if(display_status==''){
          error_msg_alert("Please Select Display Status"); return false;
        }
        var images_array = new Array();
        var activities_array = new Array();
        var table = document.getElementById("tbl_activities");
        var rowCount = table.rows.length;
        //Max 6 activities validation
        var count = 0;
        for(var i=0; i<rowCount; i++){
          var row = table.rows[i];
          if(row.cells[0].childNodes[0].checked){
            count++;
          }
        }
        if(count > 6){
          error_msg_alert('Max 6 activities can add,you can deselect some of them!'); return false;
        }
        for(var i=0; i<rowCount; i++){
          var row = table.rows[i];
          var city = row.cells[2].childNodes[0].value;
          var exc = row.cells[3].childNodes[0].value;

          if(row.cells[0].childNodes[0].checked){
            if(city==""){ error_msg_alert("Select City at row "+(i+1)); return false; }
            if(exc==""){ error_msg_alert("Select Excursion at row "+(i+1)); return false;}
            activities_array.push({          
                            'city_id':city,
                            'exc_id':exc
            });
          }
        }
        images_array.push({
          'display_status'  : display_status,
          'activities'    : activities_array
        });
      }
      //Best selling tours
      else if(activeTab[1] == 'tours'){
        display_status = $('#display_status3').val();
        // Footer CMS
        if(display_status==''){
          error_msg_alert("Please Select Display Status"); return false;
        }
        var images_array = new Array();
        var tours_array = new Array();
        var table = document.getElementById("tbl_dest_packages");
        var rowCount = table.rows.length;
        //Max 6 tours validation
        var count = 0;
        for(var i=0; i<rowCount; i++){
          var row = table.rows[i];
          if(row.cells[0].childNodes[0].checked){
            count++;
          }
        }
        if(count > 6){
          error_msg_alert('Max 6 tours can add,you can deselect some of them!'); return false;
        }
        for(var i=0; i<rowCount; i++){
          var row = table.rows[i];
          var dest_id = row.cells[2].childNodes[0].value;
          var package = row.cells[3].childNodes[0].value;

          if(row.cells[0].childNodes[0].checked){
            if(dest_id==""){ error_msg_alert("Select Destination at row "+(i+1)); return false; }
            if(package==""){ error_msg_alert("Select Package at row "+(i+1)); return false;}
            tours_array.push({          
                            'dest_id':dest_id,
                            'package_id':package
            });
          }
        }
        images_array.push({
          'display_status'  : display_status,
          'tours'    : tours_array
        });
      }
      //Best selling tours
      else if(activeTab[1] == 'terms'){
        var images_array = new Array();
        var terms_cond = $("#terms_cond").val();
        var privacy = $("#privacy").val();
        var cancellation = $("#cancellation").val();
        var refund = $("#refund").val();
        var careers = $("#careers").val();
        var copyright_text = $("#copyright_text").val();
        var flag1 = validate_char_size("copyright_text",40);
        if(!flag1){
          return false;
        }
        images_array.push({
          'terms_cond'  : terms_cond,
          'privacy_policy'    : privacy,
          'cancellation_policy':cancellation,
          'refund_policy':refund,
          'careers_policy':careers,
          'copyright_text':copyright_text
        });

      }
      // Footer CMS End
    }

    $('#btn_save').button('loading');
    $.ajax({
    type:'post',
    url: base_url+'controller/b2b_settings/cms/cms_save.php',
    data:{ section_name : section_name,display_status:display_status, banner_images : images_array,activeTab:activeTab[1]},
      success: function(message){
          $('#btn_save').button('reset');
          var data = message.split('--');
          if(data[0] == 'erorr'){
            error_msg_alert(data[1]);
          }else{
            success_msg_alert(data[1]);
            if(section_name == '1'){
              load_images();
              document.getElementById('banner_count').selectedIndex=0;
              banner_images_reflect('banner_count');
            }
            else if(section_name == '2' || section_name == '4'|| section_name == '5' || section_name == '6'||section_name == '7' || section_name == '8' || section_name == '9' || section_name == '10'){
              $.post('cms/get_selected_section.php', { section_name : section_name}, function(data){
                $('#section_data_form').html(data);
              });
            }
            else if(section_name == '3'){
              document.getElementById('ideas_count').selectedIndex=0;
              ideas_data_reflect();
              $('#images_list').html('');
            }
          }
      }
    });
  }
  })
});
</script>