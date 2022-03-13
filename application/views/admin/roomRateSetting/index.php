<script src="<?php echo base_url() . ADMIN_CSS_JS; ?>plugins/jquery_validation_js/jquery.validate.min.js"></script>
<script src="<?php echo base_url() . ADMIN_CSS_JS; ?>custom_js/custom_function_js.js"></script>


      <!-- DataTables -->
      <link rel="stylesheet" href="<?php echo base_url() . ADMIN_CSS_JS; ?>plugins/datatables/dataTables.bootstrap.css">
      <!-- DataTables -->
      <script src="<?php echo base_url() . ADMIN_CSS_JS; ?>plugins/datatables/jquery.dataTables.min.js"></script>
      <script src="<?php echo base_url() . ADMIN_CSS_JS; ?>plugins/datatables/dataTables.bootstrap.min.js"></script>



<script>
        $(function() {
          
          $('#example1').DataTable( {
              "scrollX": true
          });

        });
      </script>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
  <h3 class="box-title suc_msg_hide"><?php echo $this->session->flashdata('suc_msg_excel');?></h3>
    <h1>Room Rate Setting </h1>
  

  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">

        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <!--<h3 class="box-title">Horizontal Form</h3>-->
            </div><!-- /.box-header -->
            <!-- form start -->

            <form id="frm_punch_card_add_update" class="form-horizontal" method="post" enctype="multipart/form-data" action="">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
            <input type="hidden" class="csrf_update_gallery" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>"><br>   
              <div class="box-body">


                <div class="form-group">
                  <label class="col-sm-2 control-label">Room Rate Setting</label>
                  <div class="col-sm-10">

                    <input name="room_rate_setting" type="file" multiple="multiple">
                    <br>
                   



                  </div>
                </div>

              </div><!-- /.box-body -->
              <div class="box-footer">
                <input name="created_at" value="<?php echo date('Y-m-d H:i:s'); ?>" type="hidden">
                <button type="submit" value="submit" name="submit" class="btn btn-info pull-right">Save</button>
              </div>
            </form>
          </div><!-- /.box -->
          

        </div>
       


      </div><!-- /.col -->
    </div><!-- /.row -->


    <div class="row">
            <div class="col-xs-12">


              <div class="box">
                <div class="box-header">

                </div><!-- /.box-header -->
                <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th class="col-xs-1">No.</th>
                        <th class="col-xs-1">Room Short Name</th> 
                        <th class="col-xs-1">Year</th>                     
                        <th class="col-xs-1">Month</th>  
                        <?php for($j=1; $j < 32; $j++){ ?>
                          <th class="col-xs-1"><?php echo $j;?></th>
                        <?php } ?>
                        


                        
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (isset($result)) { ?>
                        <?php $i = 1;
                        foreach ($result as $row) { ?>
                          <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $row->room_short_name_type; ?></td>
                            <td><?php echo $row->year; ?></td>
                            <td><?php echo $row->month; ?></td>

                            <?php for($k=1; $k < 32; $k++){ $room_amount = "day_".$k ?>
                              <th class="col-xs-1"><?php echo $row->$room_amount; ?></th>
                            <?php } ?>
                            
                          </tr>
                        <?php $i++; } ?>
                      <?php } ?>

                    </tbody>
                    
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->

  </section><!-- /.content -->
</div><!-- /.content-wrapper -->