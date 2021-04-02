<?php
            //Group
              $enq_strong_g = mysql_query("select * from enquiry_master where enquiry_date between '$from_date1' and '$to_date1' and enquiry='Strong' and enquiry_type='Group Booking'"); 
              while($row_s= mysql_fetch_assoc($enq_strong_g)){
                $enquiry_content = $row_s['enquiry_content'];
                $enquiry_content_arr1 = json_decode($enquiry_content, true);
                foreach($enquiry_content_arr1 as $enquiry_content_arr2){
                    
                    if($enquiry_content_arr2['name']=="budget"){

                        $budget_s_g += $enquiry_content_arr2['value'];

                    }
                }
            }
            $enq_hot_g= mysql_query("select * from enquiry_master where enquiry_date between '$from_date1' and '$to_date1' and enquiry='Hot' and enquiry_type='Group Booking'"); 
              while($row_h= mysql_fetch_assoc($enq_hot_g)){
                $enquiry_content = $row_h['enquiry_content'];
                $enquiry_content_arr1 = json_decode($enquiry_content, true);
                foreach($enquiry_content_arr1 as $enquiry_content_arr2){
                    
                    if($enquiry_content_arr2['name']=="budget"){

                        $budget_h_g += $enquiry_content_arr2['value'];

                    }
                }
            }

            $enq_cold_g = mysql_query("select * from enquiry_master where enquiry_date between '$from_date1' and '$to_date1' and enquiry='Cold' and enquiry_type='Group Booking'"); 
              while($row_c= mysql_fetch_assoc($enq_cold_g)){
                $enquiry_content = $row_c['enquiry_content'];
                $enquiry_content_arr1 = json_decode($enquiry_content, true);
                foreach($enquiry_content_arr1 as $enquiry_content_arr2){
                    
                    if($enquiry_content_arr2['name']=="budget"){

                        $budget_c_g += $enquiry_content_arr2['value'];

                    }
                }
            }
            //Package
             $enq_strong_p = mysql_query("select * from enquiry_master where enquiry_date between '$from_date1' and '$to_date1' and enquiry='Strong' and enquiry_type='Package Booking'"); 
              while($row_s= mysql_fetch_assoc($enq_strong_p)){
                $enquiry_content = $row_s['enquiry_content'];
                $enquiry_content_arr1 = json_decode($enquiry_content, true);
                foreach($enquiry_content_arr1 as $enquiry_content_arr2){
                    
                    if($enquiry_content_arr2['name']=="budget"){

                        $budget_s_p += $enquiry_content_arr2['value'];

                    }
                }
            }
            $enq_hot_p= mysql_query("select * from enquiry_master where enquiry_date between '$from_date1' and '$to_date1' and enquiry='Hot' and enquiry_type='Package Booking'"); 
              while($row_h= mysql_fetch_assoc($enq_hot_p)){
                $enquiry_content = $row_h['enquiry_content'];
                $enquiry_content_arr1 = json_decode($enquiry_content, true);
                foreach($enquiry_content_arr1 as $enquiry_content_arr2){
                    
                    if($enquiry_content_arr2['name']=="budget"){

                        $budget_h_p += $enquiry_content_arr2['value'];

                    }
                }
            }

            $enq_cold_p = mysql_query("select * from enquiry_master where enquiry_date between '$from_date1' and '$to_date1' and enquiry='Cold' and enquiry_type='Package Booking'"); 
              while($row_c= mysql_fetch_assoc($enq_cold_p)){
                $enquiry_content = $row_c['enquiry_content'];
                $enquiry_content_arr1 = json_decode($enquiry_content, true);
                foreach($enquiry_content_arr1 as $enquiry_content_arr2){
                    
                    if($enquiry_content_arr2['name']=="budget"){

                        $budget_c_p += $enquiry_content_arr2['value'];

                    }
                }
            }
            //Flight
             $enq_strong_f = mysql_query("select * from enquiry_master where enquiry_date between '$from_date1' and '$to_date1' and enquiry='Strong' and enquiry_type='Flight Ticket'"); 
              while($row_s= mysql_fetch_assoc($enq_strong_f)){
                $enquiry_content = $row_s['enquiry_content'];
                $enquiry_content_arr1 = json_decode($enquiry_content, true);
                foreach($enquiry_content_arr1 as $enquiry_content_arr2){
                    
                    if($enquiry_content_arr2['name']=="budget"){

                        $budget_s_f += $enquiry_content_arr2['value'];

                    }
                }
            }
            $enq_hot_f= mysql_query("select * from enquiry_master where enquiry_date between '$from_date1' and '$to_date1' and enquiry='Hot' and enquiry_type='Flight Ticket'"); 
              while($row_h= mysql_fetch_assoc($enq_hot_f)){
                $enquiry_content = $row_h['enquiry_content'];
                $enquiry_content_arr1 = json_decode($enquiry_content, true);
                foreach($enquiry_content_arr1 as $enquiry_content_arr2){
                    
                    if($enquiry_content_arr2['name']=="budget"){

                        $budget_h_f += $enquiry_content_arr2['value'];

                    }
                }
            }

            $enq_cold_f = mysql_query("select * from enquiry_master where enquiry_date between '$from_date1' and '$to_date1' and enquiry='Cold' and enquiry_type='Train Ticket'"); 
              while($row_c= mysql_fetch_assoc($enq_cold_f)){
                $enquiry_content = $row_c['enquiry_content'];
                $enquiry_content_arr1 = json_decode($enquiry_content, true);
                foreach($enquiry_content_arr1 as $enquiry_content_arr2){
                    
                    if($enquiry_content_arr2['name']=="budget"){

                        $budget_c_f += $enquiry_content_arr2['value'];

                    }
                }
            }

            //Train
             $enq_strong_t = mysql_query("select * from enquiry_master where enquiry_date between '$from_date1' and '$to_date1' and enquiry='Strong' and enquiry_type='Train Ticket'"); 
              while($row_s= mysql_fetch_assoc($enq_strong_t)){
                $enquiry_content = $row_s['enquiry_content'];
                $enquiry_content_arr1 = json_decode($enquiry_content, true);
                foreach($enquiry_content_arr1 as $enquiry_content_arr2){
                    
                    if($enquiry_content_arr2['name']=="budget"){

                        $budget_s_t += $enquiry_content_arr2['value'];

                    }
                }
            }
            $enq_hot_t= mysql_query("select * from enquiry_master where enquiry_date between '$from_date1' and '$to_date1' and enquiry='Hot' and enquiry_type='Train Ticket'"); 
              while($row_h= mysql_fetch_assoc($enq_hot_t)){
                $enquiry_content = $row_h['enquiry_content'];
                $enquiry_content_arr1 = json_decode($enquiry_content, true);
                foreach($enquiry_content_arr1 as $enquiry_content_arr2){
                    
                    if($enquiry_content_arr2['name']=="budget"){

                        $budget_h_t += $enquiry_content_arr2['value'];

                    }
                }
            }

            $enq_cold_t = mysql_query("select * from enquiry_master where enquiry_date between '$from_date1' and '$to_date1' and enquiry='Cold' and enquiry_type='Train Ticket'"); 
              while($row_c= mysql_fetch_assoc($enq_cold_t)){
                $enquiry_content = $row_c['enquiry_content'];
                $enquiry_content_arr1 = json_decode($enquiry_content, true);
                foreach($enquiry_content_arr1 as $enquiry_content_arr2){
                    
                    if($enquiry_content_arr2['name']=="budget"){

                        $budget_c_t += $enquiry_content_arr2['value'];

                    }
                }
            }

            //visa
             $enq_strong_v = mysql_query("select * from enquiry_master where enquiry_date between '$from_date1' and '$to_date1' and enquiry='Strong' and enquiry_type='Visa'"); 
              while($row_s= mysql_fetch_assoc($enq_strong_v)){
                $enquiry_content = $row_s['enquiry_content'];
                $enquiry_content_arr1 = json_decode($enquiry_content, true);
                foreach($enquiry_content_arr1 as $enquiry_content_arr2){
                    
                    if($enquiry_content_arr2['name']=="budget"){

                        $budget_s_v += $enquiry_content_arr2['value'];

                    }
                }
            }
            $enq_hot_v= mysql_query("select * from enquiry_master where enquiry_date between '$from_date1' and '$to_date1' and enquiry='Hot' and enquiry_type='Visa'"); 
              while($row_h= mysql_fetch_assoc($enq_hot_v)){
                $enquiry_content = $row_h['enquiry_content'];
                $enquiry_content_arr1 = json_decode($enquiry_content, true);
                foreach($enquiry_content_arr1 as $enquiry_content_arr2){
                    
                    if($enquiry_content_arr2['name']=="budget"){

                        $budget_h_v += $enquiry_content_arr2['value'];

                    }
                }
            }

            $enq_cold_v = mysql_query("select * from enquiry_master where enquiry_date between '$from_date1' and '$to_date1' and enquiry='Cold' and enquiry_type='Visa'"); 
              while($row_c= mysql_fetch_assoc($enq_cold_v)){
                $enquiry_content = $row_c['enquiry_content'];
                $enquiry_content_arr1 = json_decode($enquiry_content, true);
                foreach($enquiry_content_arr1 as $enquiry_content_arr2){
                    
                    if($enquiry_content_arr2['name']=="budget"){

                        $budget_c_v += $enquiry_content_arr2['value'];

                    }
                }
            }


            //Hotel
             $enq_strong_h = mysql_query("select * from enquiry_master where enquiry_date between '$from_date1' and '$to_date1' and enquiry='Strong' and enquiry_type='Hotel'"); 
              while($row_s= mysql_fetch_assoc($enq_strong_h)){
                $enquiry_content = $row_s['enquiry_content'];
                $enquiry_content_arr1 = json_decode($enquiry_content, true);
                foreach($enquiry_content_arr1 as $enquiry_content_arr2){
                    
                    if($enquiry_content_arr2['name']=="budget"){

                        $budget_s_h += $enquiry_content_arr2['value'];

                    }
                }
            }
            $enq_hot_h= mysql_query("select * from enquiry_master where enquiry_date between '$from_date1' and '$to_date1' and enquiry='Hot' and enquiry_type='Hotel'"); 
              while($row_h= mysql_fetch_assoc($enq_hot_h)){
                $enquiry_content = $row_h['enquiry_content'];
                $enquiry_content_arr1 = json_decode($enquiry_content, true);
                foreach($enquiry_content_arr1 as $enquiry_content_arr2){
                    
                    if($enquiry_content_arr2['name']=="budget"){

                        $budget_h_h += $enquiry_content_arr2['value'];

                    }
                }
            }

            $enq_cold_h = mysql_query("select * from enquiry_master where enquiry_date between '$from_date1' and '$to_date1' and enquiry='Cold' and enquiry_type='Hotel'"); 
              while($row_c= mysql_fetch_assoc($enq_cold_h)){
                $enquiry_content = $row_c['enquiry_content'];
                $enquiry_content_arr1 = json_decode($enquiry_content, true);
                foreach($enquiry_content_arr1 as $enquiry_content_arr2){
                    
                    if($enquiry_content_arr2['name']=="budget"){

                        $budget_c_h += $enquiry_content_arr2['value'];

                    }
                }
            }

            //Passport
             $enq_strong_pp = mysql_query("select * from enquiry_master where enquiry_date between '$from_date1' and '$to_date1' and enquiry='Strong' and enquiry_type='Passport'"); 
              while($row_s= mysql_fetch_assoc($enq_strong_pp)){
                $enquiry_content = $row_s['enquiry_content'];
                $enquiry_content_arr1 = json_decode($enquiry_content, true);
                foreach($enquiry_content_arr1 as $enquiry_content_arr2){
                    
                    if($enquiry_content_arr2['name']=="budget"){

                        $budget_s_pp += $enquiry_content_arr2['value'];

                    }
                }
            }
            $enq_hot_pp= mysql_query("select * from enquiry_master where enquiry_date between '$from_date1' and '$to_date1' and enquiry='Hot' and enquiry_type='Passport'"); 
              while($row_h= mysql_fetch_assoc($enq_hot_pp)){
                $enquiry_content = $row_h['enquiry_content'];
                $enquiry_content_arr1 = json_decode($enquiry_content, true);
                foreach($enquiry_content_arr1 as $enquiry_content_arr2){
                    
                    if($enquiry_content_arr2['name']=="budget"){

                        $budget_h_pp += $enquiry_content_arr2['value'];

                    }
                }
            }

            $enq_cold_pp = mysql_query("select * from enquiry_master where enquiry_date between '$from_date1' and '$to_date1' and enquiry='Cold' and enquiry_type='Passport'"); 
              while($row_c= mysql_fetch_assoc($enq_cold_pp)){
                $enquiry_content = $row_c['enquiry_content'];
                $enquiry_content_arr1 = json_decode($enquiry_content, true);
                foreach($enquiry_content_arr1 as $enquiry_content_arr2){
                    
                    if($enquiry_content_arr2['name']=="budget"){

                        $budget_c_pp += $enquiry_content_arr2['value'];

                    }
                }
            }

             //Car Rental
             $enq_strong_c = mysql_query("select * from enquiry_master where enquiry_date between '$from_date1' and '$to_date1' and enquiry='Strong' and enquiry_type='Car Rental'"); 
              while($row_s= mysql_fetch_assoc($enq_strong_c)){
                $enquiry_content = $row_s['enquiry_content'];
                $enquiry_content_arr1 = json_decode($enquiry_content, true);
                foreach($enquiry_content_arr1 as $enquiry_content_arr2){
                    
                    if($enquiry_content_arr2['name']=="budget"){

                        $budget_s_c += $enquiry_content_arr2['value'];

                    }
                }
            }
            $enq_hot_c = mysql_query("select * from enquiry_master where enquiry_date between '$from_date1' and '$to_date1' and enquiry='Hot' and enquiry_type='Car Rental'"); 
              while($row_h= mysql_fetch_assoc($enq_hot_c)){
                $enquiry_content = $row_h['enquiry_content'];
                $enquiry_content_arr1 = json_decode($enquiry_content, true);
                foreach($enquiry_content_arr1 as $enquiry_content_arr2){
                    
                    if($enquiry_content_arr2['name']=="budget"){

                        $budget_h_c += $enquiry_content_arr2['value'];

                    }
                }
            }

            $enq_cold_c = mysql_query("select * from enquiry_master where enquiry_date between '$from_date1' and '$to_date1' and enquiry='Cold' and enquiry_type='Car Rental'"); 
              while($row_c= mysql_fetch_assoc($enq_cold_c)){
                $enquiry_content = $row_c['enquiry_content'];
                $enquiry_content_arr1 = json_decode($enquiry_content, true);
                foreach($enquiry_content_arr1 as $enquiry_content_arr2){
                    
                    if($enquiry_content_arr2['name']=="budget"){

                        $budget_c_c += $enquiry_content_arr2['value'];

                    }
                }
            }


             //Bus
             $enq_strong_b = mysql_query("select * from enquiry_master where enquiry_date between '$from_date1' and '$to_date1' and enquiry='Strong' and enquiry_type='Bus'"); 
              while($row_s= mysql_fetch_assoc($enq_strong_b)){
                $enquiry_content = $row_s['enquiry_content'];
                $enquiry_content_arr1 = json_decode($enquiry_content, true);
                foreach($enquiry_content_arr1 as $enquiry_content_arr2){
                    
                    if($enquiry_content_arr2['name']=="budget"){

                        $budget_s_b += $enquiry_content_arr2['value'];

                    }
                }
            }
            $enq_hot_b = mysql_query("select * from enquiry_master where enquiry_date between '$from_date1' and '$to_date1' and enquiry='Hot' and enquiry_type='Bus'"); 
              while($row_h= mysql_fetch_assoc($enq_hot_b)){
                $enquiry_content = $row_h['enquiry_content'];
                $enquiry_content_arr1 = json_decode($enquiry_content, true);
                foreach($enquiry_content_arr1 as $enquiry_content_arr2){
                    
                    if($enquiry_content_arr2['name']=="budget"){

                        $budget_h_b += $enquiry_content_arr2['value'];

                    }
                }
            }

            $enq_cold_b = mysql_query("select * from enquiry_master where enquiry_date between '$from_date1' and '$to_date1' and enquiry='Cold' and enquiry_type='Bus'"); 
              while($row_c= mysql_fetch_assoc($enq_cold_b)){
                $enquiry_content = $row_c['enquiry_content'];
                $enquiry_content_arr1 = json_decode($enquiry_content, true);
                foreach($enquiry_content_arr1 as $enquiry_content_arr2){
                    
                    if($enquiry_content_arr2['name']=="budget"){

                        $budget_c_b += $enquiry_content_arr2['value'];

                    }
                }
            }
            ?>