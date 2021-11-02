<script src="<?php echo base_url() . ADMIN_CSS_JS; ?>plugins/jquery_validation_js/jquery.validate.min.js"></script>
<script src="<?php echo base_url() . ADMIN_CSS_JS; ?>custom_js/custom_function_js.js"></script>
<!--<link rel="stylesheet" href="<?php //echo base_url().ADMIN_CSS_JS;
									?>plugins/multiple-select/multiple-select.css" />
	<script src="<?php echo base_url() . ADMIN_CSS_JS; ?>plugins/multiple-select/multiple-select.js"></script>
	<script>
		$(function() {
			$('#ms').change(function() {
				console.log($(this).val());
			}).multipleSelect({
				width: '100%'
			});
		});
	</script>-->



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Room Type

		</h1>
		<a  style="float:right; margin-right: 23px;margin-top: -24px;font-size: 20px;"  href="<?php echo base_url()."Admin/roomTypes";?>"> Back</a>

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

							<div class="box-body">



								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Name</label>
									<div class="col-sm-10">
										<input class="form-control" name="name" type="text" value="<?php echo $result->name; ?>">
										<?php echo form_error('name'); ?>
									</div>
								</div>


								<div class="form-group">
									<label class="col-sm-2 control-label">Images</label>
									<div class="col-sm-10">

										<input name="image[]" type="file" multiple="multiple">
										<br>
										<?php if (!empty($images)) { ?>
											<?php foreach ($images as $row) { ?>
												<span id="image_delete_<?php echo $row->id; ?>">
													<image style="width: 100px; heigh:100px" src="<?php echo base_url() . FRONT_CSS_JS; ?><?php echo $row->image; ?>" />
													<span style="cursor:pointer" onclick="deleteRoomTypeImage(<?php echo $row->id; ?>)"><i class="glyphicon glyphicon-remove"></i></span>
												</span>
											<?php } ?>
										<?php } ?>
									</div>
								</div>

								



							</div><!-- /.box-body -->
							<div class="box-footer">
								<input name="room_type_id" value="<?php echo $result->id; ?>" type="hidden">
							
							
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