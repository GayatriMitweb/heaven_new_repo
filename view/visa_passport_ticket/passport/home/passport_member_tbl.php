 <tr>
    <td><input class="css-checkbox" id="chk_passport<?= $offset ?>1" onclick="get_auto_values('balance_date','passport_issue_amount','payment_mode','service_charge','save','true','service_charge')" type="checkbox" checked><label class="css-label" for="chk_passport<?= $offset ?>1"> <label></td>
    <td><input maxlength="15" value="1" type="text" name="username" placeholder="Sr. No." class="form-control" disabled /></td>
    <td><select name="honorific" id="honorific1" title="Honorific">
        <?php get_hnorifi_dropdown(); ?>
    </select></td>
    <td><input type="text" id="first_name<?= $offset ?>1" onchange="fname_validate(this.id);" name="first_name<?= $offset ?>1" placeholder="*First Name" title="First Name"/></td>
    <td><input type="text" id="middle_name<?= $offset ?>1" onchange="fname_validate(this.id);" name="middle_name<?= $offset ?>1" placeholder="Middle Name" title="Middle Name"/></td>
    <td><input type="text" id="last_name<?= $offset ?>1" onchange="fname_validate(this.id);" name="last_name<?= $offset ?>1" placeholder="Last Name" title="Last Name"/></td>
    <td><input type="text" id="birth_date<?= $offset ?>1" name="birth_date<?= $offset ?>1" class="app_datepicker" placeholder="*Birth Date" title="Birth Date"  onchange="adolescence_reflect(this.id)" value="<?= date('d-m-Y') ?>"  /></td>
    <td style="width:80px"><input type="text" id="adolescence<?= $offset ?>1" name="adolescence<?= $offset ?>1" placeholder="Adolescence" title="Adolescence" onchange="get_auto_values('balance_date','passport_issue_amount','payment_mode','service_charge','save','true','service_charge')" disabled/></td>
    <td style="width:200px"><select name="received_documents" title="Received Documents" id="received_documents<?= $offset ?>1" multiple>
            <option value="Aadhaar Card">Aadhaar Card</option>
            <option value="Driving Licence">Driving Licence</option>
            <option value="Pan Card">Pan Card</option>
            <option value="Voter Identity Card">Voter Identity Card</option>
            <option value="PassPort">PassPort</option>
            <option value="Telephone Bill">Telephone Bill</option>
            <option value="Electricity Bill">Electricity Bill</option>
            <option value="Ration Card">Ration Card</option>
            <option value="Bank Passbook">Bank Passbook</option>
            <option value="Bank Statement">Bank Statement</option>
            <option value="Employer Letter">Employer Letter</option>
            <option value="Employer Invitation">Employer Invitation</option>
    </select></td>
    <td><input type="text" id="appointment<?= $offset ?>1" name="appointment<?= $offset ?>1" class="app_datepicker" value="<?= date('d-m-Y') ?>"  placeholder="Appointment Date" title="Appointment Date" ></td>
</tr>        