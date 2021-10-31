<section class="pro_content">
    <div class="container new-content">
        <div class="row">






            <div class="col-12 col-lg-12 col-xl-12 col-md-12">

               
            <?php if($result){ ?>
                    <?php foreach($result as $row){ ?>

                        <div class="room_content">
                            <div class="row">
                                <div class="col-12 col-lg-5 col-xl-5 col-md-12">
                                    <img src="<?php echo base_url() . FRONT_CSS_JS; ?><?php echo $row->image; ?>" class="img-fluid d-block mx-auto">
                                </div>
                                <div class="col-12 col-lg-7 col-xl-7 col-md-12 ">
                                    <h4><?php echo $row->heading; ?></h4>
                                    <p><i class="fa fa-user-o" aria-hidden="true"></i> adults: <span>6</span>,&nbsp; Children: <span>3</span></p>
                                    <p>Check In: <span>&nbsp;21/09/2021</span>&nbsp;&nbsp; Check Out: <span>22/09/2021</span></p>

                                    <div class="Main_price"><span class="price_symbol">
                                        $</span><?php echo $row->after_discount_amount; ?> 
                                        <span class="off_price">   $<?php echo $row->amount; ?></span><span class="save_price">   Save $<?php echo $row->save_amount; ?> (<?php echo $row->save_percentage; ?>%)</span>
                                    </div>




                                    <div class="text-right">
                                        <button type="button" data-toggle="collapse" href="#expand_info_new" aria-expanded="false" aria-controls="expand_info" class="More_infoBtn"> More info</button>
                                    </div>
                                </div>
                                <div class="collapse col-12 col-lg-12 col-xl-12 expand_cls" id="expand_info_new">
                                    <div class="services_list row">
                                        <div class="col-12 col-lg-12 col-xl-12 col-md-12">
                                            <h4>Room Services</h4>
                                            <ul>
                                                <li class="col-12 col-lg-4 col-xl-4 col-md-12">
                                                    <div class="Room_serv">
                                                        <span><i class="fa fa-wifi"></i></span> Wifi
                                                    </div>
                                                </li>
                                                <li class="col-12 col-lg-4 col-xl-4 col-md-12">
                                                    <div class="Room_serv">
                                                        <span><i class="fa fa-bath"></i></span> Sauna
                                                    </div>
                                                </li>
                                                <li class="col-12 col-lg-4 col-xl-4 col-md-12">
                                                    <div class="Room_serv">
                                                        <span><i class="fa fa-cutlery"></i></span> Breakfast
                                                    </div>
                                                </li>
                                                <li class="col-12 col-lg-4 col-xl-4 col-md-12">
                                                    <div class="Room_serv">
                                                        <span><i class="fa fa-coffee"></i></span> Coffee Maker
                                                    </div>
                                                </li>
                                                <li class="col-12 col-lg-4 col-xl-4 col-md-12">
                                                    <div class="Room_serv">
                                                        <span><i class="fa fa-glass"></i></span> Mini Bar
                                                    </div>
                                                </li>
                                                <li class="col-12 col-lg-4 col-xl-4 col-md-12">
                                                    <div class="Room_serv">
                                                        <span><i class="fa fa-snowflake-o"></i></span> Air Conditioner
                                                    </div>
                                                </li>
                                                <li class="col-12 col-lg-4 col-xl-4 col-md-12">
                                                    <div class="Room_serv">
                                                        <span><i class="fa fa-eye-slash"></i></span> Private Balcony
                                                    </div>
                                                </li>
                                                <li class="col-12 col-lg-4 col-xl-4 col-md-12">
                                                    <div class="Room_serv">
                                                        <span><i class="fa fa-television"></i></span> Widescreen TV
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="services_list row">
                                        <div class="col-12 col-lg-12 col-xl-12 col-md-12">
                                            <h4>Additional Services</h4>
                                            <ul>
                                                <li class="col-12 col-lg-4 col-xl-4 col-md-12">
                                                    <div class="Room_serv">
                                                        <span><i class="fa fa-car"></i></span> Airport Pickup
                                                    </div>
                                                </li>
                                                <li class="col-12 col-lg-4 col-xl-4 col-md-12">
                                                    <div class="Room_serv">
                                                        <span><i class="fa fa-bath"></i></span> Massage & Spa
                                                    </div>
                                                </li>
                                                <li class="col-12 col-lg-4 col-xl-4 col-md-12">
                                                    <div class="Room_serv">
                                                        <span><i class="fa fa-cutlery"></i></span> Sightseeing Tour
                                                    </div>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-12 col-xl-12 col-md-12 text-lg-right">
                                        <a href="" class="Bookbtn">Book Now</a>
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