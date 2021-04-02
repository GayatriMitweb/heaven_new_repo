<?php 
include "../../../../model/model.php";

?>
<div class="modal fade profile_box_modal" id="display_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
    	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      	<div class="modal-body profile_box profile_box_padding">
        	<div class="owl-carousel">
        		<div class="item">
        			<h3 class="text_caps text-center">Standard</h3>
                    <hr class="no-marg">
        			<img src="<?php echo BASE_URL ?>images/invoice_format/standard.jpg" class="img-responsive" style="max-height: initial !important;">
        		</div>
        		<div class="item">
        			<h3 class="text_caps text-center">Regular</h3>
                    <hr class="no-marg">
        			<img src="<?php echo BASE_URL ?>images/invoice_format/regular.jpg" class="img-responsive" style="max-height: initial !important;">
        		</div>
        		<div class="item">
        			<h3 class="text_caps text-center">Advance</h3>
                    <hr class="no-marg">
        			<img src="<?php echo BASE_URL ?>images/invoice_format/advance.jpg" class="img-responsive" style="max-height: initial !important;">
        		</div>
        		<div class="item">
        			<h3 class="text_caps text-center">Creative</h3>
                    <hr class="no-marg">
        			<img src="<?php echo BASE_URL ?>images/invoice_format/creative.jpg" class="img-responsive" style="max-height: initial !important;">
        		</div>
			 </div>
	  	</div>    
    </div>
  </div>
  
</div>

<script>
$('#display_modal').modal('show');
</script>
<script type="text/javascript">
	 $('.owl-carousel').owlCarousel({
        loop:true,
        margin:10,
        nav:false,
        pagination:false,
        autoPlay:false,
        singleItem:true,
        navigation:true,
        navigationText: ["<i class='fa fa-angle-left' aria-hidden='true'></i>", "<i class='fa fa-angle-right' aria-hidden='true'></i>"],
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:5
            }
        }
    })
</script>

<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>