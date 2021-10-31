	  <div class="content-wrapper">
        <section class="content-header">
          <h1>
           Site Setting
          </h1>
        </section>

        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              
			<div class="col-md-12">
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo $this->session->flashdata('suc_msg');?></h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" method="post"  enctype="multipart/form-data"  action="" >
                  <div class="box-body">
				  
					<div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Site Name</label>
                      <div class="col-sm-10">
                        <input required="required" type="text"  value="<?php if(!empty($result->name)) echo $result->name; else echo set_value('name');?>" class="form-control" name="name" placeholder="Site Name">
						<?php echo form_error('name'); ?>
                      </div>
                    </div>
					
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Site Email</label>
                      <div class="col-sm-10">
                        <input required="required" type="email"  value="<?php if(!empty($result->email)) echo $result->email; else echo set_value('email'); ?>" class="form-control" name="email" placeholder="Site Email">
						<?php echo form_error('email'); ?>
                      </div>
                    </div>
                    
					
					<div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label">Site Mobile Number 1</label>
                      <div class="col-sm-10">
                        <input required="required" type="text" value="<?php if(!empty($result->mobile_no_1)) echo $result->mobile_no_1; else echo set_value('mobile_no_1'); ?>" class="form-control" name="mobile_no_1" placeholder="Site Mobile Number 1">
						<?php echo form_error('mobile_no_1'); ?>
                      </div>
                    </div>
                    
					<div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label">Site Mobile Number 2</label>
                      <div class="col-sm-10">
                        <input required="required" type="text" value="<?php if(!empty($result->mobile_no_2)) echo $result->mobile_no_2; else echo set_value('mobile_no_2'); ?>" class="form-control" name="mobile_no_2" placeholder="Mobile Number 2">
						<?php echo form_error('mobile_no_2'); ?>
                      </div>
                    </div>
                    
					<div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label">Site Footer</label>
                      <div class="col-sm-10">
                        <input required="required" name="footer" value="<?php if(!empty($result->footer)) echo $result->footer; else echo set_value('footer'); ?>" type="text" class="form-control"  placeholder="Site Footer">
						<?php echo form_error('footer'); ?>
                      </div>
                    </div>
                    
					
							
					<div class="form-group">
                      <label class="col-sm-2 control-label">Site Logo</label>
                      <div class="col-sm-10">
						<input name="hidden_image" type="hidden" value="<?php if(!empty($result->image)) echo $result->image;?>" />
                        <input name="image" type="file"   >
							<?php if(!empty($result->image)){ ?>
								<image  src="<?php echo base_url().'uploads/site/thumb/'.$result->image;?>" />
							<?php } ?>
                      </div>
                    </div>
					
                  </div><!-- /.box-body -->
                  <div class="box-footer">
					
                    <button name="submit" value="submit" type="submit" class="btn btn-info pull-right">Save</button>
                  </div><!-- /.box-footer -->
                </form>
              </div><!-- /.box -->
              <!-- general form elements disabled -->
              
            </div><!--/.col (right) -->
			  
			  
              
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
