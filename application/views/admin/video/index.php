      <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url().ADMIN_CSS_JS;?>plugins/datatables/dataTables.bootstrap.css">
	<!-- DataTables -->
    <script src="<?php echo base_url().ADMIN_CSS_JS;?>plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url().ADMIN_CSS_JS;?>plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script>
      $(function () {
        $("#example1").DataTable();
      });
    </script>
	  
	  <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Video Management
            
          </h1>
          <ol class="breadcrumb">
            
            <li style="margin-right: 10px;margin-top: -8px;" > 
			  <a href="<?php echo base_url().'Admin/addVideo';?>">	<button class="btn btn-primary btn-sml" >Add</button>  </a>
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
						<th class="col-xs-5">Video Name</th>
                       <!-- <th class="col-xs-2">Video Image</th> -->
						<th class="col-xs-1">Action</th>
                      </tr>
                    </thead>
                    <tbody>
					<?php if(isset($result)){ ?>
						<?php $i=1; foreach($result as $row){ ?>
							<tr>
								<td><?php echo $i; ?></td>
								<td><?php echo $row->video_name; ?></td>
								<!--<td><?php //echo $row->video_image; ?></td>-->
								<td>
									<a title="Delete Video" onclick="return confirm('Are you sure you want to delete?')" href="<?php echo base_url().'Admin/deleteVideo/'. $row->id;?>" ><i class="glyphicon glyphicon-remove"></i></a>
									<a title="Edit Video" href="<?php echo base_url().'Admin/editVideo/'. $row->id;?>" ><i class="glyphicon glyphicon-pencil"></i></a>									
								
															
									
								</td>
								</tr>
						<?php $i++;} ?>
					<?php } ?>
                      
                      </tbody>
                    <tfoot>
						<th class="col-xs-1">No.</th>
						<th class="col-xs-5">Video Name</th>
                        <!-- <th class="col-xs-2">Video Image</th> -->
						<th class="col-xs-1">Action</th>	
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
