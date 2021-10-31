	  <div class="content-wrapper">
        <section class="content-header">
          <h1>
           <?php echo ($this->uri->segment(2) == 'editVideo') ? 'Edit Video' : 'Add Video' ?>
		   <a  class="pull-right"  href="<?php echo base_url().'Admin/videoManagement';?>">Back</a>
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
                      <label for="inputEmail3" class="col-sm-2 control-label">Video Name</label>
                      <div class="col-sm-10">
                        <input required="required" type="text"  value="<?php if(!empty($result->video_name)) echo $result->video_name; else echo set_value('video_name');?>" class="form-control" name="video_name" placeholder="Video Name">
						<?php echo form_error('video_name'); ?>
                      </div>
                    </div>
					
                    
					
					<div class="form-group">
                      <label for="inputPassword3" class="col-sm-2 control-label">Video Link</label>
                      <div class="col-sm-10">
                        <input required="required" type="text" value="<?php if(!empty($result->video_link)) echo $result->video_link; else echo set_value('video_link'); ?>" class="form-control" name="video_link" placeholder="Video Link">
						<?php echo form_error('video_link'); ?>
                      </div>
                    </div>
                    
							
					<div style="display:none" class="form-group">
                      <label class="col-sm-2 control-label">Image</label>
                      <div class="col-sm-10">
						<input name="hidden_image" type="hidden" value="<?php if(!empty($result->video_image)) echo $result->video_image;?>" />
                        <input name="video_image" type="file"   >
							<?php if(!empty($result->video_image)){ ?>
								<image  src="<?php echo base_url().'uploads/videos/thumb/'.$result->video_image;?>" />
							<?php } ?>
                      </div>
                    </div>
					
                  </div><!-- /.box-body -->
				  
				  
                  <div  class="box-footer">
					<?php if(!empty($result->id)){ ?>
						<input name="id" type="hidden" value="<?php if(!empty($result->id)) echo $result->id;?>" />
						<input name="updated_at" type="hidden" value="<?php echo date('Y-m-d H:i:s');?>" />
					<?php }else{ ?>
						<input name="created_at" type="hidden" value="<?php echo date('Y-m-d H:i:s');?>" />
					<?php } ?>
                   
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
