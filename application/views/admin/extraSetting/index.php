<script src="<?php echo base_url() . ADMIN_CSS_JS; ?>plugins/jquery_validation_js/jquery.validate.min.js"></script>
<script src="<?php echo base_url() . ADMIN_CSS_JS; ?>custom_js/custom_function_js.js"></script>



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
	<h3 class="box-title suc_msg_hide"><?php echo $this->session->flashdata('suc_msg_extra_setting_update');?></h3>
		<h1>
			Room Type

		</h1>
		<a style="float:right; margin-right: 23px;margin-top: -24px;font-size: 20px;" href="<?php echo base_url() . "Admin/roomTypes"; ?>"> Back</a>

	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">

				<div class="col-md-12">
					<!-- Horizontal Form -->
					<div class="box box-info">
						<div class="box-header with-border">
							
						</div>

						<form id="frm_punch_card_add_update" class="form-horizontal" method="post" enctype="multipart/form-data" action="">
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
							<div class="box-body">



								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Extra Bed Amount</label>
									<div class="col-sm-10">
										<input class="form-control" name="extra_bed_amount" type="text" value="<?php echo $result->extra_bed_amount; ?>">
										<?php echo form_error('extra_bed_amount'); ?>
									</div>
								</div>

								

								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Extra Adult Amount</label>
									<div class="col-sm-10">
										<input class="form-control" name="extra_adult_amount" type="text" value="<?php echo $result->extra_adult_amount; ?>">
										<?php echo form_error('extra_adult_amount'); ?>
									</div>
								</div>

								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Adult Breakfast Amount</label>
									<div class="col-sm-10">
										<input class="form-control" name="extra_adult_breakfast_amount" type="text" value="<?php echo $result->extra_adult_breakfast_amount; ?>">
										<?php echo form_error('extra_adult_breakfast_amount'); ?>
									</div>
								</div>

								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Child Breakfast Amount</label>
									<div class="col-sm-10">
										<input class="form-control" name="extra_child_breakfast_amount" type="text" value="<?php echo $result->extra_child_breakfast_amount; ?>">
										<?php echo form_error('extra_child_breakfast_amount'); ?>
									</div>
								</div>


							




							</div><!-- /.box-body -->
							<div class="box-footer">
								<input name="id" value="<?php echo $result->id; ?>" type="hidden">


								<button type="submit" value="submit" name="submit" class="btn btn-info pull-right">Save</button>
							</div>
						</form>
					</div><!-- /.box -->
					<!-- general form elements disabled -->

				</div>
				<!--/.col (right) -->



			</div><!-- /.col -->
		</div><!-- /.row -->
	</section><!-- /.content -->
</div><!-- /.content-wrapper -->