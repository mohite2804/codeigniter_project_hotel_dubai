<section class="footer_bg">
  <div class="sticky-stopper"></div>
  <div class="container new-content">
    <div class="row">


      <div class="col-12 col-lg-3 col-xl-3 col-md-12">
        <img src="<?php echo base_url() . FRONT_CSS_JS; ?>images/footer_logo.svg" class="img-fluid" style="width: 200px;">
        <p style="color: #FFF;font-size: 16px;letter-spacing: 1px;text-indent: 14px;">Sitara Hotel Apartment LLC</p>
      </div>

      <div class="col-12 col-lg-3 col-xl-3 col-md-12">
        <h3>Menu</h3>
        <ul class="footer_link">
          <li><a href="<?php echo base_url() . 'about-us'; ?>">About us</a></li>
          <li><a href="<?php echo base_url() . 'gallery'; ?>">Gallery</a></li>
          <li><a href="<?php echo base_url() . 'rooms'; ?>">Rooms</a></li>
        </ul>
      </div>

      <div class="col-12 col-lg-3 col-xl-3 col-md-12">
        <h3>Service</h3>
        <ul class="footer_link">
          <li><a href="<?php echo base_url() . 'privacy-policy'; ?>">Refund Policy</a></li>
          <li><a href="<?php echo base_url() . 'terms-and-conditions'; ?>">Terms and Conditions</a></li>
          <li><a href="<?php echo base_url() . 'contact'; ?>">Contact</a></li>

        </ul>
      </div>
      <div class="col-12 col-lg-3 col-xl-3 col-md-12">
        <h3>Follow us</h3>
        <ul class="footer_link">
          <li><a data-toggle="tooltip" data-placement="top"  title="Under Construction" href="javascript:void(0)"><i class="icofont-facebook"></i> Facebook</a></li>
          <li><a data-toggle="tooltip" data-placement="top"  title="Under Construction" href="javascript:void(0)"><i class="icofont-twitter"></i> Twitter</a></li>
          <li><a data-toggle="tooltip" data-placement="top"  title="Under Construction" href="javascript:void(0)"><i class="icofont-instagram"></i> Instagram</a></li>
          <li><a data-toggle="tooltip" data-placement="top"  title="Under Construction" href="javascript:void(0)"><i class="icofont-youtube-play"></i> Youtube</a></li>

         
        </ul>
      </div>

    </div>
  </div>
</section>


<div class="modal" id="feedback_modal" tabindex="-1" role="dialog">
<?php echo form_open(base_url( '/feedback' ), array( 'id' => 'front_feedback' ));?>
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header noborder modal_spac">
        <h5 class="modal-title"><img src="<?php echo base_url() . FRONT_CSS_JS; ?>images/DPA_LOGO_BLACK.svg" style="width:200px;"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body modal_spac">
        <p class="Rate_text">How do you rate this page?</p>
        <ul class="feedback">
          <li class="angry">
            <div>
              <svg class="eye left">
                <use xlink:href="#eye">
              </svg>
              <svg class="eye right">
                <use xlink:href="#eye">
              </svg>
              <svg class="mouth">
                <use xlink:href="#mouth">
              </svg>
            </div>
            <span class="tooltiptext">Very Dissatisfied</span>
          </li>
          <li class="sad">
            <div>
              <svg class="eye left">
                <use xlink:href="#eye">
              </svg>
              <svg class="eye right">
                <use xlink:href="#eye">
              </svg>
              <svg class="mouth">
                <use xlink:href="#mouth">
              </svg>
            </div>
            <span class="tooltiptext">Dissatisfied</span>
          </li>
          <li class="ok">
            <div></div>
            <span class="tooltiptext">Neutral</span>
          </li>
          <li class="good active">
            <div>
              <svg class="eye left">
                <use xlink:href="#eye">
              </svg>
              <svg class="eye right">
                <use xlink:href="#eye">
              </svg>
              <svg class="mouth">
                <use xlink:href="#mouth">
              </svg>
            </div>
            <span class="tooltiptext">Satisfied</span>
          </li>
          <li class="happy">
            <div>
              <svg class="eye left">
                <use xlink:href="#eye">
              </svg>
              <svg class="eye right">
                <use xlink:href="#eye">
              </svg>
            </div>
            <span class="tooltiptext">Very Satisfied</span>
          </li>
        </ul>
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
          <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 7 4" id="eye">
            <path d="M1,1 C1.83333333,2.16666667 2.66666667,2.75 3.5,2.75 C4.33333333,2.75 5.16666667,2.16666667 6,1"></path>
          </symbol>
          <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 7" id="mouth">
            <path d="M1,5.5 C3.66666667,2.5 6.33333333,1 9,1 C11.6666667,1 14.3333333,2.5 17,5.5"></path>
          </symbol>
        </svg>


        <p class="Rate_text">Please select a subject</p>
        <select name="feedback_subject" class=" form-control subject_pick">
          <option value="" >Select Subject</option>
          <option>Option 2</option>
          <option>Option 3</option>
          <option>Option 4</option>
          <option>Option 5</option>
          <option>Option 6</option>
          <option>Option 7</option>
          <option>Option 8</option>
          <option>Option 9</option>
          <option>Option 11</option>
          <option>Option 12</option>
          <option>Option 13</option>
          <option>Option 14</option>

        </select>
        <div class="error"><?php echo form_error('feedback_subject'); ?></div>  
        <p class="Rate_text">Please, share your comments :</p>
        <textarea name="feedback_comment"  rows="4" cols="4" class="textarea_comment"></textarea>
        <input name="feedback_current_url" type="hidden" value="<?php echo current_url(); ?>" >
      <div class="error"><?php echo form_error('feedback_comment'); ?></div>  
        <!-- <a href="javascript:void(0);" class="powerdby">Powered by GetFeedback</a> -->
       
        <input name="submit" type="submit" class="submit_feed" value="Submit" >
      </div>
    </div>
  </div>
  <?php echo form_close();?>
</div>