
<?php 
include "../../../../../../model/model.php";
 
$from_date = $_GET['from_date'];
$to_date = $_GET['to_date'];
$role = $_SESSION['role'];
$branch_admin_id = $_SESSION['branch_admin_id'];
$branch_status = $_GET['branch_status'];
 
$from_date1 = date('Y-m-d', strtotime($from_date));
$to_date1 = date('Y-m-d', strtotime($to_date));
 $sq_pro = mysql_fetch_assoc(mysql_query("select * from sales_projection where from_date='$from_date1' and to_date='$to_date1'"));
?>

<form id="frm_save">
    <input type="hidden" id="from_date" value="<?= $from_date ?>">
    <input type="hidden" id="to_date" value="<?= $to_date ?>">
    <div class="row mg_tp_20"> <div class="col-md-12 no-pad"> <div class="table-responsive">
        
        <table class="table table-hover" id="tbl_list" style="margin: 20px 0 !important;">
            <thead>
                <tr class="table-heading-row">
                    <th>Sr.NO.</th>
                    <th>ENQUIRY Type</th>
                    <th>Strong_budget</th> 
                    <th>PROBABILITIES(%)</th>
                    <th>Hot_budget</th>
                    <th>PROBABILITIES(%)</th>
                    <th>Cold_budget</th>
                    <th>PROBABILITIES(%)</th>
                    <th class="text-right info">Sales Projection</th>
                </tr>
            
            </thead>
            <tbody>
                 <?php include_once('../budget_reflect.php'); ?>
                    <tr> 
                        <td>1</td>
                        <td>Group Tour</td>
                        <td id="bud_s_g"><?= $budget_s_g ?></td>
                        <td><input type="text" id="pro_s_g" name="pro_s_g" placeholder="ex.10%" title="PROBABILITIES OF SALES ID" onchange="number_validate(this.id);calculate_sale()" value="<?= $sq_pro['pro_s_g'] ?>"> </td>
                        <td id="bud_h_g"><?= $budget_h_g ?></td>
                        <td><input type="text" id="pro_h_g" name="pro_h_g" placeholder="ex.10%" title="PROBABILITIES OF SALES ID" onchange="number_validate(this.id);calculate_sale()" value="<?= $sq_pro['pro_h_g'] ?>"> </td>
                        <td id="bud_c_g"><?= $budget_c_g ?></td>
                        <td><input type="text" id="pro_c_g" name="pro_c_g" placeholder="ex.10%" title="PROBABILITIES OF SALES ID" onchange="number_validate(this.id);calculate_sale()" value="<?= $sq_pro['pro_c_g'] ?>"> </td>
                        <td class="text-right info" id="total_g" style="font-weight: bold;"><?= $sq_pro['total_g'] ?></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Package Tour</td>
                       <td id="bud_s_p"><?= $budget_s_p ?></td>
                        <td><input type="text" id="pro_s_p" name="pro_s_p" placeholder="ex.10%" title="PROBABILITIES OF SALES ID" onchange="number_validate(this.id);calculate_sale()" value="<?= $sq_pro['pro_s_p'] ?>"> </td>
                        <td id="bud_h_p"><?= $budget_h_p ?></td>
                        <td><input type="text" id="pro_h_p" name="pro_h_p" placeholder="ex.10%" title="PROBABILITIES OF SALES ID" onchange="number_validate(this.id);calculate_sale()" value="<?= $sq_pro['pro_h_p'] ?>"> </td>
                        <td id="bud_c_p"><?= $budget_c_p ?></td>
                        <td><input type="text" id="pro_c_p" name="pro_c_p" placeholder="ex.10%" title="PROBABILITIES OF SALES ID" onchange="number_validate(this.id);calculate_sale()" value="<?= $sq_pro['pro_c_p'] ?>"> </td>
                        <td class="text-right info" id="total_p" style="font-weight: bold;"><?= $sq_pro['total_p'] ?></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td> Flight Tour </td>
                      <td id="bud_s_f"><?= $budget_s_f ?></td>
                        <td><input type="text" id="pro_s_f" name="pro_s_f" placeholder="ex.10%" title="PROBABILITIES OF SALES ID" onchange="number_validate(this.id);calculate_sale()" value="<?= $sq_pro['pro_s_f'] ?>"> </td>
                        <td id="bud_h_f"><?= $budget_h_f ?></td>
                        <td><input type="text" id="pro_h_f" name="pro_h_f" placeholder="ex.10%" title="PROBABILITIES OF SALES ID" onchange="number_validate(this.id);calculate_sale()" value="<?= $sq_pro['pro_h_f'] ?>"> </td>
                        <td id="bud_c_f"><?= $budget_c_f ?></td>
                        <td><input type="text" id="pro_c_f" name="pro_c_f" placeholder="ex.10%" title="PROBABILITIES OF SALES ID" onchange="number_validate(this.id);calculate_sale()" value="<?= $sq_pro['pro_c_f'] ?>"> </td>
                        <td class="text-right info" id="total_f" style="font-weight: bold;"><?= $sq_pro['total_f'] ?></td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Train Ticket </td>
                        <td id="bud_s_t"><?= $budget_s_t ?></td>
                        <td><input type="text" id="pro_s_t" name="pro_s_t" placeholder="ex.10%" title="PROBABILITIES OF SALES ID" onchange="number_validate(this.id);calculate_sale()" value="<?= $sq_pro['pro_s_t'] ?>"> </td>
                        <td id="bud_h_t"><?= $budget_h_t ?></td>
                        <td><input type="text" id="pro_h_t" name="pro_h_t" placeholder="ex.10%" title="PROBABILITIES OF SALES ID" onchange="number_validate(this.id);calculate_sale()" value="<?= $sq_pro['pro_h_t'] ?>"> </td>
                        <td id="bud_c_t"><?= $budget_c_t ?></td>
                        <td><input type="text" id="pro_c_t" name="pro_c_t" placeholder="ex.10%" title="PROBABILITIES OF SALES ID" onchange="number_validate(this.id);calculate_sale()" value="<?= $sq_pro['pro_c_t'] ?>"> </td>
                        <td class="text-right info" id="total_t" style="font-weight: bold;"><?= $sq_pro['total_t'] ?></td>
                    </tr>
                     <tr> 
                        <td>5</td>
                        <td>Visa</td>
                        <td id="bud_s_v"><?= $budget_s_v ?></td>
                        <td><input type="text" id="pro_s_v" name="pro_s_v" placeholder="ex.10%" title="PROBABILITIES OF SALES ID" onchange="number_validate(this.id);calculate_sale()" value="<?= $sq_pro['pro_s_v'] ?>"> </td>
                        <td id="bud_h_v"><?= $budget_h_v ?></td>
                        <td><input type="text" id="pro_h_v" name="pro_h_v" placeholder="ex.10%" title="PROBABILITIES OF SALES ID" onchange="number_validate(this.id);calculate_sale()" value="<?= $sq_pro['pro_h_v'] ?>"> </td>
                        <td id="bud_c_v"><?= $budget_c_v ?></td>
                        <td><input type="text" id="pro_c_v" name="pro_c_v" placeholder="ex.10%" title="PROBABILITIES OF SALES ID" onchange="number_validate(this.id);calculate_sale()" value="<?= $sq_pro['pro_c_v'] ?>"> </td>
                        <td class="text-right info" id="total_v" style="font-weight: bold;"><?= $sq_pro['total_v'] ?></td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>Hotel</td>
                      <td id="bud_s_h"><?= $budget_s_h ?></td>
                        <td><input type="text" id="pro_s_h" name="pro_s_h" placeholder="ex.10%" title="PROBABILITIES OF SALES ID" onchange="number_validate(this.id);calculate_sale()" value="<?= $sq_pro['pro_s_h'] ?>"> </td>
                        <td id="bud_h_h"><?= $budget_h_h ?></td>
                        <td><input type="text" id="pro_h_h" name="pro_h_h" placeholder="ex.10%" title="PROBABILITIES OF SALES ID" onchange="number_validate(this.id);calculate_sale()" value="<?= $sq_pro['pro_h_h'] ?>"> </td>
                        <td id="bud_c_h"><?= $budget_c_h ?></td>
                        <td><input type="text" id="pro_c_h" name="pro_c_h" placeholder="ex.10%" title="PROBABILITIES OF SALES ID" onchange="number_validate(this.id);calculate_sale()" value="<?= $sq_pro['pro_c_h'] ?>"> </td>
                        <td class="text-right info" id="total_h" style="font-weight: bold;"><?= $sq_pro['total_h'] ?></td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td>Passport </td>
                      <td id="bud_s_pp"><?= $budget_s_pp ?></td>
                        <td><input type="text" id="pro_s_pp" name="pro_s_pp" placeholder="ex.10%" title="PROBABILITIES OF SALES ID" onchange="number_validate(this.id);calculate_sale()" value="<?= $sq_pro['pro_s_pp'] ?>"> </td>
                        <td id="bud_h_pp"><?= $budget_h_pp ?></td>
                        <td><input type="text" id="pro_h_pp" name="pro_h_pp" placeholder="ex.10%" title="PROBABILITIES OF SALES ID" onchange="number_validate(this.id);calculate_sale()" value="<?= $sq_pro['pro_h_pp'] ?>"> </td>
                        <td id="bud_c_pp"><?= $budget_c_pp ?></td>
                        <td><input type="text" id="pro_c_pp" name="pro_c_pp" placeholder="ex.10%" title="PROBABILITIES OF SALES ID" onchange="number_validate(this.id);calculate_sale()" value="<?= $sq_pro['pro_c_pp'] ?>"> </td>
                        <td class="text-right info" id="total_pp" style="font-weight: bold;"><?= $sq_pro['total_pp'] ?></td>
                    </tr>
                    <tr>
                        <td>8</td>
                        <td>Car Rental </td>
                        <td id="bud_s_c"><?= $budget_s_c ?></td>
                        <td><input type="text" id="pro_s_c" name="pro_s_c" placeholder="ex.10%" title="PROBABILITIES OF SALES ID" onchange="number_validate(this.id);calculate_sale()" value="<?= $sq_pro['pro_s_c'] ?>"> </td>
                        <td id="bud_h_c"><?= $budget_h_c ?></td>
                        <td><input type="text" id="pro_h_c" name="pro_h_c" placeholder="ex.10%" title="PROBABILITIES OF SALES ID" onchange="number_validate(this.id);calculate_sale()" value="<?= $sq_pro['pro_h_c'] ?>"> </td>
                        <td id="bud_c_c"><?= $budget_c_c ?></td>
                        <td><input type="text" id="pro_c_c" name="pro_c_c" placeholder="ex.10%" title="PROBABILITIES OF SALES ID" onchange="number_validate(this.id);calculate_sale()" value="<?= $sq_pro['pro_c_c'] ?>"> </td>
                        <td class="text-right info" id="total_c" style="font-weight: bold;"><?= $sq_pro['total_c'] ?></td>
                    </tr>
                     <tr>
                        <td>9</td>
                        <td >Bus </td>
                        <td id="bud_s_b"><?= $budget_s_b ?></td>
                        <td><input type="text" id="pro_s_b" name="pro_s_b" placeholder="ex.10%" title="PROBABILITIES OF SALES ID" onchange="number_validate(this.id);calculate_sale()" value="<?= $sq_pro['pro_s_b'] ?>"> </td>
                        <td id="bud_h_b"><?= $budget_h_b ?></td>
                        <td><input type="text" id="pro_h_b" name="pro_h_b" placeholder="ex.10%" title="PROBABILITIES OF SALES ID" onchange="number_validate(this.id);calculate_sale()" value="<?= $sq_pro['pro_h_b'] ?>"> </td>
                        <td id="bud_c_b"><?= $budget_c_b ?></td>
                        <td><input type="text" id="pro_c_b" name="pro_c_b" placeholder="ex.10%" title="PROBABILITIES OF SALES ID" onchange="number_validate(this.id);calculate_sale()" value="<?= $sq_pro['pro_c_b'] ?>"> </td>
                        <td class="text-right info" id="total_b" style="font-weight: bold;"><?= $sq_pro['total_b'] ?></td>
                    </tr>
                     <tr> 
                        <td>10</td>
                        <td>Miscellaneous</td>
                        <td id="bud_s_ms"><?= $budget_s_ms ?></td>
                        <td><input type="text" id="pro_s_ms" name="pro_s_ms" placeholder="ex.10%" title="PROBABILITIES OF SALES ID" onchange="number_validate(this.id);calculate_sale()" value="<?= $sq_pro['pro_s_ms'] ?>"> </td>
                        <td id="bud_h_ms"><?= $budget_h_ms ?></td>
                        <td><input type="text" id="pro_h_ms" name="pro_h_ms" placeholder="ex.10%" title="PROBABILITIES OF SALES ID" onchange="number_validate(this.id);calculate_sale()" value="<?= $sq_pro['pro_h_ms'] ?>"> </td>
                        <td id="bud_c_ms"><?= $budget_c_ms ?></td>
                        <td><input type="text" id="pro_c_ms" name="pro_c_ms" placeholder="ex.10%" title="PROBABILITIES OF SALES ID" onchange="number_validate(this.id);calculate_sale()" value="<?= $sq_pro['pro_c_ms'] ?>"> </td>
                        <td class="text-right info" id="total_ms" style="font-weight: bold;"><?= $sq_pro['total_ms'] ?></td>
                    </tr>
                     
            </tbody>
            <tfoot>
                <tr class="active">
                    <th colspan="8" class="text-right info" style="font-weight: bold;">Total Sales Projection : </th>
                    <th class="text-right info" id="total" style="font-weight: bold;"><?= $sq_pro['total'] ?></th>
                </tr>
            </tfoot>
        </table>
        <div class="col-md-12 text-center">

             <button id="btn_save" class="btn btn-success" onclick="save_projection()"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>

        </div>

    </div> </div> </div>
    

</form>
 
<script>
//$('#tbl_list').dataTable({"pagingType": "full_numbers"});
function calculate_sale()
{
    //Group
    var bud_strong_g = document.getElementById("bud_s_g").innerText;
    var bud_hot_g = document.getElementById("bud_h_g").innerText;
    var bud_cold_g = document.getElementById("bud_c_g").innerText;
    var pro_s_g = document.getElementById("pro_s_g").value;
    var pro_h_g = document.getElementById("pro_h_g").value;
    var pro_c_g = document.getElementById("pro_c_g").value;
 
    if(bud_strong_g==""){ bud_strong_g=0; }
    if(bud_hot_g=="") { bud_hot_g=0; }
    if(bud_cold_g=="") { bud_cold_g=0; }
    if(pro_s_g==""){ pro_s_g=0; }
    if(pro_h_g=="") { pro_h_g=0; }
    if(pro_c_g=="") { pro_c_g=0; }

    var total_strong_g = parseFloat((bud_strong_g * pro_s_g)/100);
    var total_hot_g = parseFloat((bud_hot_g * pro_h_g)/100);
    var total_cold_g = parseFloat((bud_cold_g * pro_c_g)/100);
 
    var total_g = parseFloat(total_strong_g + total_hot_g + total_cold_g );

    document.getElementById('total_g').innerHTML = total_g.toFixed(2);
 
 //Package
    var bud_strong_p = document.getElementById("bud_s_p").innerText;
    var bud_hot_p = document.getElementById("bud_h_p").innerText;
    var bud_cold_p = document.getElementById("bud_c_p").innerText;
    var pro_s_p = document.getElementById("pro_s_p").value;
    var pro_h_p = document.getElementById("pro_h_p").value;
    var pro_c_p = document.getElementById("pro_c_p").value;
 
    if(bud_strong_p==""){ bud_strong_p=0; }
    if(bud_hot_p=="") { bud_hot_p=0; }
    if(bud_cold_p=="") { bud_cold_p=0; }
    if(pro_s_p==""){ pro_s_p=0; }
    if(pro_h_p=="") { pro_h_p=0; }
    if(pro_c_p=="") { pro_c_p=0; }

    var total_strong_p = parseFloat((bud_strong_p * pro_s_p)/100);
    var total_hot_p = parseFloat((bud_hot_p * pro_h_p)/100);
    var total_cold_p = parseFloat((bud_cold_p * pro_c_p)/100);
 
    var total_p = parseFloat(total_strong_p + total_hot_p + total_cold_p );

    document.getElementById('total_p').innerHTML = total_p.toFixed(2);


 //Flight
    var bud_strong_f = document.getElementById("bud_s_f").innerText;
    var bud_hot_f = document.getElementById("bud_h_f").innerText;
    var bud_cold_f = document.getElementById("bud_c_f").innerText;
    var pro_s_f = document.getElementById("pro_s_f").value;
    var pro_h_f = document.getElementById("pro_h_f").value;
    var pro_c_f = document.getElementById("pro_c_f").value;
 
    if(bud_strong_f==""){ bud_strong_f=0; }
    if(bud_hot_f=="") { bud_hot_f=0; }
    if(bud_cold_f=="") { bud_cold_f=0; }
    if(pro_s_f==""){ pro_s_f=0; }
    if(pro_h_f=="") { pro_h_f=0; }
    if(pro_c_f=="") { pro_c_f=0; }

    var total_strong_f = parseFloat((bud_strong_f * pro_s_f)/100);
    var total_hot_f = parseFloat((bud_hot_f * pro_h_f)/100);
    var total_cold_f = parseFloat((bud_cold_f * pro_c_f)/100);
 
    var total_f = parseFloat(total_strong_f + total_hot_f + total_cold_f );

    document.getElementById('total_f').innerHTML = total_f.toFixed(2);


 //Train
    var bud_strong_t = document.getElementById("bud_s_t").innerText;
    var bud_hot_t = document.getElementById("bud_h_t").innerText;
    var bud_cold_t = document.getElementById("bud_c_t").innerText;
    var pro_s_t = document.getElementById("pro_s_t").value;
    var pro_h_t = document.getElementById("pro_h_t").value;
    var pro_c_t = document.getElementById("pro_c_t").value;
 
    if(bud_strong_t==""){ bud_strong_t=0; }
    if(bud_hot_t=="") { bud_hot_t=0; }
    if(bud_cold_t=="") { bud_cold_t=0; }
    if(pro_s_t==""){ pro_s_t=0; }
    if(pro_h_t=="") { pro_h_t=0; }
    if(pro_c_t=="") { pro_c_t=0; }

    var total_strong_t = parseFloat((bud_strong_t * pro_s_t)/100);
    var total_hot_t = parseFloat((bud_hot_t * pro_h_t)/100);
    var total_cold_t = parseFloat((bud_cold_t * pro_c_t)/100);
 
    var total_t = parseFloat(total_strong_t + total_hot_t + total_cold_t );

    document.getElementById('total_t').innerHTML = total_t.toFixed(2);

    //Visa
    var bud_strong_v = document.getElementById("bud_s_v").innerText;
    var bud_hot_v = document.getElementById("bud_h_v").innerText;
    var bud_cold_v = document.getElementById("bud_c_v").innerText;
    var pro_s_v = document.getElementById("pro_s_v").value;
    var pro_h_v = document.getElementById("pro_h_v").value;
    var pro_c_v = document.getElementById("pro_c_v").value;

    if(bud_strong_v==""){ bud_strong_v=0; }
    if(bud_hot_v=="") { bud_hot_v=0; }
    if(bud_cold_v=="") { bud_cold_v=0; }
    if(pro_s_v==""){ pro_s_v=0; }
    if(pro_h_v=="") { pro_h_v=0; }
    if(pro_c_v=="") { pro_c_v=0; }

    var total_strong_v = parseFloat((bud_strong_v * pro_s_v)/100);
    var total_hot_v = parseFloat((bud_hot_v * pro_h_v)/100);
    var total_cold_v = parseFloat((bud_cold_v * pro_c_v)/100);
 
    var total_v = parseFloat(total_strong_v + total_hot_v + total_cold_v );

    document.getElementById('total_v').innerHTML = total_v.toFixed(2);

    //Hotel
    var bud_strong_h = document.getElementById("bud_s_h").innerText;
    var bud_hot_h = document.getElementById("bud_h_h").innerText;
    var bud_cold_h = document.getElementById("bud_c_h").innerText;
    var pro_s_h = document.getElementById("pro_s_h").value;
    var pro_h_h = document.getElementById("pro_h_h").value;
    var pro_c_h = document.getElementById("pro_c_h").value;
 
    if(bud_strong_h==""){ bud_strong_h=0; }
    if(bud_hot_h=="") { bud_hot_h=0; }
    if(bud_cold_h=="") { bud_cold_h=0; }
    if(pro_s_h==""){ pro_s_h=0; }
    if(pro_h_h=="") { pro_h_h=0; }
    if(pro_c_h=="") { pro_c_h=0; }

    var total_strong_h = parseFloat((bud_strong_h * pro_s_h)/100);
    var total_hot_h = parseFloat((bud_hot_h * pro_h_h)/100);
    var total_cold_h = parseFloat((bud_cold_h * pro_c_h)/100);
 
    var total_h = parseFloat(total_strong_h + total_hot_h + total_cold_h );

    document.getElementById('total_h').innerHTML = total_h.toFixed(2);


    //passport
    var bud_strong_pp = document.getElementById("bud_s_pp").innerText;
    var bud_hot_pp = document.getElementById("bud_h_pp").innerText;
    var bud_cold_pp = document.getElementById("bud_c_pp").innerText;
    var pro_s_pp = document.getElementById("pro_s_pp").value;
    var pro_h_pp = document.getElementById("pro_h_pp").value;
    var pro_c_pp = document.getElementById("pro_c_pp").value;
 
    if(bud_strong_pp==""){ bud_strong_pp=0; }
    if(bud_hot_pp=="") { bud_hot_pp=0; }
    if(bud_cold_pp=="") { bud_cold_pp=0; }
    if(pro_s_pp==""){ pro_s_pp=0; }
    if(pro_h_pp=="") { pro_h_pp=0; }
    if(pro_c_pp=="") { pro_c_pp=0; }

    var total_strong_pp = parseFloat((bud_strong_pp * pro_s_pp)/100);
    var total_hot_pp = parseFloat((bud_hot_pp * pro_h_pp)/100);
    var total_cold_pp = parseFloat((bud_cold_pp * pro_c_pp)/100);
 
    var total_pp = parseFloat(total_strong_pp + total_hot_pp + total_cold_pp );

    document.getElementById('total_pp').innerHTML = total_pp.toFixed(2);

     //Car 
    var bud_strong_c = document.getElementById("bud_s_c").innerText;
    var bud_hot_c = document.getElementById("bud_h_c").innerText;
    var bud_cold_c = document.getElementById("bud_c_c").innerText;
    var pro_s_c = document.getElementById("pro_s_c").value;
    var pro_h_c = document.getElementById("pro_h_c").value;
    var pro_c_c = document.getElementById("pro_c_c").value;
 
    if(bud_strong_c==""){ bud_strong_c=0; }
    if(bud_hot_c=="") { bud_hot_c=0; }
    if(bud_cold_c=="") { bud_cold_c=0; }
    if(pro_s_c==""){ pro_s_c=0; }
    if(pro_h_c=="") { pro_h_c=0; }
    if(pro_c_c=="") { pro_c_c=0; }

    var total_strong_c = parseFloat((bud_strong_c * pro_s_c)/100);
    var total_hot_c = parseFloat((bud_hot_c * pro_h_c)/100);
    var total_cold_c = parseFloat((bud_cold_c * pro_c_c)/100);
 
    var total_c = parseFloat(total_strong_c + total_hot_c + total_cold_c );

    document.getElementById('total_c').innerHTML = total_c.toFixed(2);

     //Bus
    var bud_strong_b = document.getElementById("bud_s_b").innerText;
    var bud_hot_b = document.getElementById("bud_h_b").innerText;
    var bud_cold_b = document.getElementById("bud_c_b").innerText;
    var pro_s_b = document.getElementById("pro_s_b").value;
    var pro_h_b = document.getElementById("pro_h_b").value;
    var pro_c_b = document.getElementById("pro_c_b").value;
 
    if(bud_strong_b==""){ bud_strong_b=0; }
    if(bud_hot_b=="") { bud_hot_b=0; }
    if(bud_cold_b=="") { bud_cold_b=0; }
    if(pro_s_b==""){ pro_s_b=0; }
    if(pro_h_b=="") { pro_h_b=0; }
    if(pro_c_b=="") { pro_c_b=0; }

    var total_strong_b = parseFloat((bud_strong_b * pro_s_b)/100);
    var total_hot_b = parseFloat((bud_hot_b * pro_h_b)/100);
    var total_cold_b = parseFloat((bud_cold_b * pro_c_b)/100);
 
    var total_b = parseFloat(total_strong_b + total_hot_b + total_cold_b );

    document.getElementById('total_b').innerHTML = total_b.toFixed(2);

     //Miscellaneous
    var bud_strong_ms = document.getElementById("bud_s_ms").innerText;
    var bud_hot_ms = document.getElementById("bud_h_ms").innerText;
    var bud_cold_ms = document.getElementById("bud_c_ms").innerText;
    var pro_s_ms = document.getElementById("pro_s_ms").value;
    var pro_h_ms = document.getElementById("pro_h_ms").value;
    var pro_c_ms = document.getElementById("pro_c_ms").value;

    if(bud_strong_ms==""){ bud_strong_ms=0; }
    if(bud_hot_ms=="") { bud_hot_ms=0; }
    if(bud_cold_ms=="") { bud_cold_ms=0; }
    if(pro_s_ms==""){ pro_s_ms=0; }
    if(pro_h_ms=="") { pro_h_ms=0; }
    if(pro_c_ms=="") { pro_c_ms=0; }

    var total_strong_ms = parseFloat((bud_strong_ms * pro_s_ms)/100);
    var total_hot_ms = parseFloat((bud_hot_ms * pro_h_ms)/100);
    var total_cold_ms = parseFloat((bud_cold_ms * pro_c_ms)/100);
 
    var total_ms = parseFloat(total_strong_ms + total_hot_ms + total_cold_ms );

    document.getElementById('total_ms').innerHTML = total_ms.toFixed(2);

    //Total
    var total = parseFloat(total_g) + parseFloat(total_p) + parseFloat(total_b) + parseFloat(total_c) + parseFloat(total_pp) + parseFloat(total_h) + parseFloat(total_v) + parseFloat(total_t) + parseFloat(total_f)+ parseFloat(total_ms);

    document.getElementById('total').innerHTML = total.toFixed(2);
    var from_date = $('#from_date').val();
    var to_date = $('#to_date').val();
    
    var base_url = $('#base_url').val();

       $.post( 
               base_url+"controller/sales_projection/budget_reflect.php",

               { total_g : total_g, total_p : total_p, total_b : total_b, total_c : total_c, total_pp : total_pp, total_h : total_h, total_v : total_v, total_ms : total_ms, total_t : total_t, total_f : total_f , total : total , from_date : from_date , to_date : to_date, bud_strong_g : bud_strong_g, bud_cold_g : bud_cold_g, bud_hot_g : bud_hot_g , bud_strong_p : bud_strong_p, bud_hot_p : bud_hot_p, bud_cold_p : bud_cold_p, bud_strong_v : bud_strong_v, bud_hot_v : bud_hot_v, bud_cold_v : bud_cold_v, bud_strong_f : bud_strong_f, bud_hot_f : bud_hot_f, bud_cold_f : bud_cold_f , bud_strong_ms : bud_strong_ms, bud_hot_ms : bud_hot_ms, bud_cold_ms : bud_cold_ms, bud_strong_t : bud_strong_t, bud_cold_t : bud_cold_t, bud_hot_t : bud_hot_t , bud_strong_pp : bud_strong_pp, bud_hot_pp : bud_hot_pp, bud_cold_pp : bud_cold_pp, bud_strong_h : bud_strong_h, bud_hot_h : bud_hot_h, bud_cold_h : bud_cold_h, bud_strong_c : bud_strong_c , bud_hot_c : bud_hot_c, bud_cold_c : bud_cold_c, bud_strong_b : bud_strong_b, bud_hot_b : bud_hot_b, bud_cold_b : bud_cold_b, pro_s_g : pro_s_g, pro_h_g : pro_h_g, pro_c_g : pro_c_g, pro_s_p : pro_s_p, pro_h_p : pro_h_p, pro_c_p : pro_c_p, pro_s_v : pro_s_v, pro_c_v : pro_c_v , pro_h_v : pro_h_v, pro_s_pp : pro_s_pp, pro_c_pp : pro_c_pp, pro_h_pp : pro_h_pp, pro_s_f : pro_s_f, pro_c_f : pro_c_f, pro_h_f : pro_h_f,pro_s_t : pro_s_t, pro_c_t : pro_c_t, pro_h_t : pro_h_t, pro_s_c : pro_s_c, pro_c_c : pro_c_c, pro_h_c : pro_h_c, pro_s_h : pro_s_h, pro_c_h : pro_c_h, pro_h_h : pro_h_h, pro_s_b : pro_s_b, pro_c_b : pro_c_b, pro_h_b : pro_h_b, pro_s_ms : pro_s_ms, pro_c_ms : pro_c_ms , pro_h_ms : pro_h_ms},
               function(data) {    

               });  

}
//
function save_projection()
{
    var bud_strong_g = document.getElementById("bud_s_g").innerText;
    var bud_hot_g = document.getElementById("bud_h_g").innerText;
    var bud_cold_g = document.getElementById("bud_c_g").innerText;
    var pro_s_g = document.getElementById("pro_s_g").value;
    var pro_h_g = document.getElementById("pro_h_g").value;
    var pro_c_g = document.getElementById("pro_c_g").value;
    var total_g = document.getElementById("total_g").innerText;
 
 //Package
    var bud_strong_p = document.getElementById("bud_s_p").innerText;
    var bud_hot_p = document.getElementById("bud_h_p").innerText;
    var bud_cold_p = document.getElementById("bud_c_p").innerText;
    var pro_s_p = document.getElementById("pro_s_p").value;
    var pro_h_p = document.getElementById("pro_h_p").value;
    var pro_c_p = document.getElementById("pro_c_p").value;
    var total_p =  document.getElementById('total_p').innerText;

 //Flight
    var bud_strong_f = document.getElementById("bud_s_f").innerText;
    var bud_hot_f = document.getElementById("bud_h_f").innerText;
    var bud_cold_f = document.getElementById("bud_c_f").innerText;
    var pro_s_f = document.getElementById("pro_s_f").value;
    var pro_h_f = document.getElementById("pro_h_f").value;
    var pro_c_f = document.getElementById("pro_c_f").value;
 
    var total_f =  document.getElementById('total_f').innerText;

 //Train
    var bud_strong_t = document.getElementById("bud_s_t").innerText;
    var bud_hot_t = document.getElementById("bud_h_t").innerText;
    var bud_cold_t = document.getElementById("bud_c_t").innerText;
    var pro_s_t = document.getElementById("pro_s_t").value;
    var pro_h_t = document.getElementById("pro_h_t").value;
    var pro_c_t = document.getElementById("pro_c_t").value;
    var total_t =  document.getElementById('total_t').innerText;

    //Visa
    var bud_strong_v = document.getElementById("bud_s_v").innerText;
    var bud_hot_v = document.getElementById("bud_h_v").innerText;
    var bud_cold_v = document.getElementById("bud_c_v").innerText;
    var pro_s_v = document.getElementById("pro_s_v").value;
    var pro_h_v = document.getElementById("pro_h_v").value;
    var pro_c_v = document.getElementById("pro_c_v").value;
 
    var total_v =   document.getElementById('total_v').innerText;
    //Hotel
    var bud_strong_h = document.getElementById("bud_s_h").innerText;
    var bud_hot_h = document.getElementById("bud_h_h").innerText;
    var bud_cold_h = document.getElementById("bud_c_h").innerText;
    var pro_s_h = document.getElementById("pro_s_h").value;
    var pro_h_h = document.getElementById("pro_h_h").value;
    var pro_c_h = document.getElementById("pro_c_h").value;
 
    var total_h =  document.getElementById('total_h').innerText;

    //passport
    var bud_strong_pp = document.getElementById("bud_s_pp").innerText;
    var bud_hot_pp = document.getElementById("bud_h_pp").innerText;
    var bud_cold_pp = document.getElementById("bud_c_pp").innerText;
    var pro_s_pp = document.getElementById("pro_s_pp").value;
    var pro_h_pp = document.getElementById("pro_h_pp").value;
    var pro_c_pp = document.getElementById("pro_c_pp").value;
 
    var total_pp = document.getElementById('total_pp').innerText;
     //Car 
    var bud_strong_c = document.getElementById("bud_s_c").innerText;
    var bud_hot_c = document.getElementById("bud_h_c").innerText;
    var bud_cold_c = document.getElementById("bud_c_c").innerText;
    var pro_s_c = document.getElementById("pro_s_c").value;
    var pro_h_c = document.getElementById("pro_h_c").value;
    var pro_c_c = document.getElementById("pro_c_c").value;
     
    var total_c =  document.getElementById('total_c').innerText;

     //Bus
    var bud_strong_b = document.getElementById("bud_s_b").innerText;
    var bud_hot_b = document.getElementById("bud_h_b").innerText;
    var bud_cold_b = document.getElementById("bud_c_b").innerText;
    var pro_s_b = document.getElementById("pro_s_b").value;
    var pro_h_b = document.getElementById("pro_h_b").value;
    var pro_c_b = document.getElementById("pro_c_b").value;
 
    var total_b = document.getElementById('total_b').innerText
    //Total
    var total = document.getElementById('total').innerText;
    var from_date = $('#from_date').val();
    var to_date = $('#to_date').val();
    var base_url = $('#base_url').val();

    $('#btn_save').button('loading');

            $.ajax({

              type: 'post',

              url: base_url+'controller/sales_projection/sales_projection_save.php',

              data:{ total_g : total_g, total_p : total_p, total_b : total_b, total_c : total_c, total_pp : total_pp, total_h : total_h, total_v : total_v, total_t : total_t, total_f : total_f , total : total , from_date : from_date , to_date : to_date, bud_strong_g : bud_strong_g, bud_cold_g : bud_cold_g, bud_hot_g : bud_hot_g , bud_strong_p : bud_strong_p, bud_hot_p : bud_hot_p, bud_cold_p : bud_cold_p, bud_strong_v : bud_strong_v, bud_hot_v : bud_hot_v, bud_cold_v : bud_cold_v, bud_strong_f : bud_strong_f, bud_hot_f : bud_hot_f, bud_cold_f : bud_cold_f , bud_strong_t : bud_strong_t, bud_cold_t : bud_cold_t, bud_hot_t : bud_hot_t , bud_strong_pp : bud_strong_pp, bud_hot_pp : bud_hot_pp, bud_cold_pp : bud_cold_pp, bud_strong_h : bud_strong_h, bud_hot_h : bud_hot_h, bud_cold_h : bud_cold_h, bud_strong_c : bud_strong_c , bud_hot_c : bud_hot_c, bud_cold_c : bud_cold_c, bud_strong_b : bud_strong_b, bud_hot_b : bud_hot_b, bud_cold_b : bud_cold_b , pro_s_g : pro_s_g, pro_h_g : pro_h_g, pro_c_g : pro_c_g, pro_s_p : pro_s_p, pro_h_p : pro_h_p, pro_c_p : pro_c_p, pro_s_v : pro_s_v, pro_c_v : pro_c_v , pro_h_v : pro_h_v, pro_s_pp : pro_s_pp, pro_c_pp : pro_c_pp, pro_h_pp : pro_h_pp, pro_s_f : pro_s_f, pro_c_f : pro_c_f, pro_h_f : pro_h_f,pro_s_t : pro_s_t, pro_c_t : pro_c_t, pro_h_t : pro_h_t, pro_s_c : pro_s_c, pro_c_c : pro_c_c, pro_h_c : pro_h_c, pro_s_h : pro_s_h, pro_c_h : pro_c_h, pro_h_h : pro_h_h, pro_s_b : pro_s_b, pro_c_b : pro_c_b, pro_h_b : pro_h_b },

              success: function(result){

                $('#btn_save').button('reset');
                msg_alert(result);
                //window.location.reload();

              }

            });


}

</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>
