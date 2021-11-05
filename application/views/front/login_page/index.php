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
          <h4>Login</h4>
          <h3 class="box-title suc_msg_hide"><?php echo $this->session->flashdata('suc_msg'); ?></h3>
          <h3 class="box-title suc_msg_hide"><?php echo $this->session->flashdata('suc_msg_register');?></h3>
          <p class="Sign_text">Doesn't have an account? <a href="<?php echo base_url() . 'register'; ?>">Sign up</a></p>

          <?php echo form_open(base_url('Home/login'), array('id' => 'front_login')); ?>
          <div class="form-group">
            <p class="Login_label">Email Address</p>
            <input name="user_email" value="<?php echo set_value('user_email') ?>" type="email" class="form-control login_input" placeholder="Enter Email">
          </div>
          <div class="form-group">
            <p class="Login_label">Password</p>
            <input name="user_password" value="<?php echo set_value('user_password') ?>" type="password" class="form-control login_input" placeholder="Enter Password">
          </div>

          <!-- <div class="form-group">
            <p><label class="check_content"> Remember me
                <input name="user_checkbox"  type="checkbox">
                <span class="Ch_checkmark"></span>
              </label></p>
          </div> -->

          <input type="submit" name="submit" value="Login" class="loginbtn" \>
          <?php echo form_close(); ?>

          <p class="text-center Sign_text"><a href="<?php echo base_url() . 'forgot-password'; ?>">Forgot Password?</a></p>


        </div>
      </div>
    </div>
  </div>
</section>


<?php $this->load->view('front/newsletter_page/index'); ?>