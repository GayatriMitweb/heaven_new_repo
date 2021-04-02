<div class="row"> 

    <div class="col-md-12"> <div class="table-responsive">
        <table id="tbl_package_tour_member" class="table table-bordered table-hover table-striped" style="width:1504px">
            <tr>
                <td><input id="check-btn-member-1" type="checkbox" onchange="get_auto_values('txt_booking_date','total_basic_amt','payment_mode','txt_tour_cost','markup','save')" checked ></td>
                <td><input maxlength="15" type="text" name="username"  value="1" placeholder="Sr. No." disabled/></td>
                <td><select id="cmb_m_honorific1" name="cmb_m_honorific1" title="Honorofic">
                        <option value="Mr">Mr</option>
                        <option value="Mrs">Mrs</option>
                        <option value="Mas">Mas</option>
                        <option value="Miss">Miss</option>
                        <option value="Smt">Smt</option>
                        <option value="Infant">Infant</option>
                    </select>
                </td>
                <td style="width: 129px;"><input type="text" id="txt_m_first_name1" name="txt_m_first_name1" onchange="fname_validate(this.id);" placeholder="First Name" title="First Name" /></td>                        
                <td><input type="text" id="txt_m_middle_name1" name="txt_m_middle_name1" onchange="fname_validate(this.id);" placeholder="Middle Name" title="Middle Name" /></td>
                <td style="width: 129px;"><input type="text" id="txt_m_last_name1" name="txt_m_last_name1" onchange="fname_validate(this.id);" placeholder="Last Name" title="Last Name"/></td>
                <td><select id="cmb_m_gender1" name="cmb_m_gender1"  title="Select gender"> 
                        <option value="Male"> M </option>
                        <option value="Female"> F </option>
                    </select>
                </td>
                <td><input type="text" maxlength="20" id="m_birthdate1" name="m_birthdate1" onchange="calculate_age_member(this.id); " value="<?php echo date('d-m-Y') ?>" placeholder="Birth Date" title="Birth date" /></td>
                <td style="width: 100px;"><input type="text" id="txt_m_age1" name="txt_m_age1" placeholder="Age" onkeyup="adolescence_reflect(this.id)" onchange="validate_balance(this.id)" disabled title="Age"/></td>
                <td><select id="txt_m_adolescence1" name="txt_m_adolescence1" disabled title="Adolescence">
                        <option value=""></option>
                        <option value="Adult">A</option>
                        <option value="Child With Bed">CWB</option>
                        <option value="Child Without Bed">CWOB</option>
                        <option value="Infant">I</option>
                    </select></td>
                <td style="width: 139px;"><input type="text" id="txt_m_passport_no1" name="txt_m_passport_no1" placeholder="Passport No" onchange="validate_passport(this.id)" title="No" style="text-transform: uppercase;" disabled></td>
                <td style="width: 130px;"><input type="text"  id="txt_m_passport_issue_date1" name="txt_m_passport_issue_date1" placeholder="Issue Date" title="Passport Issue Date" disabled></td>
                <td style="width: 132px;"><input type="text" id="txt_m_passport_expiry_date1" name="txt_m_passport_expiry_date1" placeholder="Expiry Date" title="Passport Expiry Date" disabled></td>
            </tr>

        </table> 
    
    </div>  
    </div>
</div>