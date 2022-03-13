<div class="col-12 col-lg-4 col-xl-4 col-md-12" id="left">
  <div class="custom_search sticky_search myGroup" id="sidewbar">
    <h4>Your Search</h4>
   
    <div class="row">


      <div class="col-12 col-lg-6 col-xl-6 col-md-6">
        <div>
          <p class="book_label_new">Room Type</p>

          <select name="room_type" class="js-example-basic-single_2 " style="width: 100%">
            <!-- <option value="">Select</option> -->
            <?php if ($room_types) { ?>
              <?php foreach ($room_types as $row) { ?>
                <option value="<?php echo $row->id; ?>" <?php echo (!empty($selected_data['room_type']) && $row->id == $selected_data['room_type']) ? 'selected' : ''  ?>>
                  <?php echo $row->name; ?>
                </option>
              <?php } ?>
            <?php } ?>

          </select>

        </div>
      </div>

      <div class="col-12 col-lg-6 col-xl-6 col-md-6">
        <div class="relativepos pro_ad">
          <p class="book_label_new">Rooms </p>

          <div class="childrenCount row  " id="Roomnumber">
            <div class="children_box">
              <button type="button" class="minusCount" id="Rm_minus"><i class="icofont-minus"></i></button>
              <input name="no_of_room" value="<?php if (!empty($selected_data['no_of_room'])) echo $selected_data['no_of_room'];
                                              else echo '1'; ?>" type="text" class="adultInput">
              <button type="button" class="addcount active" id="Rm_plus"><i class="icofont-plus"></i></button>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-lg-6 col-xl-6 col-md-6">
        <div class=" checKDate">
          <p class="book_label_new">Check In</p>
          <input name="room_start_date" autocomplete="off" id="startDate" value="<?php if (!empty($selected_data['room_start_date'])) echo $selected_data['room_start_date'];
                                                                                  else echo set_value('room_start_date'); ?>" class="form-control" placeholder="Check In" />
        </div>
      </div>

      <div class="col-12 col-lg-6 col-xl-6 col-md-6">
        <div class="checKDate">
          <p class="book_label_new">Check Out</p>
          <input name="room_end_date" value="<?php if (!empty($selected_data['room_end_date'])) echo $selected_data['room_end_date'];
                                              else echo set_value('room_end_date'); ?>" autocomplete="off" id="endDate" class="form-control" placeholder="Check Out" />
        </div>
      </div>

      <div class="col-12 col-lg-6 col-xl-6 col-md-6">
        <div class="relativepos pro_ad">
          <p class="book_label_new">Adult</p>

          <div class="childrenCount row  " id="adultnumber">
            <div class="children_box">
              <button type="button" class="minusCount" id="ad_minus"><i class="icofont-minus"></i></button>
              <input type="text" name="room_no_of_adult" class="adultInput" value="<?php if (!empty($selected_data['room_no_of_adult'])) echo $selected_data['room_no_of_adult'];
                                                                                    else echo '1'; ?>">
              <button type="button" class="addcount active" id="ad_plus"><i class="icofont-plus"></i></button>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-lg-6 col-xl-6 col-md-6">
        <div class="relativepos pro_ad">
          <p class="book_label_new">Children</p>

          <div class="childrenCount row  " id="childrennumber">
            <div class="children_box">
              <button type="button" class="minusCount" id="ch_minus"><i class="icofont-minus"></i></button>
              <input name="room_no_of_children" type="text" class="adultInput" value="<?php if (!empty($selected_data['room_no_of_children'])) echo $selected_data['room_no_of_children'];
                                                                                      else echo '0'; ?>">
              <button type="button" class="addcount active" id="ch_plus"><i class="icofont-plus"></i></button>
            </div>
          </div>

        </div>
      </div>


      <div class="col-12 col-lg-12 col-xl-12 col-md-12">
        <div class="relativepos pro_ad">
          <br>
          <input type="submit" name="update_submit" value="Update" class="book_hotel" \>

        </div>
      </div>

    </div>
   
  </div>
</div>