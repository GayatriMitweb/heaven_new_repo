<?php
include "../../model/model.php";
/*======******Header******=======*/
require_once('../layouts/admin_header.php');
?>
<?= begin_panel('B2C CMS Settings','') ?>
<?php
if($setup_package == '4'){ ?>

<div class="div_left type-02">
  <ul class="nav nav-pills">
    <li role="presentation" class="dropdown active">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" onclick="reflect_data('11')">
		Header Strip Note
        </a>
    </li>
    <li role="presentation" class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" onclick="reflect_data('1')">
        Banner Images 
        </a>
    </li>
    <li role="presentation" class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" onclick="reflect_data('2')">
        Popular Package Tours 
        </a>
    </li>
    <li role="presentation" class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" onclick="reflect_data('3')">
        Popular Hotels 
        </a>
    </li>
    <li role="presentation" class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" onclick="reflect_data('4')">
        Popular Activities 
        </a>
    </li>
    <li role="presentation" class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" onclick="reflect_data('5')">
		Package Tours 
        </a>
    </li>
    <li role="presentation" class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" onclick="reflect_data('12')">
		Group Tours 
        </a>
    </li>
    <li role="presentation" class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" onclick="reflect_data('10')">
		Social Media 
        </a>
    </li>
    <li role="presentation" class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" onclick="reflect_data('7')">
		Enquiry/Book Button 
        </a>
    </li>
    <li role="presentation" class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" onclick="reflect_data('6')">
		Footer-Popular Holidays 
        </a>
    </li>
    <li role="presentation" class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" onclick="reflect_data('8')">
		Customer Testimonials 
        </a>
    </li>
    <li role="presentation" class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" onclick="reflect_data('9')">
		Policies 
        </a>
    </li>
    <li role="presentation" class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" onclick="reflect_data('13')">
		Blog 
        </a>
    </li>
    <li role="presentation" class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" onclick="reflect_data('14')">
		Gallery 
        </a>
    </li>    
	</ul>
</div>
<div class="div_right type-02">
    <div id="section_data_form"></div>
</div>

<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
<script src="<?php echo BASE_URL ?>js/app/field_validation.js"></script>
<script type="text/javascript">
function reflect_data(section,dest_id1=''){

    if(section === '1'){
        $.post('banners/index.php', { }, function(data){
            $('#section_data_form').html(data);
        });
    }
    if(section === '2'){
        $.post('package_tours/index.php', { }, function(data){
            $('#section_data_form').html(data);
        });
    }
    if(section === '3'){
        $.post('hotels/index.php', { }, function(data){
            $('#section_data_form').html(data);
        });
    }
    if(section === '4'){
        $.post('activities/index.php', { }, function(data){
            $('#section_data_form').html(data);
        });
    }
    if(section === '5'){
        $.post('package_tours_datewise/index.php', { }, function(data){
            $('#section_data_form').html(data);
        });
    }
    if(section === '12'){
        $.post('group_tours_datewise/index.php', { }, function(data){
            $('#section_data_form').html(data);
        });
    }
    if(section === '6'){
        $.post('footer_package_tours/index.php', { }, function(data){
            $('#section_data_form').html(data);
        });
    }
    if(section === '7'){
        $.post('enquiry_or_book/index.php', { }, function(data){
            $('#section_data_form').html(data);
        });
    }
    if(section === '8'){
        $.post('customer_testimonials.php', { }, function(data){
            $('#section_data_form').html(data);
        });
    }
    if(section === '9'){
        $.post('policies/index.php', { }, function(data){
            $('#section_data_form').html(data);
        });
    }
    if(section === '10'){
        $.post('social_media.php', { }, function(data){
            $('#section_data_form').html(data);
        });
    }
    if(section === '11'){
        $.post('header_strip_note.php', { }, function(data){
            $('#section_data_form').html(data);
        });
    }
    if(section === '13'){
        $.post('blogs/index.php', { }, function(data){
            $('#section_data_form').html(data);
        });
    }
    if(section === '14'){
        $.post('gallery/index.php', { dest_id1 : dest_id1 }, function(data){
            $('#section_data_form').html(data);
        });
    }
    $('.type-02 .dropdown .dropdown-toggle').on('click',function(){
        $(this).parent('.dropdown').addClass('active').siblings().removeClass('active');
    })
}
reflect_data('11');

</script>
<?= end_panel() ?>
<?php
/*======******Footer******=======*/
require_once('../layouts/admin_footer.php'); 
?>
<?php } else{ ?>
 <div class="alert alert-danger" role="alert">
   Please upgrade the subscription to use this feature.
 </div>
<?php }?>