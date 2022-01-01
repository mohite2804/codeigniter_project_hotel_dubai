
<div class="col-12 col-lg-8 col-xl-8 col-md-12">
    <?php if($result){ ?>
        <?php foreach($result as $row){ ?>

            <div class="room_content">
                <div class="row">
                    <div class="col-12 col-lg-5 col-xl-5 col-md-12">
                        <img src="<?php echo base_url() . FRONT_CSS_JS; ?><?php echo $row->room_image; ?>" class="img-fluid d-block mx-auto">
                    </div>
                    <div class="col-12 col-lg-7 col-xl-7 col-md-12 ">
                        <h4><?php echo $row->heading; ?></h4>
                        <p><i class="fa fa-user-o" aria-hidden="true"></i> adults: <span><?php echo $row->no_of_adults; ?></span>,&nbsp; Children: <span><?php echo $row->no_of_children; ?></span></p>
                        <p>Check In: <span>&nbsp;<?php echo isset($selected_data['room_start_date'])  ; ?></span>&nbsp;&nbsp; Check Out: <span><?php echo isset($selected_data['room_end_date']) ; ?></span></p>

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
                                    <?php if($row->services){ ?>
                                        <?php foreach($row->services as $row_service){ ?>
                                            <?php  if($row_service->service_amount < 1){ ?>
                                                <li class="col-12 col-lg-4 col-xl-4 col-md-12">
                                                    <div class="Room_serv">
                                                        <span><i class="fa fa-wifi"></i></span> <?php echo $row_service->service_name;?>
                                                    </div>
                                                </li>
                                            <?php } ?>
                                            

                                        <?php } ?>
                                    <?php } ?>                                              
                                    
                                </ul>
                            </div>
                        </div>
                        <div class="services_list row">
                            <div class="col-12 col-lg-12 col-xl-12 col-md-12">
                                <h4>Additional Services</h4>
                                <ul>
                                    <?php if($row->services){ ?>
                                        <?php foreach($row->services as $row_service){ ?>
                                            <?php  if($row_service->service_amount > 0){ ?>
                                                <li class="col-12 col-lg-4 col-xl-4 col-md-12">
                                                    <div class="Room_serv">
                                                        <span><i class="fa fa-wifi"></i></span> <?php echo $row_service->service_name;?>
                                                    </div>
                                                </li>
                                            <?php } ?>
                                            

                                        <?php } ?>
                                    <?php } ?>                                              
                                    

                                    

                                </ul>
                            </div>
                        </div>
                        <div class="col-12 col-lg-12 col-xl-12 col-md-12 text-lg-right">
                        <?php if ($this->session->userdata('user_session')) { ?>
                            <a href="<?php echo base_url() . 'login'; ?>" class="Bookbtn">Book Now</a>
                        <?php }else{ ?>
                            <a href="<?php echo base_url() . 'login'; ?>" class="Bookbtn">Book Now</a>
                        <?php } ?>
            
                            
                        </div>
                    </div>


                </div>
            </div>

        <?php } ?>
    <?php } ?>

</div>
        