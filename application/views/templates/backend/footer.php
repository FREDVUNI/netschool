<footer class="main-footer">
    <strong>Copyright &copy; <?php echo date("Y"); ?><a href="https://netschoolug.com"> Netschool</a>.</strong>
      All rights reserved.
  </footer>
  <aside class="control-sidebar control-sidebar-dark">
  </aside>
</div>

<script src="<?php echo base_url("assets/backend/plugins/jquery/jquery-ui.min.js");?>"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="<?php echo base_url("assets/backend/plugins/bootstrap/js/bootstrap.bundle.min.js");?>"></script>
<script src="<?php echo base_url("assets/backend/plugins/js/Chart.min.js");?>"></script>
<script src="<?php echo base_url("assets/backend/plugins/js/sparkline.js");?>"></script>
<script src="<?php echo base_url("assets/backend/plugins/js/jquery.knob.min.js");?>"></script>
<script src="<?php echo base_url("assets/backend/plugins/js/moment.min.js");?>"></script>
<script src="<?php echo base_url("assets/backend/plugins/js/daterangepicker.js");?>"></script>
<script src="<?php echo base_url("assets/backend/plugins/js/tempusdominus-bootstrap-4.min.js");?>"></script>
<script src="<?php echo base_url("assets/backend/plugins/js/summernote-bs4.min.js");?>"></script>
<script src="<?php echo base_url("assets/backend/plugins/js/jquery.overlayScrollbars.min.js");?>"></script>
<script src="<?php echo base_url("assets/backend/dist/js/adminlte.min.js");?>"></script>
<script src="<?php echo base_url("assets/backend/dist/js/demo.js");?>"></script>
<script src="<?php echo base_url("assets/backend/plugins/js/jquery.dataTables.min.js");?>"></script>
<script src="<?php echo base_url("assets/backend/plugins/js/dataTables.bootstrap4.min.js");?>"></script>
<script src="<?php echo base_url("assets/backend/plugins/js/dataTables.responsive.min.js");?>"></script>
<script src="<?php echo base_url("assets/backend/plugins/js/responsive.bootstrap4.min.js");?>"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script>
  $(function () {
    $("#lessons-datatable").DataTable({
      "responsive": true,
      "autoWidth": false,
      "bStateSave": true,
      "fnStateSave": function (oSettings, oData) {
          localStorage.setItem('lessonsDataTables', JSON.stringify(oData));
      },
      "fnStateLoad": function (oSettings) {
          return JSON.parse(localStorage.getItem('lessonsDataTables'));
      }
    });

    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });

    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "paymenting": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });

  $(".datepicker").datepicker({
    format: "yyyy-mm-dd",
    todayHighlight: true,
    autoclose: true
  });
</script>
<script type="text/javascript">
    $(document).ready(function(){
    setInterval(function(){
    $.ajax({
        url:"<?php echo base_url('admin/notify') ?>",
        type:"POST",
        dataType:"json",
        data:{},
        success:function(data){
        $('#recentpayment').html(data.payments)
          //alert(data.payments);
        }
        });
        },2000);
    });
</script>
</body>
</html>
