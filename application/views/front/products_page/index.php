<section class="pro_content">
    <div class="container new-content">
        <?php if($result){ ?>
        <div class="row">

            <div class="col-12 col-lg-4 col-xl-4 col-md-12" id="left">
                <div class="custom_search sticky_search myGroup" id="sidewbar">
                    <h4>Your Search</h4>
                    <?php echo form_open(base_url('products'), array('id' => 'front_login')); ?>
                    <div class="row">

                        <div class="col-12 col-lg-12 col-xl-12 col-md-12">
                            <div>
                                <p class="book_label_new">Room Type <?php echo $selected_data['room_type'];?></p>
                                <select name="room_type" class="js-example-basic-single_2 " style="width: 100%">
                                    <option value="">Select</option>
                                    <?php if ($room_types) { ?>
                                        <?php foreach ($room_types as $row) { ?>
                                            <option value="<?php echo $row->id; ?>" <?php echo (!empty($selected_data['room_type']) && $row->id == $selected_data['room_type']) ? 'selected' : ''  ?> > 
                                                <?php echo $row->name; ?>
                                            </option>
                                        <?php } ?>
                                    <?php } ?>

                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6 col-xl-6 col-md-6">
                            <div class=" checKDate">
                                <p class="book_label_new">Check In  <?php echo $selected_data['room_start_date']; ?></p>
                                <input value="<?php if(!empty($selected_data['room_start_date'])) echo $selected_data['room_start_date']; else echo set_value('room_start_date');?>"  name="room_start_date" id="startDate" class="form-control" placeholder="Select Date" />
                            </div>
                        </div>

                        <div class="col-12 col-lg-6 col-xl-6 col-md-6">
                            <div class="checKDate">
                                <p class="book_label_new">Check Out  <?php echo $selected_data['room_end_date']; ?></p>
                                <input value="<?php if(!empty($selected_data['room_end_date'])) echo $selected_data['room_end_date']; else echo set_value('room_end_date');?>" name="room_end_date" id="endDate" class="form-control" placeholder="Select Date" />
                            </div>
                        </div>

                        <div class="col-12 col-lg-6 col-xl-6 col-md-6">
                            <div class="relativepos pro_ad">
                                <p class="book_label_new">Adult <?php echo $selected_data['room_no_of_adult']; ?> </p>
                                <button type="button" id="ad_tab" class="childrentab" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="adultnumber" href="#adultnumber">
                                    <span id="adlt_count_2"><?php if(!empty($selected_data['room_no_of_adult'])) echo $selected_data['room_no_of_adult']; else echo '1';?></span>Adult(s)</button>
                                <div class="childrenCount row collapse " id="adultnumber">
                                    <div class="children_box">
                                        <button type="button" class="minusCount" id="ad_minus_2"><i class="icofont-minus"></i></button>
                                        <input value="<?php if(!empty($selected_data['room_no_of_adult'])) echo $selected_data['room_no_of_adult']; else echo '1';?>" name="room_no_of_adult" type="text" class="adultInput" >
                                        <button type="button" class="addcount active" id="ad_plus_2"><i class="icofont-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6 col-xl-6 col-md-6">
                            <div class="relativepos pro_ad">
                                <p class="book_label_new">Children <?php echo $selected_data['room_no_of_children']; ?></p>
                                <button type="button" id="ch_tab" class="childrentab" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="childrennumber" href="#childrennumber">
                                    <span id="chld_count_2"><?php if(!empty($selected_data['room_no_of_children'])) echo $selected_data['room_no_of_children']; else echo '1';?></span>Children(s)</button>
                                <div class="childrenCount row collapse " id="childrennumber">
                                    <div class="children_box">
                                        <button type="button" class="minusCount" id="ch_minus_2"><i class="icofont-minus"></i></button>
                                        <input value="<?php if(!empty($selected_data['room_no_of_children'])) echo $selected_data['room_no_of_children']; else echo '1';?>" name="room_no_of_children" type="text" class="adultInput" >
                                        <button type="button" class="addcount active" id="ch_plus_2"><i class="icofont-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-12 col-lg-4 col-xl-4 col-md-12">
                            <input type="submit" name="submit" value="Search" class="book_hotel" \>
                        </div>


                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>




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
                                    <p>Check In: <span>&nbsp;<?php echo $selected_data['room_start_date'] ; ?></span>&nbsp;&nbsp; Check Out: <span><?php echo $selected_data['room_end_date'] ; ?></span></p>

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
        </div>
        <?php }else{ ?>
            <div class="row">
                <h1>Room Not Available </h1>
            </div>
        <?php } ?>
    </div>
</section>