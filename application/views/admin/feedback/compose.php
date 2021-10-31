
	<script src="<?php echo base_url().ADMIN_CSS_JS;?>plugins/jquery_validation_js/jquery.validate.min.js"></script>
	<script src="<?php echo base_url().ADMIN_CSS_JS;?>custom_js/punch_cards_js.js"></script>
	<link rel="stylesheet" href="<?php echo base_url().ADMIN_CSS_JS;?>plugins/multiple-select/multiple-select.css" />
	<script src="<?php echo base_url().ADMIN_CSS_JS;?>plugins/multiple-select/multiple-select.js"></script>
	<script>
		$(function() {
			$('.ms').change(function() {
				console.log($(this).val());
			}).multipleSelect({
				width: '100%'
			});
		});
	</script>
	
	
	
	  <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            User Album
            
          </h1>
		  <a  style="float:right; margin-right: 23px;margin-top: -24px;font-size: 20px;"  href="<?php echo base_url()."Admin/usersAlbumManagement";?>"> Back</a>
          
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
				
				<form id="frm_user_album_add" class="form-horizontal" method="post"  enctype="multipart/form-data"  action="" >
				
                  <div class="box-body">
				  
					
					
					<div class="form-group">
						 <label for="inputEmail3" class="col-sm-2 control-label">Select Users</label>
						<div class="col-sm-10">
							<select class="form-control" name="selected_users" >
							
								<?php if($customers) { ?>
									<?php foreach($customers as $row) { ?>
										<option value="<?php echo $row->user_id;?>"><?php echo $row->user_fullname;?></option>
									<?php } ?>
								<?php } ?>
								
							</select>
							<?php echo form_error('selected_users'); ?>
						</div>
					</div>
					
					
					<div class="form-group">
						 <label for="inputEmail3" class="col-sm-2 control-label">Select Category</label>
						<div class="col-sm-10">
							<select class="ms" multiple="multiple" name="selected_category[]" >
								<?php if($categories) { ?>
									<?php foreach($categories as $row) { ?>
										<option value="<?php echo $row->id;?>"><?php echo $row->name;?></option>
									<?php } ?>
								<?php } ?>
								
							</select>
							<?php echo form_error('selected_category'); ?>
						</div>
					</div>
					
					<div class="form-group">
                      <label class="col-sm-2 control-label">User Album</label>
                      <div class="col-sm-10">
						<input name="user_album_images[]" type="file"  multiple="multiple" >
						<?php echo form_error('user_album_images'); ?>
					  </div>
                    </div>
					
                  </div><!-- /.box-body -->
                  <div class="box-footer">
					
					<button type="submit" value="submit" name="submit" class="btn btn-info pull-right">Save</button>
                  </div>
                </form>
              </div><!-- /.box -->
              <!-- general form elements disabled -->
              
            </div><!--/.col (right) -->
			  
			  
              
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
