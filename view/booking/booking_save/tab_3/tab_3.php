<form id="frm_tab_3">

<div class="app_panel"> 



 <!--=======Header panel======-->
        <div class="app_panel_head mg_bt_20">
            <div class="container">
                  <h2 class="pull-left"></h2>
                  <div class="pull-right header_btn">
                    <button type="button" onclick="switch_back_tab_2()">
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
                        <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10 text-center">
                            <label>No. of Adult's</label>
                            <input type="text" id="txt_adult_seats" name="txt_adult_seats" value="0" class="text-center form-control valid" title="No. of Adult's" readonly />            
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10 text-center">
                            <label>Total Child With Bed</label>
                            <input type="text" id="txt_child_b_seats" name="txt_child_b_seats" value="0" class="text-center form-control valid" title="No. of Children's" readonly/>           
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10 text-center">
                            <label>Total Child Without Bed</label>
                            <input type="text" id="txt_child_wb_seats" name="txt_child_wb_seats" value="0" class="text-center form-control valid" title="No. of Children's" readonly/>           
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10 text-center">
                            <label>No. of Infant's</label>
                            <input type="text" id="txt_infant_seats" name="txt_infant_seats" value="0" class="text-center form-control valid" title="No. of Infant's" readonly />            
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10 text-center">
                            <label>Total Passenger</label>
                            <input type="text" id="txt_total_seats" name="txt_total_seats" value="0" class="text-center form-control valid" title="Total Passenger" readonly />            
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs text-center">
                            <label>Adult</label>
                            <input type="text" id="txt_adult_expense" name="txt_adult_expense" title="Adult Cost" placeholder="Adult Cost" class="text-right form-control valid" onchange="tour_cost_calculate(this.id); validate_balance(this.id)" />            
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs text-center">
                            <label>Child With Bed</label>
                            <input type="text" id="txt_child_bed_expense" title="Child With Bed" placeholder="Child With Bed" name="txt_child_bed_expense" class="text-right form-control valid" onchange="tour_cost_calculate(this.id);validate_balance(this.id)"  />           
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs text-center">
                            <label>Child Without Bed</label>
                            <input type="text" id="txt_child_wbed_expense" title="Child Without Bed" placeholder="Child Without Bed" name="txt_child_wbed_expense" class="text-right form-control valid" onchange="tour_cost_calculate(this.id);validate_balance(this.id)"  />           
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs text-center">
                            <label>Infant</label>
                            <input type="text" id="txt_infant_expense" title="Infant Cost" placeholder="Infant Cost" name="txt_infant_expense" class="text-right form-control valid" onchange="tour_cost_calculate(this.id);validate_balance(this.id)"  />          
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12 mg_bt_10_xs text-center">
                            <label>Total Amount</label>
                            <input type="text" id="txt_total_expense" title="Total Cost" name="txt_total_expense" class="text-right amount_feild_highlight form-control valid" readonly />   
                        </div>
                    </div>
                </div>
                 <div class="panel panel-default panel-body main_block bg_light mg_bt_30 hidden">
                    <legend>Visa & Insurance Details</legend>
                    <div class="bg_white main_block panel-default-inner">
                        <div class="text-center">
                            <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
                                <input type="text" id="visa_country_name" name="visa_country_name" onchange="validate_city(this.id)" placeholder="Country Name" title="Country Name">
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
                                <input type="text" id="visa_amount" name="visa_amount" placeholder="Amount" title="Amount" onchange="validate_balance(this.id); calculate_total_discount()" value="0">
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
                                <input type="text" id="visa_service_charge" name="visa_service_charge"  class="text-right" value="0.00" placeholder="Service charge" title="Service charge" onchange="validate_balance(this.id); calculate_total_discount()" />            
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
                                <select name="visa_taxation_id" id="visa_taxation_id" title="Tax" onchange="generic_tax_reflect(this.id, 'visa_service_tax', 'calculate_total_discount');">
                                   
                                </select>
                                <input type="hidden" id="visa_service_tax" name="visa_service_tax" value="0">        
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
                                <input type="text" id="visa_service_tax_subtotal" name="visa_service_tax_subtotal" value="0" placeholder="Tax Amount" title="Tax Amount" readonly>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10">
                                <input type="text" id="visa_total_amount" class="amount_feild_highlight" name="visa_total_amount" placeholder="Total Amount" title="Total Amount" onchange="validate_balance(this.id); calculate_total_discount()" value="0" readonly>
                            </div>    
                        </div>
                        <div class="text-center">
                            <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
                                <input type="text" id="insuarance_company_name" onchange="validate_company(this.id)" name="insuarance_company_name" placeholder="Insurance Company" title="Insurance Company">
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
                                <input type="text" id="insuarance_amount" name="insuarance_amount" placeholder="Insurance Amount" title="Insurance Amount" onchange="validate_balance(this.id); calculate_total_discount()" value="0">
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
                                <input type="text" id="insuarance_service_charge" name="insuarance_service_charge" title="Service charge" placeholder="Service charge" class="text-right" value="0.00" onchange="validate_balance(this.id); calculate_total_discount()" />            
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs hidden">
                                <select name="insuarance_taxation_id" id="insuarance_taxation_id" title="Tax" onchange="generic_tax_reflect(this.id, 'insuarance_service_tax', 'calculate_total_discount');">

                                </select>
                                <input type="hidden" id="insuarance_service_tax" name="insuarance_service_tax" value="0">        
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
                                <input type="text" id="insuarance_service_tax_subtotal" name="plane_service_tax_subtotal" placeholder="Tax Amount" title="Tax Amount" readonly>
                            </div>
                            <div class="col-md-2 col-sm-4 col-xs-12 mg_bt_10_xs">
                                <input type="text" id="insuarance_total_amount" class="amount_feild_highlight" name="insuarance_total_amount" placeholder="Total Amount" title="Total Amount" onchange="validate_balance(this.id); calculate_total_discount()" value="0" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default panel-body main_block bg_light mg_bt_30">
                    <legend>Tours and Travels Amount</legend>
                    <div class="bg_white main_block panel-default-inner">
                        <div class="text-right text_center_xs mg_tp_10">
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10"><label>Repeater's Discount</label></div>
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10 text_center_xs">
                                <input type="text" id="txt_repeater_discount" name="txt_repeater_discount" class="text-right" placeholder="Repeaters Travelling Discount" title="Repeaters Travelling Discount" onchange="calculate_total_discount(this.id);validate_balance(this.id);" value="0"  />
                            </div>
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10"><label>Adjustment discount</label></div>
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10 text_center_xs">
                                <input type="text" id="txt_adjustment_discount" name="txt_adjustment_discount" class="text-right" placeholder="Adjustment Discount" title="Adjustment Discount"  value="0"  onchange="calculate_total_discount(this.id);validate_balance(this.id);"/>
                            </div>
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10"><label class="theme_col">Total Discount</label></div>
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10 text_center_xs">
                                 <small id="discount_show" style="color:red">&nbsp;</small>
                                <input type="text" id="txt_total_discount" name="txt_total_discount" class="text-right amount_feild_highlight" placeholder="Total Discount" title="Total Discount " onchange="get_auto_values('txt_date','basic_amount','cmb_payment_mode1','service_charge','markup','save','true','txt_total_discount','discount',true);" readonly />
                            </div>
                        </div>
                        <div class="text-right text_center_xs">
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10"><label>Tour Amount</label></div>
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10">
                                <input type="text" id="txt_tour_fee" onchange="calculate_total_discount(this.id);validate_balance(this.id)" name="txt_tour_fee" class="text-right" placeholder="Tour Amount" title="Tour Amount"  />
                            </div>
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10"><label class="theme_col">Travel Amount</label></div>
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10">
                                <input type="text" id="txt_travel_total_expense1" name="txt_travel_total_expense" class="text-right" value="0" title= "Total Travel Amount"  onchange="calculate_total_discount(this.id)" readonly/>
                            </div>
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10"><label class="theme_col">Basic Amount</label></div>
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10">
                            <small id="basic_show" style="color:#000000">&nbsp;</small>
                                <input type="text" id="basic_amount" name="basic_amount" class="text-right" value="0" title= "Total Travel Amount" onchange="get_auto_values('txt_date','basic_amount','cmb_payment_mode1','service_charge','markup','save','true','basic','basic')" readonly />
                            </div>
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10 hidden"><label>Tax (%)</label></div>
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10 hidden">
                                <select name="tour_taxation_id" id="tour_taxation_id" title="Tax" onchange="generic_tax_reflect(this.id, 'service_tax_per', 'calculate_total_discount');">
                                   
                                </select>
                            </div>
                                <input type="hidden" id="service_tax_per" name="service_tax_per" value="0">
                                 <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10"><label>Tax Total</label></div>
                                <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10">
                                     <input type="text" id="txt_service_charge" name="txt_service_charge" title="Total Tax"  placeholder="Total Tax" readonly />
                                </div>
                        </div>     
                        <div class="text-right text_center_xs">
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10 hidden"><label>Subtotal</label></div>
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10 hidden">
                                <input type="text" id="txt_total_tour_fee1" name="txt_total_tour_fee1" class="text-right" placeholder="Subtotal" title="Subtotal" readonly />
                            </div>
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10 hidden"><label for="visa_total_amount1">Visa Amount</label></div>
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10 hidden">
                                <input type="text" id="visa_total_amount1" name="visa_total_amount1" placeholder="Visa Amount" title="Visa Amount" onchange="validate_balance(this.id)" value="0" readonly>
                            </div>
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10 hidden"><label for="visa_total_amount">Insurance Amount</label></div>
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10 hidden">
                                <input type="text" id="insuarance_total_amount1" name="insuarance_total_amount1" placeholder="Insuarance Amount" title="Insurance Amount" placeholder="Insurance Amount" onchange="validate_balance(this.id);" value="0" readonly>
                            </div>
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10"><label for="visa_total_amount">Roundoff</label></div>
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10 ">
                            <input type="text" name="roundoff" id="roundoff" class="text-right" placeholder="Round Off" title="RoundOff" readonly>
                            </div>
                        </div>
                        <div class="text-right text_center_xs">
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10"><label class="theme_col">Total Amount</label></div>
                            <div class="col-md-2 col-sm-3 col-xs-12 mg_bt_10">        
                                <input type="text" id="txt_total_tour_fee" name="txt_total_tour_fee" class="text-right amount_feild_highlight" placeholder="Total Amount" title="Total Amount" readonly />
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="panel panel-default panel-body main_block bg_light mg_bt_30">
                    <legend>Advance Receipt Details</legend>
                    <div class="bg_white main_block panel-default-inner">
                        <div class="col-xs-12">
                            <div class="panel panel-default panel-body pad_8 mg_bt_10 mg_tp_10 legend_pan bk_payment_wrap">
                                <div class="row">
                                    <div class="chk_wrap">
                                        <input type="checkbox" id="chk_pay_for_tour" checked>
                                    </div>
                                    <div class="col-md-2 col-sm-4 col-xs-12 text_center_xs mg_bt_10_xs">
                                        <input type="text" id="txt_payment_date1" name="txt_payment_date1" title="Receipt Date" placeholder="Date" value="<?= date('d-m-Y')?>" onchange="check_valid_date(this.id)"/>
                                    </div>
                                    <div class="col-md-2 col-sm-4 col-xs-12 text_center_xs mg_bt_10_xs">
                                        <select id="cmb_payment_mode1" title="Mode"  name="cmb_payment_mode1" onchange="payment_installment_enable_disable_fields('1');get_auto_values('txt_date','basic_amount','cmb_payment_mode1','service_charge','markup','save','true','service_charge','discount',false);get_identifier_block('identifier','cmb_payment_mode1','credit_card_details','credit_charges');get_credit_card_charges('identifier','cmb_payment_mode1','txt_amount1','credit_card_details','credit_charges')">
                                             <?php get_payment_mode_dropdown(); ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-sm-4 col-xs-12 text_center_xs mg_bt_10_xs">
                                        <input type="text" id="txt_amount1" name="txt_amount1" title="Amount" placeholder="*Amount" class="text-right" onchange="validate_balance(this.id);payment_amount_validate(this.id,'cmb_payment_mode1','txt_transaction_id1','txt_bank_name1');get_credit_card_charges('identifier','cmb_payment_mode1','txt_amount1','credit_card_details','credit_charges');" />
                                    </div>
                                    <div class="col-md-2 col-sm-4 col-xs-12 text_center_xs mg_bt_10_xs">
                                        <input type="text" class="bank_suggest" id="txt_bank_name1" title="Bank Name" name="txt_bank_name1" placeholder="Bank Name" disabled />
                                    </div>
                                    <div class="col-md-2 col-sm-4 col-xs-12 text_center_xs mg_bt_10_xs">
                                        <input type="text" id="txt_transaction_id1" title="Cheque No / ID" name="txt_transaction_id1" placeholder="Cheque No / ID" disabled />
                                    </div>
                                    <div class="col-md-2 col-sm-4 col-xs-12 text_center_xs mg_bt_10_xs hidden">
                                        <select id="cmb_payment_of_type1" onchange="select_color(this.id);" disabled >
                                            <option value="Tour">Pay for tour</option>
                                        </select> 
                                    </div>
                                    <div class="col-md-2 col-sm-4 col-xs-12 text_center_xs mg_bt_10_xs hidden">
                                        <select id="cmb_travel_of_type1" onchange="select_color(this.id);">
                                            <option value="">*Travelling Type</option>
                                            <option value="All"> All </option>
                                            <option value="Train">Train</option>
                                            <option value="Flight"> Flight </option>
                                            <option value="Cruise"> Cruise </option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-sm-4 col-xs-12 text_center_xs mg_bt_10_xs">
                                        <select name="bank_id1" id="bank_id1" title="Select Bank" disabled>
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
                                   
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="panel panel-default panel-body pad_8 mg_bt_0 legend_pan bk_payment_wrap" style="margin-top: 30px;">
                                <!-- <div class="row"> 
                                    <div class="col-xs-12"> <label class="legend_text">Travel</label> </div> 
                                </div> -->
                                    <div class="row hidden">
                                    <div class="chk_wrap">
                                        <input type="checkbox" id="chk_pay_for_traveling" >
                                    </div>
                                    <div class="col-md-2 col-sm-4 col-xs-12 text_center_xs mg_bt_10_xs">
                                        <input type="text" id="txt_payment_date2" name="txt_payment_date2" placeholder="Date"  value="<?= date('d-m-Y')?>" title="Receipt Date"/ onchange="check_valid_date(this.id)">
                                    </div>
                                    <div class="col-md-2 col-sm-4 col-xs-12 text_center_xs mg_bt_10_xs">
                                        <select id="cmb_payment_mode2" title="Mode" name="cmb_payment_mode2" onchange="payment_installment_enable_disable_fields('2');get_auto_values('txt_date','basic_amount','cmb_payment_mode2','service_charge','markup','save','true','service_charge','discount',false);">
                                            <?php echo get_payment_mode_dropdown();?>
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-sm-4 col-xs-12 text_center_xs mg_bt_10_xs">
                                        <input type="text" id="txt_amount2" name="txt_amount2" title="Amount" placeholder="Amount" class="text-right" onchange="validate_balance(this.id);payment_amount_validate(this.id,'cmb_payment_mode2','txt_transaction_id2','txt_bank_name2')" />
                                    </div>
                                    <div class="col-md-2 col-sm-4 col-xs-12 text_center_xs mg_bt_10_xs">
                                        <input type="text" class="bank_suggest" id="txt_bank_name2"  name="txt_bank_name2" placeholder="Bank Name" title="Bank Name" disabled />
                                    </div>
                                    <div class="col-md-2 col-sm-4 col-xs-12 text_center_xs mg_bt_10_xs">
                                        <input type="text" id="txt_transaction_id2" title="Cheque No / ID"  name="txt_transaction_id2" onchange="validate_specialChar(this.id);" placeholder="Cheque No / ID" disabled />
                                    </div>
                                    <div class="col-md-2 col-sm-4 col-xs-12 text_center_xs mg_bt_10_xs">
                                        <select id="cmb_travel_of_type2" title="Travelling Type" name="cmb_travel_of_type2">
                                            <option value="">*Travelling Type </option>
                                            <option value="All"> All </option>
                                            <option value="Train">Train</option>
                                            <option value="Flight"> Flight </option>
                                            <option value="Cruise"> Cruise </option>
                                        </select>  
                                    </div>
                                    <div class="col-md-2 col-sm-4 col-xs-12 text_center_xs mg_bt_10_xs mg_tp_10">
                                        <select name="bank_id2" id="bank_id2" title="Select Bank" disabled>
                                            <?php get_bank_dropdown(); ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2 col-sm-4 col-xs-12 text_center_xs mg_bt_10_xs">
                                        <select style="display:none" id="cmb_payment_of_type2" name="cmb_payment_of_type2" disabled>
                                            <option value="Travelling">Pay for travelling</option>
                                        </select>
                                    </div>
                                    </div>
                                </div>
                        </div>
                        <div class="col-md-9 col-sm-9">
                            <span style="color: red;line-height: 35px;" data-original-title="" title="" class="note"><?= $txn_feild_note ?></span>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default panel-body main_block bg_light mg_bt_30">
                    <legend>Booking Summary</legend>
                    <div class="bg_white main_block panel-default-inner">
                        <?php date_default_timezone_set('Asia/Kolkata'); ?>
                        <div class="col-xs-12">
                            <div class="row text-center mg_bt_10">
                                <div class="col-xs-12">
                                    <textarea id="txt_special_request" name="txt_special_request" onchange="validate_address(this.id)" rows="2" placeholder="Enter your special request i.e Veg food, driver language : English" title="Enter your special request"></textarea>
                                </div>
                            </div>
                            <div class="row text-center mg_bt_20">                                
                                <div class="col-md-4 col-sm-6 col-xs-12 text_center_xs mg_bt_10_sm_xs">
                                    <input type="text" id="txt_balance_due_date" name="txt_balance_due_date" name="txt_balance_due_date" placeholder="Due Date" title="Due Date" value="<?= date('d-m-Y')?>" />
                                </div>
                                <div class="col-md-4 col-sm-6 col-xs-12 text_center_xs mg_bt_10_sm_xs">
                                    <input type="text" id="txt_date" name="txt_date" placeholder="Booking Date" title="Booking Date" value="<?php echo date('d-m-Y H:i:s') ?>" onchange="check_valid_date(this.id);check_valid_date(this.id);get_auto_values('txt_date','basic_amount','cmb_payment_mode1','service_charge','markup','save','true','service_charge','discount',true);"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default panel-body pad_8 text-center main_block bg_light mg_bt_0">
    <button type="button" class="btn btn-sm btn-info ico_left" onclick="switch_back_tab_2()"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Previous</button> &nbsp;&nbsp;&nbsp;
    <button class="btn btn-sm btn-success" id="btn_save_booking"><i class="fa fa-floppy-o"></i>&nbsp;&nbsp;Save</button>
</div>

</form>

<?= end_panel() ?>
<script>
    $('#txt_payment_date1, #txt_payment_date2, #txt_balance_due_date').datetimepicker({timepicker: false,format:'d-m-Y' });
    $('#txt_date').datetimepicker({ format:'d-m-Y H:i:s' });
    /////////// Calculations for tour amount cal ///////////////////////////
    function tour_cost_calculate(id){
      var adult_expense = $('#txt_adult_expense').val();  
      var child_with_bed = $('#txt_child_bed_expense').val();
      var child_without_bed = $('#txt_child_wbed_expense').val();
      var infant_expense = $('#txt_infant_expense').val();

      if(adult_expense==""){ adult_expense = 0;}
      if(child_with_bed==""){ child_with_bed = 0;}
      if(child_without_bed==""){child_without_bed = 0;}
      if(infant_expense==""){infant_expense = 0;}

      var total = parseFloat(adult_expense) + parseFloat(child_with_bed) + parseFloat(child_without_bed) + parseFloat(infant_expense);

      $('#txt_total_expense').val(total.toFixed(2));
      $('#txt_total_tour_fee').val(total.toFixed(2));
      $('#txt_tour_fee').val(total.toFixed(2));
      $('#txt_total_tour_fee1').val(total.toFixed(2));
      calculate_total_discount(id);
    }
    function switch_back_tab_2(){
        $('#tab_3_head').removeClass('active');
        $('#tab_2_head').addClass('active');
        $('.bk_tab').removeClass('active');
        $('#tab_2').addClass('active');
        $('html, body').animate({scrollTop: $('.bk_tab_head').offset().top}, 200);
    }
</script>
<script src="../js/booking_save.js"></script>
