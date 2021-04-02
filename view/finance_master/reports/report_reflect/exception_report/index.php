<?php include "../../../../../model/model.php"; ?>

<div class="app_panel_content Filter-panel">
  <div class="row">
    <div class="col-md-3">
      <select id="exception_report" onchange="get_report_name(this.id);" style="width: 100%;" class="form-control">
        <option value="Negative Ledgers">Negative Ledgers</option>
        <option value="Overdue Receivables">Overdue Receivables</option>
        <option value="Overdue Payables">Overdue Payables</option>
      </select>
    </div>
  </div>
</div>

<div class="main-block" id="div_report2"></div>
<script type="text/javascript">
  function get_report_name(exception_report)
  {
    var exception_report = $('#exception_report').val();

    if(exception_report == 'Negative Ledgers'){
        $.post('report_reflect/exception_report/negative_ledgers/index.php',{  }, function(data){
            $('#div_report2').html(data);
        });
    }
    if(exception_report == 'Overdue Receivables'){
      $.post('report_reflect/exception_report/overdue_receivables/index.php',{ }, function(data){
            $('#div_report2').html(data);
        });
    }
    if(exception_report == 'Overdue Payables'){
      $.post('report_reflect/exception_report/overdue_payables/index.php',{ }, function(data){
            $('#div_report2').html(data);
        });
    }
  }
  get_report_name('exception_report');
</script>
<script src="<?php echo BASE_URL ?>js/app/footer_scripts.js"></script>

