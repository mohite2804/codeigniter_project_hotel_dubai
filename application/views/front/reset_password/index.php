<section class="Login_content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 col-lg-6 col-xl-6 col-md-12 nopadding">
        <div class="bg_cls">
          <div class="login_header">
            <p><img src="<?php echo base_url() . FRONT_CSS_JS; ?>images/footer_logo.svg" class="img-fluid d-block mx-auto" style="width:200px"></p>
            <h2>Welcome to Sitara</h2>
            <!-- <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p> -->
          </div>
        </div>
      </div>


      <div class="col-12 col-lg-6 col-xl-6 col-md-12 d_flex">
        <div class="loginBox">
          <h4>Reset Password</h4>
          <h3 class="box-title suc_msg_hide"><?php echo $this->session->flashdata('suc_msg_register');?></h3>
        
       
          <?php echo form_open(base_url( 'resetPasswordSubmit' ), array( 'id' => 'reset_password' ));?>
           

         

            <div class="form-group">
              <p class="Login_label">Password</p>
              <input autocomplete="off" id="user_password" name="user_password" value="<?php echo set_value('user_password') ?>" type="password" class="form-control login_input" placeholder="Enter Password">
              <div class="error"><?php echo form_error('user_password'); ?></div>  
            </div>
            <div class="form-group">
              <p class="Login_label">Confirm Password</p>
              <input autocomplete="off" id="user_confirm_password" name="user_confirm_password" value=<?php echo set_value('user_confirm_password') ?>"" type="password" class="form-control login_input" placeholder="Enter Confirm  Password">
              <div class="error"><?php echo form_error('user_confirm_password'); ?></div>  
            </div>
            

           

            <input  type="hidden" name="forgot_password_link" value="<?php echo $forgot_password_link?>">

            <input type="submit" name="submit" value="Set Password" class="loginbtn"   \>
            

            <?php echo form_close();?>
        </div>
      </div>



    </div>
  </div>
</section>

<!-- <script>
  var base_url = "<?php echo base_url(); ?>";

function sendOTP() {
  var csrfName = $('.csrf_update_register').attr('name'); // Value specified in $config['csrf_token_name']
  var csrfHash = $('.csrf_update_register').val(); // CSRF hash


    var email = $('#user_email').val();
    if (!email) {
        alert('Please Enter Valid Email Address');
    } else {
        var dataJson = {
            [csrfName]: csrfHash,
            email: email
        };
        $.ajax({
            url: base_url + 'sendOTP',
            type: 'POST',
            dataType: 'html',
            data: dataJson,
            success: function(data) {               
              if(data){
                  alert('Email Send to your Email Address');
              }else{
                alert('Please try again');
              }
                
            }

        });
    }

}

function varifyEmail() {
  var csrfName = $('.csrf_update_register').attr('name'); // Value specified in $config['csrf_token_name']
  var csrfHash = $('.csrf_update_register').val(); // CSRF hash


    var user_email = $('#user_email').val();
    var user_email_otp = $('#user_email_otp').val();

    if (!user_email_otp) {
        alert('Please Enter OTP');
    } else {
        var dataJson = {
            [csrfName]: csrfHash,
            user_email: user_email,
            user_email_otp: user_email_otp,
        };
        $.ajax({
            url: base_url + 'varifyEmail',
            type: 'POST',
            dataType: 'json',
            data: dataJson,
            success: function(data) {               
             alert(data.message);
                
            }

        });
    }

}
</script> -->

<?php //$this->load->view('front/newsletter_page/index'); ?>