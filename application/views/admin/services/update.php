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
	<h3 class="box-title suc_msg_hide"><?php echo $this->session->flashdata('suc_msg_room_type_update');?></h3>
		<h1>
		<?php echo ($result->service_type_slug == "highlights") ? "Room Highlights" : "Room Amenities"?>

		</h1>
		<a style="float:right; margin-right: 23px;margin-top: -24px;font-size: 20px;" href="<?php echo base_url() . "Admin/editService"; ?>"> Back</a>

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
							<div class="box-body">



								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Name</label>
									<div class="col-sm-10">
										<input class="form-control" name="name" type="text" value="<?php echo $result->title; ?>">
										<?php echo form_error('name'); ?>
									</div>
								</div>


							




							</div><!-- /.box-body -->
							<div class="box-footer">
								<input name="service_id" value="<?php echo $result->id; ?>" type="hidden">
								<input name="service_type_id" value="<?php echo $result->service_type_id; ?>" type="hidden">
								<input name="service_type_slug" value="<?php echo $result->service_type_slug; ?>" type="hidden">


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