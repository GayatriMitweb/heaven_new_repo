<?php
include "../../../model/model.php";
?>
<div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
	
	<table class="table table-hover" id="fourth_attraction" style="margin: 20px 0 !important;">
		<thead>
        <tr class="table-heading-row">
            <th>S_No.</th>    
            <th  style="width:150px">Title</th>    
            <th>Description</th>    
            <th style="width:100px">Date</th>
            <th>Image</th>    
            <th>Edit</th>
            <th>Disable</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $count = 0;
        $sq = mysql_query("select * from fourth_coming_attraction_master where status!='Disabled'");
        while($row = mysql_fetch_assoc($sq))
        {
            $sq_img = mysql_fetch_assoc(mysql_query("select * from fourth_coming_att_images where fourth_id='$row[id]'"));
            $newUrl = $sq_img['upload'];
            if($newUrl!=""){
                $newUrl = preg_replace('/(\/+)/','/',$sq_img['upload']); 
                $newUrl_arr = explode('uploads/', $newUrl);
                $newUrl = BASE_URL.'uploads/'.$newUrl_arr[1];   
            }
            $count++;
         ?>
         <tr>
            <td><?php echo $count ?></td>
            <td><?php echo $row['title'] ?></td>
            <td><?php echo $row['description'] ?></td>
            <td><?php echo date("d/m/Y",strtotime($row['valid_date'])) ?></td>
            <td>
                <button class="btn btn-info btn-sm" onclick="view_modal(<?= $row['id'] ?>)" title="View Information"><i class="fa fa-eye"></i></button>
            </td>
            <td><a href="javascript:void(0)" onclick="fourth_coming_attractions_update_modal(<?= $row['id'] ?>)" class="btn btn-info btn-sm" title="Edit Detail"><i class="fa fa-pencil-square-o"></i></a></td>
            <td><button class="btn btn-danger btn-sm" onclick="fouth_coming_attractions_disable(<?php echo $row['id'] ?>)" title="Disable"><i class="fa fa-ban"></i></button></td>
            
         </tr>   
         <?php   
        }    
        ?>
        </tbody>
    </table>

</div> </div> </div>
<script type="text/javascript">
    $('#fourth_attraction').dataTable({
        "pagingType": "full_numbers"
    });
</script>