<form id="frm_tab_4">

<div class="app_panel"> 


 <!--=======Header panel======-->
    <div class="app_panel_head mg_bt_20">
        <div class="container">
            <h2 class="pull-left"></h2>
              <div class="pull-right header_btn">
                <button type="button" onclick="back_to_tab_3()">
                    <a>
                        <i class="fa fa-arrow-left"></i>
                    </a>
                </button>
              </div>
              <div class="pull-right header_btn">
                <button>
                    <a></a>
                </button>
              </div>
        </div>  
    </div> 

  <!--=======Header panel end======-->
    <div class="app_panel_content no-pad">
        <div class="container">
            <div class="row"> 
                <div class="panel panel-default panel-body main_block bg_light mg_bt_30">
                    <legend>Costing Details</legend>
                    <div class="bg_white main_block panel-default-inner">
                        <div class="main_block text-center">
                            <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
                            <small>&nbsp;</small>
                                <label for="txt_hotel_expenses">Tour Amount</label>
                                <input type="text" id="txt_hotel_expenses" name="txt_hotel_expenses" placeholder="Tour Amount" title="Tour Amount" onchange="validate_balance(this.id);calculate_tour_cost(this.id)" value="0">   
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
                            <small>&nbsp;</small>
                                <label for="txt_travel_total_expense1"> Travel Amount</label>
                                <input type="text" id="txt_travel_total_expense1" name="txt_travel_total_expense1" onchange="validate_balance(this.id);calculate_tour_cost(this.id)" placeholder="Travel Cost" title="Travel Cost"  readonly/>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
                              <small id="basic_show" style="color:#000000">&nbsp;</small>
                                <label for="total_basic_amt">Basic Amount</label>
                                <input type="text" id="total_basic_amt" class="text-right" name="total_basic_amt" onchange="calculate_tour_cost(this.id);get_auto_values('txt_booking_date','total_basic_amt','payment_mode','service_charge','markup','save','true','basic');validate_balance(this.id);" placeholder="Total Basic Cost" title="Total Basic Cost"  />
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
                            <small id="service_show" style="color:#000000">&nbsp;</small>
                                <label for="service_charge">Service Charge</label>
                                <input type="text" id="service_charge" name="service_charge" placeholder="Service Charge" title="Service Charge" onchange="get_auto_values('txt_booking_date','total_basic_amt','payment_mode','service_charge','markup','save','false','service_charge','discount');validate_balance(this.id);calculate_tour_cost(this.id)">    
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
                                <label for="txt_total_tour_cost">Subtotal</label>
                                <input type="text" id="subtotal" name="subtotal" placeholder="Subtotal" title="Subtotal" value="0" onchange="validate_balance(this.id); calculate_total_tour_cost()" readonly>    
                            </div>     <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs">
                                <label for="tour_service_tax_subtotal">Tax Subtotal</label>   
                                <input type="text" id="tour_service_tax_subtotal" name="tour_service_tax_subtotal" value="0" readonly>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10">
                            <label for="roundoff">Roundoff</label>
                                <input type="text" name="roundoff" id="roundoff" class="text-right" placeholder="Round Off" title="RoundOff" onchange=" calculate_total_tour_cost()" readonly>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <label for="txt_actual_tour_cost1">Total Tour Amount</label>
                                <input type="hidden" id="subtotal_with_rue" name="subtotal_with_rue" disabled>
                                <input type="text" id="txt_actual_tour_cost1" class="amount_feild_highlight text-right" name="txt_actual_tour_cost1" placeholder="Tour Amount" title="Tour Amount" readonly>
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs hidden">
                                <label for="currency_code">Currency</label>
                                <select name="currency_code" id="currency_code" style="width:100%" title="Currency">
                                    <?php 
                                    $sq_currency = mysql_query("select * from currency_name_master order by default_currency desc");
                                    while($row_currency = mysql_fetch_assoc($sq_currency)){
                                        ?>
                                        <option value="<?= $row_currency['currency_code'] ?>"><?= $row_currency['currency_code'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div> 
                        </div>
                        <div class="main_block text-center">
                            <div class="col-md-3 col-sm-6 col-xs-12 col-xs-12 mg_bt_10_xs hidden">
                                <label for="rue_cost">ROE</label>
                                <input type="text" id="rue_cost" name="rue_cost" onchange="calculate_total_tour_cost(); validate_balance(this.id)"   placeholder="ROE Cost" title="ROE Cost" value="1">
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs hidden">
                                <label for="txt_tour_service_tax">Tax</label>
                                <select name="tour_taxation_id" id="tour_taxation_id" title="Tax" onchange="generic_tax_reflect(this.id, 'txt_tour_service_tax', 'calculate_total_tour_cost');"><?php get_taxation_dropdown(); ?>
                                </select>
                                <input type="hidden" id="txt_tour_service_tax" name="txt_tour_service_tax" value="0">        
                            </div> 
                          
                        </div>
                    </div>
                </div>
                <div class="panel panel-default panel-body main_block bg_light mg_bt_30 hidden">
                    <legend>Visa & Insurance Details</legend>
                    <div class="bg_white main_block panel-default-inner">
                        <div class="main_block text-center">
                            <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
                                <input type="text" id="visa_country_name" onchange="validate_city(this.id)" name="visa_country_name" placeholder="Country Name" title="Country Name">
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
                                <input type="text" id="visa_amount" name="visa_amount" placeholder="Amount" title="Amount" onchange="validate_balance(this.id); calculate_total_tour_cost()" value="0">
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
                                <input type="text" id="visa_service_charge" name="visa_service_charge" placeholder="Service Charge" title="Service charge" class="text-right" value="0.00" onchange="validate_balance(this.id); calculate_total_tour_cost()" />            
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
                                <select name="visa_taxation_id" id="visa_taxation_id" title="Tax" placeholder="Tax" onchange="generic_tax_reflect(this.id, 'visa_service_tax', 'calculate_total_tour_cost');">
                                </select>
                                <input type="hidden" id="visa_service_tax" name="visa_service_tax" value="0">        
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
                                <input type="text" id="visa_service_tax_subtotal" name="plane_service_tax_subtotal" placeholder="Tax Amount" title="Tax Amount" readonly>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
                                <input type="text" id="visa_total_amount" class="amount_feild_highlight text-right" name="visa_total_amount" placeholder="Total Amount" title="Total Amount" onchange="validate_balance(this.id); calculate_total_tour_cost()" value="0" readonly>
                            </div>    
                        </div>
                        <div class="main_block text-center">
                            <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
                                <input type="text" id="insuarance_company_name" onchange="validate_specialChar(this.id)" name="insuarance_company_name" placeholder="Insurance Company" title="Insurance Company">
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
                                <input type="text" id="insuarance_amount" name="insuarance_amount" placeholder="Insurance Amount" title="Insurance Amount" placeholder="Insuarance Amount" onchange="validate_balance(this.id); calculate_total_tour_cost()" value="0">
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
                                <input type="text" id="insuarance_service_charge" name="insuarance_service_charge"  class="text-right" value="0.00" onchange="validate_balance(this.id); calculate_total_tour_cost()" placeholder="Service Charge" title="Service Charge" />            
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
                                <select name="insuarance_taxation_id" id="insuarance_taxation_id" title="Tax" placeholder="Tax" onchange="generic_tax_reflect(this.id, 'insuarance_service_tax', 'calculate_total_tour_cost');">
                                </select>
                                <input type="hidden" id="insuarance_service_tax" name="insuarance_service_tax" value="0">        
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
                                <input type="text" id="insuarance_service_tax_subtotal" name="plane_service_tax_subtotal" placeholder="Tax Amount" title="Tax Amount" readonly>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12">
                                <input type="text" id="insuarance_total_amount" class="amount_feild_highlight text-right" name="insuarance_total_amount" placeholder="Total Amount" title="Total Amount" onchange="validate_balance(this.id); calculate_total_tour_cost()" value="0" readonly>
                            </div>    
                        </div>
                    </div>
                </div>
                <div class="panel panel-default panel-body main_block bg_light mg_bt_30 hidden">
                    <legend>Total Tour Costing</legend>
                    <div class="bg_white main_block panel-default-inner">
                        <div class="main_block text-center mg_bt_10 ">
                            <div class="col-md-2 col-md-offset-1 col-sm-4 col-xs-12 mg_bt_10_xs hidden">
                                <label for="visa_total_amount1">Visa</label>
                                <input type="text" id="visa_total_amount1" name="visa_total_amount1" placeholder="Visa Amount" title="Visa Amount" onchange="validate_balance(this.id); calculate_total_tour_cost()" value="0" disabled>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs hidden">
                                <label for="visa_total_amount1">Insurance </label>
                                <input type="text" id="insuarance_total_amount1" name="insuarance_total_amount1" placeholder="Insuarance  Amount" title="Insuarance Amount" onchange="validate_balance(this.id);" value="0" disabled>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
                                <label for="txt_actual_tour_cost2">Tour</label>
                                <input type="text" id="txt_actual_tour_cost2" name="txt_actual_tour_cost2" placeholder="Tour Cost" title="Tour Cost" value="0" disabled>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
                                <label for="txt_actual_tour_cost">Total Tour Amount</label>
                                <input type="text" id="txt_actual_tour_cost" class="amount_feild_highlight text-right" name="txt_actual_tour_cost" placeholder="Tour Cost" title="Tour Cost" value="0" disabled>
                            </div>
                            <!-- <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
                                <label for="txt_travel_total_expense1">Total Travel Amount</label>
                                <input type="text" id="txt_travel_total_expense1" class="amount_feild_highlight text-right" name="txt_travel_total_expense1" value="0" placeholder="Total Travel Cost" title="Total Travel Cost" readonly />
                            </div> -->
                        </div>
                    </div>
                </div>
                <div class="panel panel-default panel-body main_block bg_light mg_bt_30">
                    <legend>Advance Receipt Details</legend>
                    <div class="bg_white main_block panel-default-inner">
                        <div class="col-xs-12">
                            <div class="panel panel-default panel-body pad_8 mg_tp_20 mg_bt_20 legend_pan bk_payment_wrap">
                                <div class="row">
                                    <div class="chk_wrap">
                                        <input type="checkbox" id="chk_pay_for_tour" style="float:left;" checked>
                                    </div>
                                    <div class="col-md-2 col-sm-4 mg_bt_10_xs mg_tp_10">
                                        <input type="text" id="txt_payment_date1" name="txt_payment_date1" placeholder="Date" value="<?php echo date('d-m-Y') ?>" title="Date" onchange="check_valid_date(this.id)"/>
                                    </div>
                                    <div class="col-md-2 col-sm-4 col-xs-12 text_center_xs mg_bt_10_xs mg_tp_10">
                                        <select id="cmb_payment_mode1" name="cmb_payment_mode1" title="Mode" onchange="payment_installment_enable_disable_fields('1');get_auto_values('txt_booking_date','total_basic_amt','payment_mode','service_charge','markup','save','true','basic','discount',true);get_identifier_block('identifier','cmb_payment_mode1','credit_card_details','credit_charges');get_credit_card_charges('identifier','cmb_payment_mode1','txt_amount1','credit_card_details','credit_charges')"><?php get_payment_mode_dropdown(); ?>
                                        </select>
                                    </div>
                                   
                                    <div class="col-md-2 col-sm-4 col-xs-12 text_center_xs mg_bt_10_xs mg_tp_10">
                                        <input type="text" id="txt_amount1" name="txt_amount1" placeholder="*Amount" title="Amount" onchange="validate_balance(this.id);payment_amount_validate(this.id,'cmb_payment_mode1','txt_transaction_id1','txt_bank_name1');get_credit_card_charges('identifier','cmb_payment_mode1','txt_amount1','credit_card_details','credit_charges');"  />
                                    </div>
                                    <div class="col-md-2 col-sm-4 col-xs-12 text_center_xs mg_bt_10_xs mg_tp_10">
                                        <input type="text" class="bank_suggest" id="txt_bank_name1" name="txt_bank_name1" placeholder="Bank Name" onchange="fname_validate(this.id)" title="Bank Name" disabled />
                                    </div>
                                    <div class="col-md-2 col-sm-4 col-xs-12 text_center_xs mg_bt_10_xs mg_tp_10">
                                        <input type="text" id="txt_transaction_id1" name="txt_transaction_id1" placeholder="Cheque No / ID" onchange="validate_specialChar(this.id)" title="Cheque No / ID" disabled />
                                    </div>
                                    <div class="col-md-2 col-sm-4 col-xs-12 text_center_xs mg_bt_10_xs mg_tp_10">
                                        <select name="bank_id1" id="bank_id1" placeholder="Select Bank" title="Select Bank" disabled>
                                            <?php get_bank_dropdown(); ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-sm-4 col-xs-12 text_center_xs mg_bt_10_xs mg_tp_10">
                                    <input class="hidden" type="text" id="credit_charges" name="credit_charges" title="Credit card charges" disabled>
                                    </div>
                                    <div class="col-md-2 col-sm-4 col-xs-12 text_center_xs mg_bt_10_xs mg_tp_10">
                                    <select class="hidden" id="identifier" onchange="get_credit_card_data('identifier','cmb_payment_mode1','credit_card_details')" title="Identifier(4 digit)" required
                                    ><option value=''>Select Identifier</option></select>
                                    </div>
                                    <div class="col-md-2 col-sm-4 col-xs-12 text_center_xs mg_bt_10_xs mg_tp_10">
                                    <input class="hidden" type="text" id="credit_card_details" name="credit_card_details" title="Credit card details" disabled>
                                    </div>


                                    <select style="display:none" id="cmb_payment_of_type1" name="cmb_payment_of_type1" disabled >
                                        <option value="Tour">Pay for tour</option>                                                       
                                    </select>    
                                    <select class="select-field-113" id="cmb_travel_of_type1" name="cmb_travel_of_type1" title="Travelling Type" style="margin-bottom:10px; display:none">
                                        <option value="">*Travelling Type</option>
                                        <option value="All"> All </option>
                                        <option value="Train">Train</option>
                                        <option value="Flight"> Flight </option>   
                                        <option value="Cruise"> Cruise </option>                            
                                    </select> 
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 hidden">
                            <div class="panel panel-default panel-body pad_8 legend_pan bk_payment_wrap" style="margin-top: 30px;">
                                <div class="row">
                                        <div class="chk_wrap">
                                            <input type="checkbox" id="chk_pay_for_traveling" style="float:left;">
                                        </div>
                                        <div class="col-md-2 col-sm-4 mg_bt_10_xs">
                                            <label class="legend_text">Travel</label>
                                            <input type="text" id="txt_payment_date2" value="<?php echo date('d-m-Y') ?>" name="txt_payment_date2" placeholder="Date" title="Date" onchange="check_valid_date(this.id)"/>
                                        </div>
                                        <div class="col-md-2 col-sm-4 col-xs-12 text_center_xs mg_bt_10_xs">
                                           <select id="cmb_payment_mode2" name="cmb_payment_mode2" title="Mode" onchange="payment_installment_enable_disable_fields('2')">
                                           <?php get_payment_mode_dropdown(); ?>
                                            </select> 
                                        </div>
                                        <div class="col-md-2 col-sm-4 col-xs-12 text_center_xs mg_bt_10_xs">
                                            <input type="text" id="txt_amount2" name="txt_amount2" placeholder="*Amount" title="Amount" onchange="validate_balance(this.id);payment_amount_validate(this.id,'cmb_payment_mode2','txt_transaction_id2','txt_bank_name2')"  />
                                        </div>
                                        <div class="col-md-2 col-sm-4 col-xs-12 text_center_xs mg_bt_10_xs">
                                           <input type="text" class="bank_suggest" id="txt_bank_name2" name="txt_bank_name2" placeholder="Bank Name" onchange="fname_validate(this.id)" title="Amount" disabled /> 
                                        </div>
                                        <div class="col-md-2 col-sm-4 col-xs-12 text_center_xs mg_bt_10_xs">
                                            <input type="text" id="txt_transaction_id2" name="txt_transaction_id2" placeholder="Cheque No / ID" onchange="validate_specialChar(this.id)" title="Cheque No / ID"disabled />
                                        </div>
                                        <div class="col-md-2 col-sm-4 col-xs-12 text_center_xs mg_bt_10_xs">
                                            <select id="cmb_travel_of_type2" name="cmb_travel_of_type2">
                                                <option value=""> *Travelling Type </option>
                                                <option value="All"> All </option>
                                                <option value="Train">Train</option>
                                                <option value="Flight"> Flight </option>   
                                                <option value="Cruise"> Cruise </option>                          
                                            </select> 
                                        </div>
                                        <div class="col-md-2 col-sm-4 col-xs-12 text_center_xs mg_tp_10">
                                            <select name="bank_id2" id="bank_id2" title="Select Bank" disabled>
                                                <?php get_bank_dropdown(); ?>
                                            </select>
                                        </div>
                                        <select style="display:none" id="cmb_payment_of_type2" disabled >
                                            <option value="Travelling">Pay for traveling</option>                                                      
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <div class="row">
                          <div class="col-md-9 col-sm-9">
                           <span style="color: red;line-height: 35px;" data-original-title="" title="" class="note"><?= $txn_feild_note ?></span>
                         </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default panel-body main_block bg_light mg_bt_30">
                    <legend>Booking Summary</legend>
                    <div class="bg_white main_block panel-default-inner">
                        <?php date_default_timezone_set('Asia/Kolkata'); ?>
                        <div class="main_block text-center mg_bt_10">
                            <div class="col-xs-12">
                                <textarea id="txt_special_request" onchange="validate_address(this.id)" name="txt_special_request" placeholder="Your special request E.g(Veg Food)" title="Your special request E.g(Veg Food)" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="main_block mg_bt_20">    
                            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10_xs">
                                <input type="text" id="txt_balance_due_date" name="txt_balance_due_date" placeholder="Due Date" title="Due Date" />
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10_xs">
                                <input type="text" id="employee_name" name="employee_name" value="<?php echo ($booker_name == ' ') ? 'Admin' : $booker_name; ?>" placeholder="Employee Name" title="Employee Name" disabled/>
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-12 mg_bt_10_xs">
                                <input type="text" id="txt_booking_date" name="txt_booking_date" placeholder="Booking Date" title="Booking Date" value="<?php echo date('d-m-Y') ?>" onchange="get_auto_values('txt_booking_date','total_basic_amt','payment_mode','service_charge','markup','save','true','service_charge','discount',true);check_valid_date(this.id)"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="panel panel-default main_block bg_light pad_8 text-center mg_bt_150">
    <div class="text-center">
        <div class="col-xs-12">
            <button class="btn btn-sm btn-info ico_left" type="button" onclick="back_to_tab_3()"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Previous</button>&nbsp;&nbsp;&nbsp;
            <button class="btn btn-sm btn-success" id="btn_package_tour_master_save"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
        </div>
    </div>
</div>

</form>

<?= end_panel() ?>
<script src="../js/tab_4.js"></script>
<script src="../js/booking_save.js"></script>