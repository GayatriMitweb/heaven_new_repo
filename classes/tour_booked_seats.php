<?php

$bk_seats = new total_booked_seats();
class total_booked_seats 
{

	public function booked_seats($tour_id, $tour_group_id)
	{
	    $traveler_group=array();
	    $sq_1 = mysql_query("select traveler_group_id from tourwise_traveler_details where tour_id='$tour_id' and tour_group_id = '$tour_group_id'");
	    while($row_1 = mysql_fetch_assoc($sq_1))
	    {
	        array_push($traveler_group,$row_1['traveler_group_id']);
	    }
	    $query = "select * from travelers_details where ";
	    for($i=0; $i<sizeof($traveler_group); $i++)
	    {   
	        if($i>0)
	        {
	            $query = $query." or traveler_group_id= '$traveler_group[$i]'";
	        }
	        else
	        {    
	        $query = $query." ( traveler_group_id= '$traveler_group[$i]'";
	        }
	    }
	    $query = $query." ) and status='Active'";  
	    $booked_seats = mysql_num_rows(mysql_query($query));  
	   
	    return $booked_seats;
	}


}

?>