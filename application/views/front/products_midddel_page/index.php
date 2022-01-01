<div class="col-12 col-lg-8 col-xl-8 col-md-12 myGroup">
    <?php if($this->session->flashdata('suc_msg')){?>
    <div class="room_content suc_msg_hide">
        <div class="row">
            <h3 class="Sign_text box-title suc_msg_hide"><?php echo $this->session->flashdata('suc_msg'); ?></h3>
        </div>
    </div>
    <?php } ?>

    <?php if ($result) { ?>
        <?php foreach ($result as $row) { ?>


            <div class="room_content">
                <div class="row">
                    <div class="col-12 col-lg-5 col-xl-5 col-md-12">
                        <?php if ($row->images) { ?>
                            <?php foreach ($row->images as $row_image_key =>  $row_image) { ?>
                                <?php if ($row_image_key == 0) { ?>
                                    <img src="<?php echo base_url() . FRONT_CSS_JS; ?><?php echo $row_image->image; ?>" class="img-fluid d-block mx-auto">
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>


                    </div>
                    <div class="col-12 col-lg-7 col-xl-7 col-md-12 ">
                        <h4><?php echo $row->heading; ?></h4>
                        <p><i class="fa fa-user-o" aria-hidden="true"></i>
                            Adults:
                            <span><?php echo isset($selected_data['room_no_of_adult']) ? $selected_data['room_no_of_adult'] : ""; ?></span>,&nbsp;
                            <!-- <span><?php //echo $row->no_of_adults; 
                                        ?></span>,&nbsp;  -->

                            Children:
                            <span><?php echo isset($selected_data['room_no_of_children']) ? $selected_data['room_no_of_children'] : ""; ?></span>
                            <!-- <span><?php //echo $row->no_of_children; 
                                        ?></span> -->
                        </p>
                        <p>
                            Check In: <span>&nbsp;<?php echo isset($selected_data['room_start_date']) ? $selected_data['room_start_date'] : ""; ?></span>
                            &nbsp;&nbsp;
                            Check Out: <span><?php echo isset($selected_data['room_end_date']) ?  $selected_data['room_end_date'] : ""; ?></span>
                        </p>

                        <div class="Main_price"><span class="price_symbol">$</span><?php echo $row->after_discount_amount; ?>
                            <?php if ($row->save_percentage) { ?>
                                <span class="off_price">$<?php echo $row->amount; ?></span>
                                <span class="save_price">
                                    Save <?php echo $row->save_amount; ?> (<?php echo $row->save_percentage; ?>%)
                                </span>
                            <?php } ?>

                        </div>




                        <div class="text-right">
                            <button type="button" data-toggle="collapse" href="#expand_info_new_<?php echo $row->id; ?>" aria-expanded="false" aria-controls="expand_info" class="More_infoBtn"> More info</button>
                        </div>
                    </div>
                    <div class="collapse col-12 col-lg-12 col-xl-12 expand_cls" id="expand_info_new_<?php echo $row->id; ?>">
                        <div class="services_list row">
                            <div class="col-12 col-lg-12 col-xl-12 col-md-12">
                                <h4><?php echo $row->name; ?></h4>
                                <h6 class="services_list_para"><?php echo $row->description; ?></h6>

                                <h4>Room Highlights</h4>
                                <ul class="row">

                                    <?php if (!empty($row->highlights)) { ?>
                                        <?php foreach ($row->highlights as $row_highlights) { ?>
                                            <li class="col-12 col-lg-6 col-xl-6 col-md-12">
                                                <div>
                                                    <span><?php echo $row_highlights->image; ?></span><?php echo $row_highlights->title; ?>
                                                </div>
                                            </li>
                                        <?php  } ?>
                                    <?php  } ?>

                                </ul>
                            </div>
                        </div>
                        <div class="services_list row">
                            <div class="col-12 col-lg-12 col-xl-12 col-md-12">
                                <h4>In-room amenities </h4>
                                <ul class="row">

                                    <?php if (!empty($row->amenities)) { ?>
                                        <?php foreach ($row->amenities as $row_amenities) { ?>
                                            <li class="col-12 col-lg-6 col-xl-6 col-md-12">
                                                <div>
                                                    <span><?php echo $row_highlights->image; ?></span><?php echo $row_amenities->title; ?>
                                                </div>
                                            </li>
                                        <?php  } ?>
                                    <?php  } ?>


                                </ul>
                            </div>
                        </div>
                        <div class="col-12 col-lg-12 col-xl-12 col-md-12 text-lg-right">

                            <?php if ($this->uri->segment(1) == 'product' || $this->uri->segment(1) == 'products') { ?>

                                <?php if ($row->is_free == 0) { ?>
                                    <h3>This room is already occupied you can not book room.</h3>
                                <?php } else { ?>


                                    <?php if ($this->session->userdata('user_session')) { ?>
                                        <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>buynow">
                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                            <input type="hidden" name="id" value="<?php echo $row->id ?>">
                                            <input type="hidden" name="room_start_date" value="<?php if (!empty($selected_data['room_start_date'])) echo $selected_data['room_start_date'];
                                                                                                else echo set_value('room_start_date'); ?>">
                                            <input type="hidden" name="room_end_date" value="<?php if (!empty($selected_data['room_end_date'])) echo $selected_data['room_end_date'];
                                                                                                else echo set_value('room_end_date'); ?>">


                                            <input type="submit" name="submit" value="Book Now" class="Bookbtn" />
                                        </form>
                                    <?php } else { ?>
                                        <a href="<?php echo base_url() . 'login'; ?>" class="Bookbtn">Book Now</a>
                                    <?php } ?>

                                <?php } ?>

                            <?php } ?>

                        </div>
                    </div>


                </div>
            </div>



        <?php } ?>
    <?php } ?>
</div>