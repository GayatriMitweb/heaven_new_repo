<?php
include '../../../model/model.php';
?>
<select id="tax_report_list1" width="100%" class="form-control" onchange="cancel_tax_report_reflect(this.id);">
	<option value="Sale">Sale</option>
	<option value="Purchase">Purchase</option>
</select>