
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
                        <button type="button" href="#" class="More_infoBtn" data-dismiss="modal"> Book Now</button>

                    </div>

                </div>
            </div>
        </div>

