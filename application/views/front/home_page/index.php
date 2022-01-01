<section class="Banner_content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-12  col-xl-12 col-md-12 nopadding video_container">
                <div class="h-100 p-3 newbanner" style="background-image:url(<?php echo base_url() . FRONT_CSS_JS; ?>images/bg-img.jpg);">
                    <div class="bannertext myGroup">
                        <div class="new-content container">
                            <?php echo form_open(base_url('products'), array('id' => 'dashboard_form')); ?>
                            <div class="row">


                                <div class="col">
                                    <p class="book_label">Room Type</p>
                                    <select name="room_type" class="js-example-basic-single " style="width: 100%">
                                        <option value="">Select</option>
                                        <?php if ($room_types) { ?>
                                            <?php foreach ($room_types as $row) { ?>
                                                <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>



                                <div class="col">
                                    <div class="relativepos">
                                        <p class="book_label">Rooms</p>
                                        <div class="childrenCount row  " id="Roomnumber">
                                            <div class="children_box">
                                                <button type="button" class="minusCount" id="Rm_minus"><i class="icofont-minus"></i></button>
                                                <input name="no_of_room" value="<?php if (!empty($selected_data['no_of_room'])) echo $selected_data['no_of_room'];
                                                                                else echo '1'; ?>" name="no_of_room" autocomplete="off" type="text" class="adultInput">
                                                <button type="button" class="addcount active" id="Rm_plus"><i class="icofont-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col checKDate">
                                    <p class="book_label">Check In</p>
                                    <input value="<?php if (!empty($selected_data['room_start_date'])) echo $selected_data['room_start_date'];
                                                    else echo set_value('room_start_date'); ?>" name="room_start_date" autocomplete="off" id="startDate" class="form-control" placeholder="Check In" />
                                </div>
                                <div class="col checKDate">
                                    <p class="book_label">Check Out</p>
                                    <input value="<?php if (!empty($selected_data['room_end_date'])) echo $selected_data['room_end_date'];
                                                    else echo set_value('room_end_date'); ?>" name="room_end_date" autocomplete="off" id="endDate" class="form-control" placeholder="Check Out" />
                                </div>
                                <div class="col">
                                    <div class="relativepos">
                                        <p class="book_label">Adult</p>

                                        <div class="childrenCount row  " id="adultnumber">
                                            <div class="children_box">
                                                <button type="button" class="minusCount" id="ad_minus"><i class="icofont-minus"></i></button>
                                                <input name="room_no_of_adult" type="text" class="adultInput" value="<?php if (!empty($selected_data['room_no_of_adult'])) echo $selected_data['room_no_of_adult'];
                                                                                                                        else echo '1'; ?>">
                                                <button type="button" class="addcount active" id="ad_plus"><i class="icofont-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="relativepos">
                                        <p class="book_label">Children</p>
                                        <!-- <button type="button" id="ch_tab" class="childrentab" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="childrennumber" href="#childrennumber"><span>1</span>Room(s) - <span id="chld_count">1</span>Children(s)</button> -->
                                        <div class="childrenCount row  " id="childrennumber">
                                            <div class="children_box">
                                                <button type="button" class="minusCount" id="ch_minus"><i class="icofont-minus"></i></button>
                                                <input name="room_no_of_children" type="text" class="adultInput" value="<?php if (!empty($selected_data['room_no_of_children'])) echo $selected_data['room_no_of_children'];
                                                                                                                        else echo '1'; ?>">
                                                <button type="button" class="addcount active" id="ch_plus"><i class="icofont-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col book_hotel_content">
                                    <!-- <a href="product.html" class="book_hotel">Book Now</a> -->
                                    <div class="col book_hotel_content">
                                        <?php if ($this->session->userdata('user_session')) { ?>
                                            <input type="submit" name="submit" value="Book Now" class="book_hotel" \>
                                        <?php } else { ?>
                                            <a class="book_hotel" href="<?php echo base_url() . 'login'; ?>">Book Now</a>
                                        <?php } ?>


                                    </div>

                                </div>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>








<section class="info_banner">
    <div class="container new-content">
        <div class="row">
            <!-- <div class="col-12 col-lg-12  col-xl-12 col-md-12">
                <h2 class="Title_text text-center"><?php echo $result->heading ?></h2>
                <?php //echo //$result->description 
                ?>
               
                <?php //echo //$result2->description 
                ?>

            </div> -->

            <div class="col-12 col-lg-12  col-xl-12 col-md-12">
                <h2 class="Title_text text-center">Sitara Hotel</h2>
                <p class="Subtitle_text">Sitara Hotel Apartment is the highest Deluxe rated luxury furnished hotel apartment, located in a centrally located bustling Bur Dubai area, in Oud Metha, 5-10 minutes by car from Deira business district, iconic Burj Khalifa and
                    the Dubai Mall, Dubai International Financial Center, Sheikh Zayed Road, Dubai Health Care City and Dubai Airport, amongst many other destinations. Taxis and buses are only steps away. Dubai Metro is 20 minutes’ walk, or minutes
                    by car

                <p id="demo" class="collapse Subtitle_text">
                    Sitara Hotel Apartment features 48 spacious boutique Studio &amp; One Bedroom apartments designed for an executive or extended family staycation with Free Wi-Fi, Tea/Coffee Maker, sat-channels, in-room Safe box,
                    Swimming Pool with a Terrace, jacuzzi, sauna, fitness center, café restaurant and 24 Hour Guest Services team including dine in and laundry services.<br><br> To ensure your safety, all stringent hygiene protocols are strictly
                    followed.
                </p>

                <p style="text-align: left;padding: 0px;" class="img_content"><a data-toggle="collapse" data-target="#demo" href="javascript:void(0)" style="padding: 5px 9px !important;font-size: 11px !important;">Read More</a></p>



                </p>









            </div>
        </div>
    </div>
</section>



<section class="slider_content">
    <div class="container-fluid nopadding">
        <div class="row nomargin">
            <div class="col-12 col-lg-12 col-xl-12 col-md-12">
                <h2 class="Title_text text-center">Rooms</h2>
            </div>
            <div class="col-12 col-lg-12 col-xl-12 col-md-12 top_slide nopadding" dir="ltr" style="direction: ltr;">

                <div class="bxslider" dir="ltr" style="direction: ltr;">
                    <?php if (count($room_type_with_images) > 0) { ?>
                        <?php foreach ($room_type_with_images as $key => $row) { ?>

                            <div class="bx_content">
                                <div class="img_box">
                                    <div id="carouselstudio_<?php echo $key ?>" class="carousel carouselstudio carousel-fade slide" data-ride="carousel">
                                        <div class="carousel-inner">
                                            <?php if (count($row->images) > 0) { ?>
                                                <?php foreach ($row->images as $key_image => $row_image) { ?>
                                                    <div class="carousel-item <?php echo ($key_image === 0) ? 'active' : '' ?>" style="background-image:url('<?php echo base_url() . FRONT_CSS_JS . $row_image; ?>');"></div>
                                                <?php } ?>
                                            <?php } ?>
                                        </div>
                                        <a class="carousel-control-prev" href="#carouselstudio_<?php echo $key ?>" role="button" data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"><img src="<?php echo base_url() . FRONT_CSS_JS; ?>images/prev.png"></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#carouselstudio_<?php echo $key ?>" role="button" data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"><img src="<?php echo base_url() . FRONT_CSS_JS; ?>images/next.png"></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </div>

                                </div>
                                <div class="img_content">
                                    <p><?php echo $row->name; ?> </p>


                                    <?php if ($this->session->userdata('user_session')) { ?>
                                        <a href="<?php echo base_url() . 'product/' . $row->id; ?>">Book Now</a>
                                    <?php } else { ?>
                                        <a href="<?php echo base_url() . 'login'; ?>">Book Now</a>
                                    <?php } ?>


                                </div>
                            </div>


                        <?php } ?>
                    <?php } ?>
                </div>

            </div>
        </div>
    </div>
</section>





<section class="Explore_content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-12 col-xl-12 col-md-12">
                <h2 class="Title_text text-center">Explore Our Hotel</h2>
            </div>
        </div>
        <div class="row">

            <div class="col-lg-6 col-md-12  col-12 Lesspadding">
                <div class="hovereffect">
                    <img class="img-fluid" src="<?php echo base_url() . FRONT_CSS_JS; ?>images/Studio1.jpg" alt="">
                    <div class="overlay">
                        <div>
                            <h2>Rooms</h2>
                            <p class="plus_sign"><i class="icofont-plus"></i></p>
                            <div class="info">

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-12  col-12 Lesspadding">
                <div class="hovereffect">
                    <img class="img-fluid" src="<?php echo base_url() . FRONT_CSS_JS; ?>images/Reception.jpg" alt="">
                    <div class="overlay">
                        <div>
                            <h2>Reception</h2>
                            <p class="plus_sign"><i class="icofont-plus"></i></p>
                            <div class="info">

                            </div>
                        </div>
                    </div>
                </div>
            </div>







        </div>


        <div class="row">



            <div class="col-lg-4 col-md-12  col-12 Lesspadding">
                <div class="hovereffect">
                    <img class="img-fluid" src="<?php echo base_url() . FRONT_CSS_JS; ?>images/Cafe 2.jpg" alt="">
                    <div class="overlay">
                        <div>
                            <h2>Cafe</h2>
                            <p class="plus_sign"><i class="icofont-plus"></i></p>
                            <div class="info">

                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-4 col-md-12  col-12 Lesspadding">
                <div class="hovereffect">
                    <img class="img-fluid" src="<?php echo base_url() . FRONT_CSS_JS; ?>images/Gym 1.jpg" alt="">
                    <div class="overlay">
                        <div>
                            <h2>Gym</h2>
                            <p class="plus_sign"><i class="icofont-plus"></i></p>
                            <div class="info">

                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="col-lg-4 col-md-12  col-12 Lesspadding">
                <div class="hovereffect">
                    <img class="img-fluid" src="<?php echo base_url() . FRONT_CSS_JS; ?>images/Pool 1.jpg" alt="">
                    <div class="overlay">
                        <div>
                            <h2>Pool</h2>
                            <p class="plus_sign"><i class="icofont-plus"></i></p>
                            <div class="info">

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<section class="Good_section">
    <div class="container new-content">
        <div class="row">
            <div class="col-12 col-lg-12 col-xl-12 col-md-12">
                <h2 class="Title_text text-center">Good To Know</h2>
            </div>
        </div>
        <div class="row nomargin">
            <div class="col-12 col-lg-6 col-xl-6 col-md-6 Lesspadding_new">
                <div class="Good_box">
                    <p class="text-center Good_box_ic"><i class="icofont-tags"></i></p>
                    <p class="Good_bx_title">Check in and Check out</p>
                    <p class="Good_bx_sub">Check in from 2:00 pm<br>Check out until 12:00 pm</p>
                </div>
            </div>

            <div class="col-12 col-lg-6 col-xl-6 col-md-6 Lesspadding_new">
                <div class="Good_box">
                    <p class="text-center Good_box_ic"><i class="icofont-pay"></i></p>
                    <p class="Good_bx_title">Payment Options</p>
                    <p class="Good_bx_sub"><img src="<?php echo base_url() . FRONT_CSS_JS; ?>images/payment.svg" class="img-fluid d-block mx-auto" style="    width: 200px;"></p>
                </div>
            </div>


            <div class="col-12 col-lg-4 col-xl-4 col-md-6 Lesspadding_new">
                <div class="Good_box">
                    <p class="text-center Good_box_ic"><i class="icofont-no-smoking"></i></p>
                    <p class="Good_bx_title">All Rooms are Non-Smoking</p>
                </div>
            </div>

            <div class="col-12 col-lg-4 col-xl-4 col-md-6 Lesspadding_new">
                <div class="Good_box">
                    <p class="text-center Good_box_ic"><i class="icofont-car-alt-1"></i></p>
                    <p class="Good_bx_title">Free Basement Parking</p>
                </div>
            </div>

            <div class="col-12 col-lg-4 col-xl-4 col-md-6 Lesspadding_new">
                <div class="Good_box">
                    <p class="text-center Good_box_ic"><i class="icofont-ui-user-group"></i></p>
                    <p class="Good_bx_title">Meeting Room Available</p>
                </div>
            </div>


        </div>
    </div>
</section>


<section class="slider_content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-12 col-xl-12 col-md-12">
                <h2 class="Title_text text-center">Gallery</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-12 col-xl-12 col-md-12 gal_slide nopadding" dir="ltr" style="direction: ltr;">
                <div class="gallery_content">


                    <?php if (count($home_gallery) > 0) { ?>
                        <?php foreach ($home_gallery as $main_key => $main_value) { ?>
                            <div class="glass_slider">
                                <div class="row">
                                    <?php if (count($main_value) > 0) { ?>
                                        <?php foreach ($main_value as $key => $row) { ?>
                                            <div class="col-6 col-lg-4 col-xl-4 col-md-4 Gal_padding">
                                                <div class="gal_img">
                                                    <img src="<?php echo base_url() . FRONT_CSS_JS; ?><?php echo $row['image']; ?>" class="img-fluid">
                                                </div>


                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</section>




<div class="modal" id="ImageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog imageDialog" role="document">
        <div class="modal-content imgmodal-content">
            <div class="modal-header modal-head">
                <!-- <h5 class="modal-title" id="exampleModalLabel">1/<?php echo count($home_gallery_all); ?></h5> -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body zoom_body">
                <div id="carouselExampleControls" class="carousel slide carousel-fade zoom_control" data-ride="carousel">
                    <div class="carousel-inner">
                        <?php if (count($home_gallery_all) > 0) { ?>
                            <?php foreach ($home_gallery_all as $key => $row) { ?>
                                <div class="carousel-item">
                                    <img class="d-block img-fluid mx-auto" src="<?php echo base_url() . FRONT_CSS_JS; ?><?php echo $row['image']; ?>" alt="<?php echo base_url() . FRONT_CSS_JS; ?><?php echo $row['image']; ?>">
                                </div>

                            <?php } ?>
                        <?php } ?>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>