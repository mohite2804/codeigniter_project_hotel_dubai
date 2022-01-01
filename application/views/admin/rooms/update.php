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
		<h3 class="box-title suc_msg_hide"><?php echo $this->session->flashdata('suc_msg_room_type_update'); ?></h3>
		<h1>
			Room Type

		</h1>
		<a style="float:right; margin-right: 23px;margin-top: -24px;font-size: 20px;" href="<?php echo base_url() . "Admin/rooms"; ?>"> Back</a>

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
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
							<div class="box-body">



								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Name</label>
									<div class="col-sm-10">
										<input class="form-control" name="name" type="text" value="<?php echo $result->name; ?>">
										<?php echo form_error('name'); ?>
									</div>
								</div>

								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Room Types </label>
									<div class="col-sm-10">
										<select class="form-control" name="room_type_id">
											<option value="">Room Types</option>
											<?php if ($room_types) { ?>
												<?php foreach ($room_types as $row) { ?>
													<option <?php echo ($row->id == $result->room_type_id) ? "selected" : "" ?> value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
												<?php } ?>
											<?php } ?>


										</select>
										<?php echo form_error('no_of_children'); ?>
									</div>
								</div>

								<!-- <div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">No Of Children</label>
									<div class="col-sm-10">


										<select class="form-control" name="no_of_children">
											<option value="">No Of Children</option>

											<?php if ($numbers) { ?>
												<?php foreach ($numbers as $row) { ?>
													<option <?php echo ($row == $result->no_of_children) ? "selected" : "" ?> value="<?php echo $row; ?>"><?php echo $row; ?></option>
												<?php } ?>
											<?php } ?>


										</select>
										<?php echo form_error('no_of_children'); ?>
									</div>
								</div>

								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">No Of Adults</label>
									<div class="col-sm-10">
										<select class="form-control" name="no_of_adults">
											<option value="">No Of Adults</option>
											<?php if ($numbers) { ?>
												<?php foreach ($numbers as $row) { ?>
													<option <?php echo ($row == $result->no_of_adults) ? "selected" : "" ?> value="<?php echo $row; ?>"><?php echo $row; ?></option>
												<?php } ?>
											<?php } ?>
										</select>

										<?php echo form_error('no_of_adults'); ?>
									</div>
								</div> -->


								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Amount</label>
									<div class="col-sm-10">

										<input value="<?php echo $result->amount; ?>" class="form-control" name="amount" type="text">
										<?php echo form_error('amount'); ?>
									</div>
								</div>

								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Discount</label>
									<div class="col-sm-10">
										<select class="form-control" name="save_percentage">
											<option value="">Discount</option>
											<?php if ($discounts) { ?>
												<?php foreach ($discounts as $row) { ?>
													<option <?php echo ($row == $result->save_percentage) ? "selected" : "" ?> value="<?php echo $row; ?>"><?php echo $row; ?>%</option>
												<?php } ?>
											<?php } ?>
										</select>


										<?php echo form_error('save_percentage'); ?>
									</div>
								</div>



								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Description</label>
									<div class="col-sm-10">

										<textarea class="form-control" name="description"><?php echo $result->description; ?></textarea>
										<?php echo form_error('description'); ?>
									</div>
								</div>



								<div class="form-group">
									<label class="col-sm-2 control-label">Images</label>
									<div class="col-sm-10">
										<input type="hidden" class="csrf_update_room_type" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>"><br>
										<input name="image[]" type="file" multiple="multiple">
										<p style="color:red" >Note : Please upload image upto 1 MB.     Maximum 3 images you can upload.</p>
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



								<div class="form-group">
									<label class="col-sm-2 control-label">Room Highlights</label>
									<div class="col-sm-10">
										<?php if ($services) { ?>
											<ul style="list-style: none;">
												<?php foreach ($services as $row) { ?>
													<?php if ($row->service_type_id == 1) { ?>
													<li>
														<input <?php echo (in_array($row->id, $room_highlight)) ? "checked" : "" ?>  name="room_highlight[]" type="checkbox" value="<?php echo $row->id; ?>"><?php echo "  " . $row->title; ?>
													</li>
													<?php } ?>
												<?php } ?>
											</ul>
										<?php } ?>

										<?php echo form_error('room_highlight'); ?>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label">In-Room Amenities</label>
									<div class="col-sm-10">
										<?php if ($services) { ?>
											<ul style="list-style: none;">
												<?php foreach ($services as $row) { ?>
													<?php if ($row->service_type_id == 2) { ?>
													<li>
														<input <?php echo (in_array($row->id, $room_amenities)) ? "checked" : "" ?>  name="room_amenities[]" type="checkbox" value="<?php echo $row->id; ?>"><?php echo "  " . $row->title; ?>
													</li>
													<?php } ?>
												<?php } ?>
											</ul>
										<?php } ?>

										<?php echo form_error('room_amenities'); ?>
									</div>
								</div>

							




							</div><!-- /.box-body -->
							<div class="box-footer">
								<input name="room_id" value="<?php echo $result->id; ?>" type="hidden">


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