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
          <h1> Orders</h1>
          <ol class="breadcrumb"> </ol>
        </section>



        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">

              <div class="form-group">
                <label>Date range:</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input id="reservation" name="date_range" type="text" class="form-control pull-right data_range">
                </div>
              </div>

              <form class="form-inline" action="" method="post">


                <div class="form-group">
                  <label for="email">Status:</label>
                  <select name="payment_status" class="form-control">
                    <option value="">All</option>
                    <option value="pe">Pending</option>
                    <option value="pa">Paid</option>
                    <option value="c">Canceled</option>
                  </select>
                </div>




                <div class="form-group">
                  <label>Date range:</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input id="reservation" name="date_range" type="text" class="form-control pull-right data_range">
                  </div>
                </div>

                <input type="submit" name="submit" value="submit" class="btn btn-primary">
              </form>


            </div>


            <div class="col-xs-12">

              <br><br>

              <div class="box">
                <div class="box-header">
                </div><!-- /.box-header -->
                <div class="box-body">



                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th class="col-xs-1">No.</th>
                        <th class="col-xs-2">Room Type</th>
                        <th class="col-xs-2">Full Name</th>
                        <th class="col-xs-1">Email</th>
                        <th class="col-xs-1">Mobile No</th>

                        <th class="col-xs-1">No of Adults</th>
                        <th class="col-xs-1">No of Children</th>
                        <th class="col-xs-1">Start Date</th>
                        <th class="col-xs-1">End Date</th>
                        <th class="col-xs-1">Amount</th>

                        <th class="col-xs-1">Payment Status</th>


                      </tr>
                    </thead>
                    <tbody>
                      <?php if (isset($result)) { ?>
                        <?php $i = 1;
                        foreach ($result as $row) { ?>
                          <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $row->room_type; ?></td>
                            <td><?php echo $row->user_fullname; ?></td>
                            <td><?php echo $row->user_email; ?></td>
                            <td><?php echo $row->user_mobile_no_1; ?></td>

                            <td><?php echo $row->no_of_adults; ?></td>
                            <td><?php echo $row->no_of_children; ?></td>
                            <td><?php echo $row->start_date_time; ?></td>
                            <td><?php echo $row->end_date_time; ?></td>
                            <td><?php echo $row->amount; ?></td>

                            <td><?php echo $row->status; ?></td>

                          </tr>
                        <?php $i++;
                        } ?>
                      <?php } ?>

                    </tbody>
                    <tfoot>
                      <th class="col-xs-1">No.</th>
                      <th class="col-xs-2">Room Type</th>
                      <th class="col-xs-2">Full Name</th>
                      <th class="col-xs-1">Email</th>
                      <th class="col-xs-1">Mobile No</th>

                      <th class="col-xs-1">No of Adults</th>
                      <th class="col-xs-1">No of Children</th>
                      <th class="col-xs-1">Start Date</th>
                      <th class="col-xs-1">End Date</th>
                      <th class="col-xs-1">Amount</th>

                      <th class="col-xs-1">Payment Status</th>
                    </tfoot>
                  </table>

                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->