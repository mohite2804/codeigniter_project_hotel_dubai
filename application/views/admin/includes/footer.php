
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          
        </div>
        <strong>Copyright &copy; 2015-2016 .</strong> All rights reserved.
      </footer>
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

  
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url().ADMIN_CSS_JS;?>bootstrap/js/bootstrap.min.js"></script>
    <!-- Select2 -->
    <script src="<?php echo base_url().ADMIN_CSS_JS;?>plugins/select2/select2.full.min.js"></script>
    <!-- InputMask -->
    <script src="<?php echo base_url().ADMIN_CSS_JS;?>plugins/input-mask/jquery.inputmask.js"></script>
    <script src="<?php echo base_url().ADMIN_CSS_JS;?>plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="<?php echo base_url().ADMIN_CSS_JS;?>plugins/input-mask/jquery.inputmask.extensions.js"></script>
    <!-- date-range-picker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <script src="<?php echo base_url().ADMIN_CSS_JS;?>plugins/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap color picker -->
    <script src="<?php echo base_url().ADMIN_CSS_JS;?>plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
    <!-- bootstrap time picker -->
    <script src="<?php echo base_url().ADMIN_CSS_JS;?>plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="<?php echo base_url().ADMIN_CSS_JS;?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- iCheck 1.0.1 -->
    <script src="<?php echo base_url().ADMIN_CSS_JS;?>plugins/iCheck/icheck.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url().ADMIN_CSS_JS;?>plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url().ADMIN_CSS_JS;?>dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url().ADMIN_CSS_JS;?>dist/js/demo.js"></script>

   


  </body>
</html>

<style>
  .error{
    color : red;
  }
</style


<script>
  $(document).ready(function() {
   
    $('#reservation').daterangepicker();
    $('.suc_msg_hide').delay(5000).fadeOut('slow');
  });
  
</script>