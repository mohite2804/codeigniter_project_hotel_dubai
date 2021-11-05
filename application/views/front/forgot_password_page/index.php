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
       <?php echo form_open(base_url('Home/forgotPassword'), array('id' => 'front_forgotPassword')); ?>

        <div class="loginBox">
          <h4>Reset Password</h4>
          <p class="Sign_text">Enter your email address and we will email you instruction on how to reset password</p>
          <div class="form-group">
            <p class="Login_label">Email Address</p>
            <input name="user_email" type="email" class="form-control login_input" placeholder="Enter Email">
          </div>
         
         
          <input type="submit" name="submit" value="Send me instruction" class="loginbtn" \>
          
         

        </div>
        <?php echo form_close(); ?>
       </div>
    </div>
  </div>
</section>