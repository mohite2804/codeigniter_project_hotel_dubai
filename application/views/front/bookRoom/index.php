<section class="pro_content">
    <div class="container new-content">
    <?php echo form_open(); ?>
        <div class="row">
        <?php if ($this->session->flashdata('suc_msg')) { ?>
        <div class="room_content suc_msg_hide">
            <div class="row">
                <h3 class="Sign_text box-title suc_msg_hide"><?php echo $this->session->flashdata('suc_msg'); ?></h3>
            </div>
        </div>
    <?php } ?>

    <?php if ($this->session->flashdata('err_msg')) { ?>
        <div class="room_content suc_msg_hide" style="background-color:red">
            <div class="row">
                <h3 class="Sign_text box-title suc_msg_hide"><?php echo $this->session->flashdata('err_msg'); ?></h3>
            </div>
        </div>
    <?php } ?>

            <?php $this->load->view('front/side_panel_filter/index_for_booking'); ?>
            
            <div class="col-12 col-lg-8 col-xl-8 col-md-12 myGroup">
                <?php if ($result) { ?>
                    <?php foreach ($result as $row) { ?>

                        <div class="modal fade roomdetails" id="roominfodetails_<?php echo $row->id; ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title"><?php echo $row->heading; ?></h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <div class="room_content" style="border: none !important;margin-top: 0px !important;padding: 0px !important;">
                                            <div class="row">

                                                <div class="col-12 col-lg-7 col-xl-7 col-md-12">

                                                    <div class="img_box">
                                                        <div id="carouselstudio_newa" class="carousel carouselstudio carousel-fade slide" data-ride="carousel">
                                                            <div class="carousel-inner">

                                                                <?php if ($row->images) { ?>
                                                                    <?php foreach ($row->images as $row_image_key =>  $row_image) { ?>
                                                                        <div class="carousel-item <?php echo ($row_image_key === 0) ? 'active' : '' ?>" style="background-image:url(<?php echo base_url() . FRONT_CSS_JS; ?><?php echo $row_image->image; ?>);"></div>
                                                                    <?php } ?>
                                                                <?php } ?>

                                                            </div>
                                                            <a class="carousel-control-prev" href="#carouselstudio_newa" role="button" data-slide="prev">
                                                                <span class="carousel-control-prev-icon" aria-hidden="true"><img src="<?php echo base_url() . FRONT_CSS_JS; ?>images/prev.png"></span>
                                                                <span class="sr-only">Previous</span>
                                                            </a>
                                                            <a class="carousel-control-next" href="#carouselstudio_newa" role="button" data-slide="next">
                                                                <span class="carousel-control-next-icon" aria-hidden="true"><img src="<?php echo base_url() . FRONT_CSS_JS; ?>images/next.png"></span>
                                                                <span class="sr-only">Next</span>
                                                            </a>
                                                        </div>
                                                    </div>

                                                </div>


                                                <div class="col-12 col-lg-5 col-xl-5 col-md-12 ">
                                                    <div id="rm_details">
                                                        <p class="rmhead">ROOM OVERVIEW</p>
                                                        <p class="rmtext"><?php echo $row->description; ?></p>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>

                                        <div class="container-fluid" id="ser_ame">
                                            <ul class="nav nav-tabs">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-toggle="tab" href="#home">Room Highlights</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#menu1">Room Amenities</a>
                                                </li>
                                            </ul>

                                            <!-- Tab panes -->
                                            <div class="tab-content">
                                                <div id="home" class="container tab-pane active"><br>
                                                    <div class="row">
                                                        <?php if (!empty($row->highlights)) { ?>
                                                            <?php foreach ($row->highlights as $row_highlights) { ?>
                                                                <div class="col-lg-4">
                                                                    <p class="rmtext"><i class="icofont-check-circled"></i><?php echo $row_highlights->title; ?> </p>
                                                                </div>
                                                            <?php  } ?>
                                                        <?php  } ?>


                                                    </div>
                                                </div>
                                                <div id="menu1" class="container tab-pane fade"><br>
                                                    <div class="row">
                                                        <?php if (!empty($row->amenities)) { ?>
                                                            <?php foreach ($row->amenities as $row_amenities) { ?>
                                                                <div class="col-lg-4">
                                                                    <p class="rmtext"><i class="icofont-check-circled"></i> <?php echo $row_amenities->title; ?></p>
                                                                </div>
                                                            <?php  } ?>
                                                        <?php  } ?>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <!-- <button type="button" href="#" class="More_infoBtn" data-dismiss="modal"> Book Now</button> -->

                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="room_content">
                            <div class="row">
                                <div class="col-12 col-lg-5 col-xl-5 col-md-12">
                                    <div class="img_box">
                                        <div id="carouselstudio_new" class="carousel carouselstudio carousel-fade slide" data-ride="carousel">
                                            <div class="carousel-inner">
                                                <?php if ($row->images) { ?>
                                                    <?php foreach ($row->images as $row_image_key =>  $row_image) { ?>
                                                        <div class="carousel-item <?php echo ($row_image_key === 0) ? 'active' : '' ?>" style="background-image:url(<?php echo base_url() . FRONT_CSS_JS; ?><?php echo $row_image->image; ?>);"></div>
                                                    <?php } ?>
                                                <?php } ?>
                                            </div>
                                            <a class="carousel-control-prev" href="#carouselstudio_new" role="button" data-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"><img src="<?php echo base_url() . FRONT_CSS_JS; ?>images/prev.png"></span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                            <a class="carousel-control-next" href="#carouselstudio_new" role="button" data-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"><img src="<?php echo base_url() . FRONT_CSS_JS; ?>images/next.png"></span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-12 col-lg-7 col-xl-7 col-md-12 ">
                                    <h4><?php echo $row->heading; ?></h4>

                                    <p>
                                        Check In: <span>&nbsp;<?php echo isset($selected_data['room_start_date']) ? $selected_data['room_start_date'] : $row->order_start_date_time;  ?></span>
                                        &nbsp;&nbsp;
                                        Check Out: <span><?php echo isset($selected_data['room_end_date']) ?  $selected_data['room_end_date'] : $row->order_end_date_time;  ?></span>
                                    </p>

                                    <p><i class="fa fa-user-o" aria-hidden="true"></i> adults:
                                        <span><?php echo isset($selected_data['room_no_of_adult']) ? $selected_data['room_no_of_adult'] : $row->order_no_of_adults; ?></span>,&nbsp;
                                        Children:
                                        <span><?php echo isset($selected_data['room_no_of_children']) ? $selected_data['room_no_of_children'] : $row->order_no_of_children;  ?></span>
                                    </p>

                                    <div class="Main_price"><span class="price_symbol">AED</span><?php echo $row->total_amount; ?>
                                        <?php if ($row->save_percentage) { ?>
                                            <!-- <span class="off_price">AED <?php echo $row->amount; ?></span> -->
                                            <span class="save_price">
                                                Save <?php echo "AED ". $row->save_amount; ?> (<?php echo $row->save_percentage; ?>%) 
                                            </span>
                                        <?php } ?>

                                    </div>

                                </div>
                            </div>


                            <div class="container-fluid otherinfo">
                                <div class="row">
                                    <div class="col-12 col-lg-4 col-xl-4 col-md-6 ">
                                        <div class="form-group">
                                            <p><label   class="check_content"> You want Breakfast
                                                  
                                                    <input <?php if(!empty($selected_data['you_want_breakfast'])) echo 'checked'; else echo ''; ?> type="checkbox" name="you_want_breakfast" id="you_want_breakfast" onclick="wantBreakfast()">
                                                    <span class="Ch_checkmark"></span>
                                                </label></p>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div id="div_you_want_breakfast" style="display:<?php if (!empty($selected_data['you_want_breakfast'])) echo 'block'; else echo 'none'; ?>" class="container-fluid childinfo ">
                                <div  class="row">
                                        
                                    <?php if($selected_data['room_no_of_children']){?>
                                        <?php $i=0;?>
                                       
                                        <?php for ($x = $selected_data['room_no_of_children']; $x > 0; $x--) { ?>
                                            
                                            
                                            <div class="col-6 col-lg-4 col-xl-4 col-md-6">
                                                <div class="custom_search">
                                                    <p class="book_label_new"> Child Age </p>
                                                    <select name="child_age[]" class="js-example-basic-single_2 " style="width: 100%">
                                                        <option <?php if(!empty($selected_data['multiple_child'][$i] == "0")) echo 'selected'; else echo ''; ?> value="0">Below 10th Years</option>
                                                        <option <?php if(!empty($selected_data['multiple_child'][$i] == "1")) echo 'selected'; else echo ''; ?> value="1">Above 10th Years</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php $i++;?>
                                        <?php } ?>
                                    <?php } ?>


                                </div>
                            </div>


                            <div class="container-fluid otherinfo">
                                <div class="row">
                                    <div class="col-12 col-lg-4 col-xl-4 col-md-6 ">
                                        <div class="form-group">
                                            <p><label class="check_content"> You want extra Bed
                                                    
                                                    <input <?php if (!empty($selected_data['you_want_extra_bed'])) echo 'checked'; else echo ''; ?>  type="checkbox" name="you_want_extra_bed" id="you_want_extra_bed" onclick="wantBreakfast()">
                                                    <span class="Ch_checkmark"></span>
                                                </label></p>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div  id="div_you_want_extra_bed" style="display:<?php if (!empty($selected_data['you_want_extra_bed'])) echo 'block'; else echo 'none'; ?>" class="container-fluid childinfo ">
                                <div class="row">
                                    <div class="col-12 col-lg-4 col-xl-4 col-md-6">
                                        <div class="relativepos pro_ad">
                                            <p class="book_label_new">Bed</p>
                                            <div class="childrenCount row " id="adultnumber">
                                                <div class="children_box">
                                                    <button type="button" class="minusCount" id="bd_minus"><i class="icofont-minus"></i></button>
                                                    <input name="extra_bed_count" type="text" class="adultInput" value="<?php if (!empty($selected_data['extra_bed_count'])) echo $selected_data['extra_bed_count']; else echo '1'; ?>">
                                                    <button type="button" class="addcount active" id="bd_plus"><i class="icofont-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>

                            <input type="submit" name="update_bed_breakfast" value="Update" class="More_infoBtn" \>


                            <hr>

                            <div class="container-fluid ">
                                <div class="text-right">
                                    <button type="button" href="#" class="More_infoBtna" data-toggle="modal" data-target="#roominfodetails_<?php echo $row->id; ?>"> More info</button>
                                   

                                   
                                    <?php if($row->is_free == 0){?>
                                        <h3>Room already booked</h3>
                                    <?php }else{?>
                                        <input type="submit" name="submitBookNow" value="Book Now" class="More_infoBtn" \>
                                    <?php }?>

                                        
                                    

                                    
                                </div>
                            </div>

                        </div>

                    <?php } ?>
                <?php } ?>

            </div>

            
        </div>
        <?php echo form_close(); ?>
    </div>
</section>

<script>
    function wantBreakfast(){
        var you_want_breakfast = document.getElementById("you_want_breakfast");
        var div_you_want_breakfast = document.getElementById("div_you_want_breakfast");

        var you_want_extra_bed = document.getElementById("you_want_extra_bed");
        var div_you_want_extra_bed = document.getElementById("div_you_want_extra_bed");


        if (you_want_breakfast.checked == true){
            div_you_want_breakfast.style.display = "block";
        } else {
            div_you_want_breakfast.style.display = "none";
        }

        if (you_want_extra_bed.checked == true){
            div_you_want_extra_bed.style.display = "block";
        } else {
            div_you_want_extra_bed.style.display = "none";
        }
        
       
        
    }
</script>