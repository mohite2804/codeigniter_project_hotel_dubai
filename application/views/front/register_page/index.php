<section class="Login_content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 col-lg-6 col-xl-6 col-md-12 nopadding">
        <div class="bg_cls">
          <div class="login_header">
            <p><img src="<?php echo base_url() . FRONT_CSS_JS; ?>images/footer_logo.svg" class="img-fluid d-block mx-auto" style="width:200px"></p>
            <h2>Welcome to Mövenpick Hotels & Resorts</h2>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
          </div>
        </div>
      </div>


      <div class="col-12 col-lg-6 col-xl-6 col-md-12 d_flex">
        <div class="loginBox">
          <h4>Sign up</h4>
          <h3 class="box-title suc_msg_hide"><?php echo $this->session->flashdata('suc_msg');?></h3>
          <p class="Sign_text">Already have an account? <a href="<?php echo base_url() . 'login'; ?>">Login</a></p>
       
          <?php echo form_open(base_url( 'Home/register' ), array( 'id' => 'front_login' ));?>
            <div class="form-group">
              <p class="Login_label">Full Name</p>
              <input name="user_fullname" value="<?php echo set_value('user_fullname') ?>" type="text" class="form-control login_input" placeholder="Enter Name">
              <div class="error"><?php echo form_error('user_fullname'); ?></div>  
            </div>
            <div class="form-group">
              <p class="Login_label">Email Address</p>
              <div class="error"><input name="user_email" value="<?php echo set_value('user_email') ?>" type="email" class="form-control login_input" placeholder="Enter Email">
              <?php echo form_error('user_email'); ?></div>  
            </div>
            <div class="form-group">
              <p class="Login_label">Password</p>
              <input name="user_password" value="<?php echo set_value('user_password') ?>" type="password" class="form-control login_input" placeholder="Enter Password">
              <div class="error"><?php echo form_error('user_password'); ?></div>  
            </div>
            <div class="form-group">
              <p class="Login_label">Confirm Password</p>
              <input name="user_confirm_password" value=<?php echo set_value('user_confirm_password') ?>"" type="password" class="form-control login_input" placeholder="Enter Confirm  Password">
              <div class="error"><?php echo form_error('user_confirm_password'); ?></div>  
            </div>
            <div class="form-group">
              <p><label class="check_content"> A agree the <a href="<?php echo base_url() . 'privacy-policy'; ?>">privacy policy</a> & <a href="<?php echo base_url() . 'terms-and-conditions'; ?>">booking terms and condition</a>.
                  <input name="user_checkbox" type="checkbox" >
                  <span class="Ch_checkmark"></span>
                </label></p>
              <div class="error"><?php echo form_error('user_checkbox'); ?></div>  
            </div>

            <input type="submit" name="submit" value="Register" class="loginbtn" \>
            

            <?php echo form_close();?>
        </div>
      </div>



    </div>
  </div>
</section>


<?php $this->load->view('front/newsletter_page/index'); ?>