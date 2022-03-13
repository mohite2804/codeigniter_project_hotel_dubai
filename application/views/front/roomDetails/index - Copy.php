<section class="pro_content">
    <div class="container new-content">
        <div class="row">
            <div class="col-12 col-lg-12 col-xl-12 col-md-12 myGroup">
                <?php if ($result) { ?>
                    <?php foreach ($result as $row) { ?>
                        <div class="room_content">
                            <div class="row">
                                <div class="col-12 col-lg-12 col-xl-12 col-md-12">
                                    <div class="img_box" style="height:400px;">
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


                                <div class="col-12 col-lg-12 col-xl-12 col-md-12 ">
                                    <h4><?php echo $row->heading; ?></h4>
                                </div>

                                <div class="col-12 col-lg-5 col-xl-12 col-md-12 ">
                                    <div id="rm_details">
                                        <p class="rmhead">ROOM OVERVIEW</p>
                                        <p class="rmtext"><?php echo $row->description; ?></p>
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

                                <div class="col-12 col-lg-5 col-xl-12 col-md-12 ">
                                    <div class="text-right">
                                    <a href="<?php echo base_url() . 'product/' . $row->id; ?>">
                                            <button type="button" class="More_infoBtn"> Book Now</button>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
</section>



<section class="slider_content">
    <div class="container-fluid nopadding">
        <div class="row nomargin">
            <div class="col-12 col-lg-12 col-xl-12 col-md-12">
                <h2 class="Title_text text-center">Another Accommodations</h2>
            </div>
            <div class="col-12 col-lg-12 col-xl-12 col-md-12 top_slide nopadding" dir="ltr" style="direction: ltr;">
                <div class="bxslider" dir="ltr" style="direction: ltr;">


                

                    <div class="bx_content">
                        <div class="img_box">
                            <div id="carouselstudio" class="carousel carouselstudio carousel-fade slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active" style="background-image:url('images/studio.jpg');">
                                    </div>
                                    <div class="carousel-item" style="background-image:url('images/hotel-1.jpg');">
                                    </div>
                                    <div class="carousel-item" style="background-image:url('images/hotel-2.jpg');">
                                    </div>
                                </div>
                                <a class="carousel-control-prev" href="#carouselstudio" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"><img src="<?php echo base_url() . FRONT_CSS_JS; ?>images/prev.png"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselstudio" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"><img src="<?php echo base_url() . FRONT_CSS_JS; ?>images/next.png"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                        <div class="img_content">
                            <p>Room One</p>
                            <a href="room_view.html">More Info</a>
                        </div>
                    </div>

                    

                    








                </div>

            </div>
        </div>
    </div>
</section>