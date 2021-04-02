<?php
include "../../model/model.php";
?>
<div class="row col-md-6 col-md-offset-3">
<div class="table-responsive">
<table class="table table-bordered table-hover text-left">
    <thead>
        <tr class="active table-heading-row">
            <th>S_No.</th>
            <th>Tour_Name</th>
            <th>Itinerary</th>
        </tr>  
    </thead>  
    <tbody>
    
        <?php
            $count=0;
            $sq = mysql_query("select tour_name, adnary_url from tour_master where adnary_url!=''");
            while($row = mysql_fetch_assoc($sq))
            {      
                $count++;   
                $newUrl = preg_replace('/(\/+)/','/',$row['adnary_url']);                
        ?>             
               <tr>                  
                <td><?php echo $count ?></td>                    
                <td><?php echo $row['tour_name'] ?></td>                    
                <td><a href="<?php echo $newUrl; ?>" class="btn btn-info btn-sm" download title="download"><i class="fa fa-download"></i></a></span></td>
               </tr> 
        <?php        
            }
        ?>
    </tbody>
</table>
</div>
</div>