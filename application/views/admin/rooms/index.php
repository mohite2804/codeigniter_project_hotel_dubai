      <!-- DataTables -->
      <link rel="stylesheet" href="<?php echo base_url() . ADMIN_CSS_JS; ?>plugins/datatables/dataTables.bootstrap.css">
      <!-- DataTables -->
      <script src="<?php echo base_url() . ADMIN_CSS_JS; ?>plugins/datatables/jquery.dataTables.min.js"></script>
      <script src="<?php echo base_url() . ADMIN_CSS_JS; ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
      <script>
        $(function() {
          $("#example1").DataTable();
        });
      </script>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <h3 class="box-title suc_msg_hide"><?php echo $this->session->flashdata('suc_msg_room_type_index');?></h3>
          <h1>
            Rooms Management

          </h1>
          <ol class="breadcrumb">

            <li style="margin-right: 10px;margin-top: -8px;">
              <a href="<?php echo base_url() . 'Admin/addRoom'; ?>"> <button class="btn btn-primary btn-sml">Add</button> </a>
            </li>


          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
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
                        <th class="col-xs-1">Room Type</th> 
                                 
                        <th class="col-xs-1">Name</th>   
                        <th class="col-xs-1">Room Status</th>                      
                        <th class="col-xs-1">Amount</th>                     
                        <th class="col-xs-1">After Discount Amount</th>      
                        <th class="col-xs-1">Save Amount</th>                     
                        <th class="col-xs-1">Save Percentage</th>
                        <th class="col-xs-1">No Of Children</th>                     
                        <th class="col-xs-1">No Of Adults</th>                     
                        <th class="col-xs-2">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (isset($result)) { ?>
                        <?php $i = 1;
                        foreach ($result as $row) { ?>
                          <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $row->room_type; ?></td>
                            <td><?php echo $row->name; ?></td>
                            <td><?php echo ($row->is_free) ? "Not Occupied" : "Occupied"; ?></td>
                            <td><?php echo $row->amount; ?></td>
                            <td><?php echo $row->after_discount_amount; ?></td>
                            <td><?php echo $row->save_amount; ?></td>
                            <td><?php echo $row->save_percentage; ?></td>
                            <td><?php echo $row->no_of_children; ?></td>
                            <td><?php echo $row->no_of_adults; ?></td>
                            <td>
                            
                              <a title="Delete Photo" onclick="return confirm('Are you sure you want to delete?')" href="<?php echo base_url() . 'Admin/deleteRoom/' . $row->id; ?>" >
									              <i class="glyphicon glyphicon-remove"></i>
                              </a>
                              <a title="Edit Photo" href="<?php echo base_url() . 'Admin/editRoom/' . $row->id; ?>"><i class="glyphicon glyphicon-pencil"></i></a>
                            </td>
                          </tr>
                        <?php $i++;
                        } ?>
                      <?php } ?>

                    </tbody>
                    
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->