<div class="row">
	<div class="col-md-12">
		<div class="profile_box main_block">
    	 	<?php 
               
				$count = 0;
				$sq_visa = mysql_fetch_assoc(mysql_query($query));
    	 	?>
               <span class="main_block">
	                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
	                  <?php echo "<label>Country Name <em>:</em></label>".$sq_visa['country_id'] ?>
	            </span>
	            <span class="main_block">
	                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
	                  <?php echo "<label>Type Of Visa <em>:</em></label> ".$sq_visa['visa_type'] ?>
	            </span>
	            <span class="main_block">
	                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
	                  <?php echo "<label>Basic Amount <em>:</em></label> ".number_format($sq_visa['fees'],2) ?>
	            </span>
	            <span class="main_block">
	                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
	                  <?php echo "<label>Markup cost<em>:</em></label> ".number_format($sq_visa['markup'],2) ?>
	            </span>
	            <span class="main_block">
	                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
	                  <?php echo "<label>Time Taken <em>:</em></label> ".$sq_visa['time_taken'] ?>
	            </span>
	            <?php
                if($sq_visa['upload_url']!=""){
                	$newUrl1 = preg_replace('/(\/+)/','/',$sq_visa['upload_url']); ?>	
                <span class="main_block">
                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
                  <?php echo "<label>Form 1 <em>:</em></label> "?><a href="<?php echo $newUrl1; ?>" download title="Download Form"><i class="fa fa-id-card-o"></i></a> 
                </span>
                <?php } ?>
	            <?php
                if($sq_visa['upload_url2']!=""){
                	$newUrl2 = preg_replace('/(\/+)/','/',$sq_visa['upload_url2']); ?>	
                <span class="main_block">
                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
                  <?php echo "<label>Form 2 <em>:</em></label> "?><a href="<?php echo $newUrl2; ?>" download title="Download Form"><i class="fa fa-id-card-o"></i></a> 
                </span>
                <?php } ?>	 	 

	            <div class="main_block">
	            <span class="main_block">
	                  <i class="fa fa-angle-double-right cost_arrow" aria-hidden="true"></i>
	                  <label>List Of Documents <em>:</em></label>
	            </span>
	            	<div class="">
	            		<?= $sq_visa['list_of_documents'] ?>
	            	</div>
	            </div>
		</div>
    </div>
</div>

