
function get_auto_values(booking_date,sub_total,payment_mode,service_charge,type,charges_flag,amount_type, change = false){
    
    $('#service_show').html('&nbsp;');
    $('#markup_show').html('&nbsp;');
    $('#basic_show').html('&nbsp;');
    $('#service_show1').html('&nbsp;');
    $('#markup_show1').html('&nbsp;');
    $('#basic_show1').html('&nbsp;');

    const rules = get_other_rules('Forex',booking_date);
    var basic_amount = $('#'+sub_total).val();
    var payment_mode = $('#'+payment_mode).val();

    if(basic_amount === '') basic_amount = 0;
    if (charges_flag === 'true') {

        var service_charge_result = rules && rules.filter((rule) => rule['rule_for'] === '1');
        
        /////////////////Service charge Start/////////////////
        var rules_array = get_charges_on_conditions(service_charge_result, basic_amount, payment_mode, type);

        if (parseInt(rules_array.length) === 0) {
            if ($('#' + service_charge).val() == '') $('#' + service_charge).val(parseInt(0).toFixed(2));
        }
        else {
            var service_charge1 = calculate_charges(rules_array, type, basic_amount, 0);
            service_charge1 = (service_charge1 == '' || typeof service_charge1 === NaN || service_charge1 === undefined) ? parseFloat(0).toFixed(2) : parseFloat(service_charge1).toFixed(2);
            
            if(change && $('#' +service_charge).val() != service_charge1 && $('#' +service_charge).val() !== '0.00'){
                
                $('#vi_confirm_box').vi_confirm_box({
                    message : "<span style='font-size:20px'>As per the Business rule Service Charge should be <b>"+service_charge1+"</b> but the same has been altered by you with <b>"+$('#' + service_charge).val()+"</b> , Click on Yes to accept the Business Rule Service Charge.</span>",
                    callback : function (result) {
                        if (result == 'yes') {
                            $('#' + service_charge).val(service_charge1);
                            $('#' + service_charge).trigger('change');
                        }
                    }
                });
            }else{
                $('#' + service_charge).val(service_charge1);
            }

            $('#forex_sc').val(rules_array[0].ledger_id);
        }
        if (rules_array.length && rules_array[0].type === "Automatic")
            $('#' + service_charge).attr({ 'readonly': 'readonly' });
        else
            $('#' + service_charge).removeAttr('readonly');


        /////////////////Service charge End/////////////////
    }
    
    if($('#'+service_charge).val() == '')
        $('#'+service_charge).val(parseInt(0).toFixed(2));    
    /////////////////Tax Start///////////////////////
    var taxes_result = rules && rules.filter((rule)=>{
        var {entry_id,rule_id} = rule;
        return entry_id !== '' && !rule_id 
    });
    var tax_service_charge = $('#'+service_charge).val();

    get_tax_rules(rules,taxes_result,basic_amount,sub_total,tax_service_charge,service_charge,payment_mode,type,amount_type,charges_flag);
    /////////////////Tax End///////////////////////
   calculate_total_amount(sub_total);
   
}

///////////////////////////////////// TAXES FUNCTIONS START /////////////////////////////////////////////
function get_tax_rules(rules,taxes_result,basic_amount,basic_amountid,service_charge,service_chargeid,payment_mode,type,amount_type,charges_flag){
    
    var final_taxes_rules = [];
    taxes_result && taxes_result.filter((tax_rule)=>{
        var tax_rule_array = [];
        rules && rules.forEach((rule)=>{
            if(parseInt(tax_rule['entry_id']) === parseInt(rule['entry_id']) && rule['rule_id'])
                tax_rule_array.push(rule);
        });
        final_taxes_rules.push({'entry_id':tax_rule['entry_id'],tax_rule_array});
    });
    
    var new_taxes_rules = get_tax_rules_on_conditions(final_taxes_rules,basic_amount,payment_mode,type);
    var tax_for = '';
    
    //service_charge////////////////////////////////////
    var other_charge_results = new_taxes_rules.filter((rule)=>{
        return rule['target_amount'] !== "Markup";
    });
    tax_for = 'service_charge';
    get_tax_charges(other_charge_results,taxes_result,basic_amount,basic_amountid,service_charge,service_chargeid,payment_mode,type,amount_type,tax_for);
}

function get_tax_charges(new_taxes_rules,taxes_result,basic_amount,basic_amountid,service_charge,service_chargeid,payment_mode,type,amount_type,tax_for){
  
    var service_tax_subtotal = 'service_tax_subtotal';

    var ledger_posting = '';
    var applied_taxes = '';
    var total_tax = 0;
    if(new_taxes_rules.length > 0){

        new_taxes_rules && new_taxes_rules.map((rule)=>{

            var tax_data = taxes_result.find((entry_id_tax)=>entry_id_tax['entry_id'] === rule['entry_id'])
            var {rate_in,rate} = tax_data;
            rate = parseFloat(rate).toFixed(0);
            var {target_amount,ledger_id,calculation_mode,name} = rule;
            // target_amount = 'Service Charge','Basic','Total','Commission','Markup','Discount'
    
            if(target_amount === 'Service Charge'){
                var charge_amount  = service_charge;
            }
            else if(target_amount === 'Basic'){
                var charge_amount = basic_amount;
            }
            else if(target_amount === 'Total'){
                var charge_amount = parseFloat(service_charge) + parseFloat(basic_amount);
            }
            else{
                var charge_amount = 0;
            }
            
            if(calculation_mode === '"Exclusive"'){
                if(rate_in === 'Percentage'){
                    var rate_in_text = '%';
                    var tax_amount =(parseFloat(charge_amount) * parseFloat(rate)/100);
                }
                else{
                    var rate_in_text = '';
                    var tax_amount = parseFloat(rate);
                }
            }
            else{
                if(rate_in === 'Percentage'){
                    var rate_in_text = '%';
                    var tax_rate = parseInt(100) + parseFloat(rate);
                    var tax_amount = parseFloat(charge_amount) - (parseFloat(charge_amount) / parseFloat(tax_rate)* 100); 
                }
                else{
                    var rate_in_text = '';
                    var tax_amount = parseFloat(rate); 
                }
                total_tax = parseFloat(total_tax) + parseFloat(tax_amount);
            }
            tax_amount = (tax_amount !== '' || typeof tax_amount !== NaN || tax_amount !== undefined)? parseFloat(tax_amount).toFixed(2) : parseFloat(0).toFixed(2);
            
            var new_service_charge = parseFloat(charge_amount) - parseFloat(total_tax);
            new_service_charge = (new_service_charge !== '' || typeof new_service_charge !== NaN || new_service_charge !== undefined)? parseFloat(new_service_charge).toFixed(2) : parseFloat(0).toFixed(2);

            if(applied_taxes != ''){
                applied_taxes = applied_taxes + ', ' + name+':('+rate+rate_in_text+'):'+tax_amount;
                ledger_posting = ledger_posting + ',' + ledger_id;

            }else{
                applied_taxes += name+':('+rate+rate_in_text+'):'+tax_amount;
                ledger_posting += ledger_id;
            }

            if(calculation_mode !== '"Exclusive"'){

                if(tax_for === 'service_charge'){
                    if(target_amount === 'Service Charge'){
                        $('#service_show').html('Inclusive Amount : <span>' + new_service_charge + '</span>');
                    }
                    else if(target_amount === 'Basic'){
                        $('#basic_show').html('Inclusive Amount : <span>' + new_service_charge + '</span>');
                    }
                    $('#'+service_tax_subtotal).val(applied_taxes);
                    
                    $('#forex_taxes').val(ledger_posting);
                }
            }
            else{
                if(tax_for === 'service_charge'){
                    if(target_amount === 'Service Charge'){
                        $('#'+service_chargeid).val(new_service_charge);
                    }
                    else if(target_amount === 'Basic'){
                        $('#'+basic_amountid).val(new_service_charge);
                    }
                    $('#'+service_tax_subtotal).val(applied_taxes);
                    $('#forex_taxes').val(ledger_posting);
                }
            }
            
        });
    }
    else{
        if(tax_for === 'service_charge'){
            $('#'+service_tax_subtotal).val('');
            $('#forex_taxes').val('');
        }
    }
}
function get_tax_rules_on_conditions(final_taxes_rules,basic_amount,payment_mode,type){

    let applied_rules = [];
    if(type === 'save'){
        var customer = $('#customer_id').val();
        var cust_state =  $('#cust_state').val();
    }
    else {
        var customer = $('#customer_id1').val();
    }
    
    final_taxes_rules && final_taxes_rules.map((tax)=>{
        
        var entry_id_rules = tax['tax_rule_array'];
        var flag = false;
        entry_id_rules && entry_id_rules.forEach((rule)=> {
            if(rule['applicableOn'] == '1')
                return;
            var conditions_flag_array = [];
            var condition = JSON.parse(rule['conditions']);
            condition && condition.forEach((cond)=> {

                var condition = cond.condition;
                var for1 = cond.for1;
                var value = cond.value;
                var amount = cond.amount;
                //Conditions- '1-Place of supply','2-Routing','3-Payment Mode','4-Target Amount','5-Supplier','6-Customer Type','7-Customer','8-Product','9-Fee Type'
                switch(condition){
                    case '1':
                        var place_flag = null;
                        place_flag_array = [];
                        if (customer !== '0' && customer !== '') {
                            $.ajax({
                                'async': false,
                                'type': "POST",
                                'global': false,
                                'dataType': 'html',
                                'url': "inc/get_customer_operator_state.php",
                                'data': { 'customer' : customer },
                                'success': (data) => {
                                    data = data.split('-');
                                        switch(for1) {
                                            case '!=':
                                                if (data[0] !== value || data[0] === '') place_flag = true;
                                                else place_flag = false;
                                                break;
                                            break;
                                            case '==':
                                                if (data[0] === value || data[0] === '') place_flag = true;
												else place_flag = false;
												break;
                                            default:
                                                place_flag = false;
                                        }
                                }
                            });
                            flag = place_flag;
                        }else if(customer==0){
                            var cust_state= $('#cust_state').val();
                            if(cust_state == undefined || cust_state === '')
                            {
                                flag = false;
                            }
                            else{
                                switch (for1) {
                                    case '!=':
                                        if (cust_state !== value || cust_state === '') place_flag = true;
                                        else place_flag = false;
                                        break;
                                    case '==':
                                        if (cust_state === value || cust_state === '') place_flag = true;
                                        else place_flag = false;
                                        break;
                                    default:
                                            place_flag = false;
                                }
                                flag = place_flag;
                            }
                        }
                        else
                            flag = false;
                    break;
                    case '2':
                            flag = false;
                    break;
                    case '5':
                            flag = false;
                    break;
                    case '8':
                            if(value == 'Forex' || value == 'All') flag = true;
                    break;
                    case '3':
                        switch(for1){
                            case '!=':
                                if(payment_mode != value)
                                flag = true;
                            break;
                            case '==':
                                if(payment_mode === value)
                                flag = true;
                            break;
                        }
                    break;
                    case '7':
                        var customer_flag = null;
                        if(customer !== 0 && customer !==''){
                            $.ajax({
                                'async': false,
                                'type': "POST",
                                'global': false,
                                'dataType': 'html',
                                'url': "inc/get_customer.php",
                                'data': { 'customer': customer },
                                'success': function (data) {
                                    data = data.split('-');
                                    switch(for1) {
                                        case '!=':
                                            if(data[1] !== value || data[1] === '')
                                            customer_flag = true;
                                            else
                                            customer_flag = false;
                                        break;
                                        case '==':
                                            if(data[1] === value || data[1] === '')
                                            customer_flag = true;
                                            else
                                            customer_flag = false;
                                        break;
                                    }
                                }
                            });
                            flag = customer_flag;
                        }else{
                            flag = false;
                        }
                    break;
                    case '4':
                       switch(for1) {
                            case '<':
                                flag = (parseFloat(basic_amount) < parseFloat(amount))
                            break;
                            case '<=':
                                flag = (parseFloat(basic_amount) <= parseFloat(amount))
                            break;
                            case '>':
                                flag = (parseFloat(basic_amount) > parseFloat(amount))
                            break;
                            case '>=':
                                flag = (parseFloat(basic_amount) >= parseFloat(amount))
                            break;
                            case '!=':
                                flag = (parseFloat(basic_amount) != parseFloat(amount))
                            break;
                            case '==':
                                flag = (parseFloat(basic_amount) === parseFloat(amount))
                            break;
                        }
                    break;
                    case '6':
                        var customer_type_flag = null;
                        if(customer !=='0' && customer !==''){
                            $.ajax({
                                'async': false,
                                'type': "POST",
                                'global': false,
                                'dataType': 'html',
                                'url': "inc/get_customer.php",
                                'data': { 'customer': customer },
                                'success': function (data) {
                                    data = data.split('-');
                                    switch(for1) {
                                        case '!=':
                                            if(data[0] !== value || data[0] === '')
                                            customer_type_flag = true;
                                            else
                                            customer_type_flag = false;
                                        break;
                                        case '==':
                                            if(data[0] === value || data[0] === '')
                                            customer_type_flag = true;
                                            else
                                            customer_type_flag = false;
                                        break;
                                    }
                                }
                            });
                            flag = customer_type_flag;
                        }
                        else if(customer == 0){
                            var cust_type= $('#cust_type').val();
                            switch (for1) {
                                case '!=':
                                    if (cust_type !== value || cust_type === '')
                                    {
                                        customer_type_flag = true;
                                    }
                                    else customer_type_flag = false;
                                    break;
                                case '==':
                                    if (cust_type === value  || cust_type === '')
                                    {
                                        customer_type_flag = true;
                                    }
                                    else customer_type_flag = false;
                                    break;
                            }
                            flag = customer_type_flag;
                        }
                        else{
                            flag = false;
                        }
                    break;
                    default:
                        flag = false
                    break;
                }
                conditions_flag_array.push(flag);
            });
            console.log(conditions_flag_array);
            if(!conditions_flag_array.includes(false))
                applied_rules.push(rule)
        });
    });
    return applied_rules;
}
//////////////////////////// TAXES FUNCTIONS END //////////////////////////////////////////

function get_charges_on_conditions(service_charge_result,basic_amount,payment_mode,type){
    let rules_array = service_charge_result && service_charge_result.filter((rule)=>{

        var cond = JSON.parse(rule['conditions']);
        var conditions_flag_array = [];
        var flag = false;
        cond && cond.forEach((item)=> {

            if(type === 'save'){
                // var hotel_table = "tbl_dynamic_exc_booking";
                var customer = $('#customer_id').val();
            }
            else { 
                // var hotel_table = 'tbl_dynamic_exc_booking_update'; 
                var customer = $('#customer_id1').val();
            }
            var condition = item.condition;
            var for1 = item.for1;
            var value = item.value;
            var amount = item.amount;
            
            //conditions-'2-Routing','11-Price','5-Supplier','8-Product','12-Airline','13-Transcarion Type','14-Booking Cabin','15-Service(Itinerary)','10-Supplier Type','3-Payment Mode','7-Customer','6-Customer Type','16-Reissue'
            switch(condition) {
                case '2':
                        flag = false;
                break;
                case '11':
                    switch(for1) {
                        case '<':
                            flag = (parseFloat(basic_amount) < parseFloat(amount))
                        break;
                        case '<=':
                            flag = (parseFloat(basic_amount) <= parseFloat(amount))
                        break;
                        case '>':
                            flag = (parseFloat(basic_amount) > parseFloat(amount))
                        break;
                        case '>=':
                            flag = (parseFloat(basic_amount) >= parseFloat(amount))
                        break;
                        case '!=':
                            flag = (parseFloat(basic_amount) != parseFloat(amount))
                        break;
                        case '==':
                            flag = (parseFloat(basic_amount) === parseFloat(amount))
                        break;
                    }
                break;
                case '5':
                        flag = false;
                break;
                case '8':
                        if(value == 'Forex' || value == 'All') flag = true;
                break;
                case '12':
                    flag = false;
                break;
                case '13':
                        if(value == 'Sale') flag = true;
                break;
                case '14':
                    flag = false;
                break;
                case '15':
                    flag = false;
                break;
                case '10':
                        if(value == 'Forex' || value == 'All') flag = true;
                break;
                case '3':
                    switch(for1) {
                        case '!=':
                            if(payment_mode != value)
                            flag = true;
                        break;
                        case '==':
                            if(payment_mode === value)
                            flag = true;
                        break;
                    }
                break;
                case '7':
                    var customer_flag = null;
                    if(customer !== 0 && customer !==''){
                        $.ajax({
                            'async': false,
                            'type': "POST",
                            'global': false,
                            'dataType': 'html',
                            'url': "inc/get_customer.php",
                            'data': { 'customer': customer },
                            'success': function (data) {
                                data = data.split('-');
                                console.log(data[1], value);
                                switch(for1) {
                                    case '!=':
                                        if(data[1] !== value || data[1] === '')
                                        customer_flag = true;
                                        else
                                        customer_flag = false;
                                    break;
                                    case '==':
                                        if(data[1] === value || data[1] === '')
                                        customer_flag = true;
                                        else
                                        customer_flag = false;
                                    break;
                                }
                            }
                        });
                        flag = customer_flag;
                    }else{
                        flag = false;
                    }
                break;
                case '6':
                    var customer_type_flag = null;
                    if(customer !=='0' && customer !==''){
                        $.ajax({
                            'async': false,
                            'type': "POST",
                            'global': false,
                            'dataType': 'html',
                            'url': "inc/get_customer.php",
                            'data': { 'customer': customer },
                            'success': function (data) {
                                data = data.split('-');
                                switch(for1) {
                                    case '!=':
                                        if(data[0] !== value || data[0] === '')
                                        customer_type_flag = true;
                                        else
                                        customer_type_flag = false;
                                    break;
                                    case '==':
                                        if(data[0] === value || data[0] === '')
                                        customer_type_flag = true;
                                        else
                                        customer_type_flag = false;
                                    break;
                                }
                            }
                        });
                        flag = customer_type_flag;
                    }
                    else if(customer == 0){
                        var cust_type= $('#cust_type').val();
                        switch (for1) {
                            case '!=':
                                if (cust_type !== value || cust_type === '')
                                {
                                    customer_type_flag = true;
                                }
                                else customer_type_flag = false;
                                break;
                            case '==':
                                if (cust_type === value  || cust_type === '')
                                {
                                    customer_type_flag = true;
                                }
                                else customer_type_flag = false;
                                break;
                        }
                        flag = customer_type_flag;
                    }
                    else{
                        flag = false;
                    }
                break;
                case '16':
                    flag = false;
                break;
                default:
                    flag = false
                break;
            }
            conditions_flag_array.push(flag);
        });
        // console.log(rule.rule_id+'-'+conditions_flag_array);
        if(conditions_flag_array.includes(false))
            return null;
        else{
            return rule;
        }
    });
    var final_rule = get_final_rule(rules_array);
    return final_rule;
}

function get_final_rule(rules_array){
    if(rules_array && (rules_array.length === 1 || rules_array.length === 0))
        return rules_array; // Only one valid rule is there
    else{
        var conditional_rule = rules_array && rules_array.filter((rule)=> {
            if(rule['conditions']){
                return rule;
            }
            return null;
        });
        if(conditional_rule && (conditional_rule.length === 0 || conditional_rule.length === 1))
            return conditional_rule; // If only one Conditional rule is there
        else{
            var customer_condition_rules = conditional_rule && conditional_rule.filter((rule)=>{
                var cond = JSON.parse(rule['conditions']);
                return cond && cond.includes((obj)=> obj.conditions === '7')
            });
            if(customer_condition_rules && (customer_condition_rules.length === 1))
                return customer_condition_rules; // If only one 'Customer' Conditional rule is there
            else{
                var sorted_array = (conditional_rule.sort((a, b) =>a.rule_id - b.rule_id));
                var latest_arr = [];
                latest_arr.push(sorted_array[sorted_array.length-1]);
                return latest_arr; // Return latest rule
            }
        }
    }
}
function calculate_charges(rules_array, type, basic_amount, markup_amount1) {
    if (rules_array.length) {
        var apply_on = rules_array[0].apply_on;

        if (rules_array[0].target_amount != '') {
            if (rules_array[0].target_amount === 'Basic')
                var target_amount = basic_amount;
            else if (rules_array[0].target_amount === 'Total')
                var target_amount = parseFloat(basic_amount) + parseFloat(markup_amount1);
        }
        else
            var target_amount = 0;

        switch (apply_on) {
            case '2':
                //Per Invoice
                var service_fee = (rules_array[0].fee_type === 'Flat') ? parseFloat(rules_array[0].fee) : (parseFloat(target_amount) * parseFloat(rules_array[0].fee) / 100);
                return service_fee;
                break;
        }
    }
}