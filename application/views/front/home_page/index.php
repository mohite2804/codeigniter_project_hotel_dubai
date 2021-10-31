<section class="Banner_content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-12  col-xl-12 col-md-12 nopadding video_container">
                <!-- <div class="overlay"></div> -->

                <video id="myVideo" autoplay="autoplay" preload="auto" loop="loop" width="100%" height="100%">
                    <source src="<?php echo base_url() . FRONT_CSS_JS; ?>images/video.mp4" type="video/mp4">

                </video>
                <div class="bannertext myGroup">

                    <div class="new-content container">
                        <?php echo form_open(base_url('products'), array('id' => 'front_login')); ?>
                        <div class="row">
                            <div class="col-6 col-lg-3 col-xl-3 col-md-6">
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
                            <div class="col-6 col-lg-2 col-xl-2 col-md-6 checKDate">
                                <p class="book_label">Check In</p>
                                <input autocomplete="off" name="room_start_date" id="startDate" class="form-control" placeholder="Select Date" />
                            </div>
                            <div class="col-6 col-lg-2 col-xl-2 col-md-6 checKDate">
                                <p class="book_label">Check Out</p>
                                <input autocomplete="off" name="room_end_date" id="endDate" class="form-control" placeholder="Select Date" />
                            </div>
                            <div class="col-6 col-lg-2 col-xl-2 col-md-6">
                                <div class="relativepos">
                                    <p class="book_label">Adult</p>
                                    <button type="button" id="ad_tab" class="childrentab" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="adultnumber" href="#adultnumber">
                                        <span id="adlt_count">1</span>Adult(s)
                                    </button>
                                    <div class="childrenCount row collapse " id="adultnumber">
                                        <div class="children_box">
                                            <button type="button" class="minusCount" id="ad_minus"><i class="icofont-minus"></i></button>
                                            <input name="room_no_of_adult" type="text" class="adultInput" value="1">
                                            <button type="button" class="addcount active" id="ad_plus"><i class="icofont-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-2 col-xl-2 col-md-6">
                                <div class="relativepos">
                                    <p class="book_label">Children</p>
                                    <button type="button" id="ch_tab" class="childrentab" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="childrennumber" href="#childrennumber">
                                        <span id="chld_count">1</span>Children(s)</button>
                                    <div class="childrenCount row collapse " id="childrennumber">
                                        <div class="children_box">
                                            <button type="button" class="minusCount" id="ch_minus"><i class="icofont-minus"></i></button>
                                            <input name="room_no_of_children" type="text" class="adultInput" value="1">
                                            <button type="button" class="addcount active" id="ch_plus"><i class="icofont-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-1 col-xl-1 col-md-6 book_hotel_content">
                                <input type="submit" name="submit" value="Book Now" class="book_hotel" \>
                            </div>

                        </div>
                        <?php echo form_close(); ?>
                    </div>


                </div>
            </div>
        </div>

    </div>
</section>

<section class="info_banner">
    <div class="container new-content">
        <div class="row">
            <div class="col-12 col-lg-12  col-xl-12 col-md-12">
                <h2 class="Title_text text-center"><?php echo $result->heading ?></h2>
                <?php echo $result->description ?>
                <h3 class="Title_text"><?php echo $result2->heading ?></h3>
                <?php echo $result2->description ?>

            </div>
        </div>
    </div>
</section>



<section class="slider_content">
    <div class="container-fluid nopadding">
        <div class="row nomargin">
            <div class="col-12 col-lg-12 col-xl-12 col-md-12">
                <h2 class="Title_text text-center">Room</h2>
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
                                    <a href="<?php echo base_url().'product/'.$row->id; ?>">Book Now</a>
                                   
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
            <div class="col-lg-6 col-md-12  col-12 Lesspadding">
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

        </div>
        <div class="row">

            <div class="col-lg-4 col-md-12  col-12 Lesspadding">
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
            <div class="col-lg-4 col-md-12  col-12 Lesspadding">
                <div class="hovereffect">
                    <img class="img-fluid" src="<?php echo base_url() . FRONT_CSS_JS; ?>images/Studio1.jpg" alt="">
                    <div class="overlay">
                        <div>
                            <h2>Studio</h2>
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
            <div class="col-12 col-lg-4 col-xl-4 col-md-12 Lesspadding_new">
                <div class="Good_box">
                    <p class="text-center Good_box_ic"><i class="icofont-tags"></i></p>
                    <p class="Good_bx_title">Check in and Check out</p>
                    <p class="Good_bx_sub">Check in from 3:00 pm<br>Check out until 12:00 pm</p>
                </div>
            </div>
            <div class="col-12 col-lg-4 col-xl-4 col-md-12 Lesspadding_new">
                <div class="Good_box">
                    <p class="text-center Good_box_ic"><i class="icofont-car-alt-1"></i></p>
                    <p class="Good_bx_title">Complimentary Shuttle</p>

                </div>
            </div>
            <div class="col-12 col-lg-4 col-xl-4 col-md-12 Lesspadding_new">
                <div class="Good_box">
                    <p class="text-center Good_box_ic"><i class="icofont-globe"></i></p>
                    <p class="Good_bx_title">Languages spoken at the hotel</p>
                    <p class="Good_bx_sub">English, Arabic</p>
                </div>
            </div>
            <div class="col-12 col-lg-4 col-xl-4 col-md-12 Lesspadding_new">
                <div class="Good_box">
                    <p class="text-center Good_box_ic"><i class="icofont-pay"></i></p>
                    <p class="Good_bx_title">Payment Options</p>
                    <p class="Good_bx_sub"><img src="<?php echo base_url() . FRONT_CSS_JS; ?>images/payment.svg" class="img-fluid d-block mx-auto" style="    width: 200px;"></p>
                </div>
            </div>
            <div class="col-12 col-lg-4 col-xl-4 col-md-12 Lesspadding_new">
                <div class="Good_box">
                    <p class="text-center Good_box_ic"><i class="icofont-group-students"></i></p>
                    <p class="Good_bx_title">Family</p>

                </div>
            </div>
            <div class="col-12 col-lg-4 col-xl-4 col-md-12 Lesspadding_new">
                <div class="Good_box">
                    <p class="text-center Good_box_ic"><i class="icofont-building-alt"></i></p>
                    <p class="Good_bx_title">City</p>

                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-6 col-md-12 Lesspadding_new">
                <div class="Good_box">
                    <p class="text-center Good_box_ic"><i class="icofont-ui-user-group"></i></p>
                    <p class="Good_bx_title">Meetings</p>

                </div>
            </div>
            <div class="col-12 col-lg-6 col-xl-6 col-md-12 Lesspadding_new">
                <div class="Good_box">
                    <p class="text-center Good_box_ic"><i class="icofont-cart-alt"></i></p>
                    <p class="Good_bx_title">Shopping</p>

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

<?php $this->load->view('front/newsletter_page/index'); ?>