<section class="fixed-top  ">
  <div class="container-fluid nopadding">
    <div class="row sidespace">
      <div class="col-6 col-lg-6  col-xl-6 col-md-12 ">
        <div id="google_translate_element" style="display: none;" ></div>


        <p class="lang_bar text-left">
          <a href="javascript:void(0);" class="eng_lang" translate="no" onclick="changeLanguageByButtonClick_en()">
            <input value="en" id="language_en" /> English</a>
          <span>|</span>
          <a href="javascript:void(0);" class="areb_lang" translate="no" onclick="changeLanguageByButtonClick()">
            <input value="ar" id="language" /> Arabic</a>
        </p>

     
       



      </div>
      <?php if (!$this->session->userdata('user_session')) { ?>
        <div class="col-6 col-lg-6  col-xl-6 col-md-12 ">
          <p class="login_bar text-right">
            <a href="<?php echo base_url() . 'login'; ?>">Login</a>
            <span>|</span>
            <a href="<?php echo base_url() . 'register'; ?>">Register</a>

          </p>
        </div>
      <?php } ?>

      <?php if ($this->session->userdata('user_session')) { ?>
      <div class="col-6 col-lg-6  col-xl-6 col-md-12 ">

        <div class="dropdown logout_drp">
          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="profile-pic"><img src="https://ccdi-unisg.ch/wp-content/uploads/2019/03/blank-profile-picture-973460_1280.png"></span>

          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <div class="Profile_content">
              <span class="profile_box float-left"><img src="https://ccdi-unisg.ch/wp-content/uploads/2019/03/blank-profile-picture-973460_1280.png"></span>
              <div class="Log_content">
                <span class="Name-item"><span style="color:#1D253E;"> <?php echo $this->session->userdata('user_session')['user_fullname']  ?></span> </span>
                <span class="mailto_txt"><a href="mailto:example@gmail.com"> <?php echo $this->session->userdata('user_session')['email']  ?></span>
              </div>

            </div>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="<?php echo base_url() . 'dashboard'; ?>"><span><i class="fa fa-bookmark" aria-hidden="true"></i></span>Dashboard</a>
            <a class="dropdown-item" href="<?php echo base_url() . 'logout'; ?>"><span><i class="fa fa-power-off" aria-hidden="true"></i></span>Logout</a>

          </div>
        </div>
      </div>

      <?php } ?>

    </div>
    <nav class="navbar Navbar_holder navbar-expand-lg navbar-light" data-toggle="sticky-onscroll">
      <a href="javascript:void(0);" class="Menu_icon" id="toggler_menu">
        <span class="menu-toggle">
          <span class="icon-box-toggle">
            <span class="rotate">
              <i class="icon-line-top"></i>
              <i class="icon-line-center"></i>
              <i class="icon-line-bottom"></i>
            </span>
          </span>
        </span>
        &nbsp; MENU</a>
      <a class="navbar-brand" href="<?php echo base_url(); ?>">
        <img src="<?php echo base_url() . FRONT_CSS_JS; ?>images/logo.svg" style="width:140px" class="img-fluid d-block mx-auto">
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <div class="mr-auto"> </div>
        <ul class="navbar-nav">

          <li class="nav-item">
            <a href="javascript:void(0)" class="nav-link"> &nbsp;Sitara Hotel Apartment</a>
          </li>
          <!-- <li class="nav-item">
            <a href="" class="nav-link"><i class="icofont-ui-call"></i> &nbsp;+91 8989876789</a>
          </li>
          <li class="nav-item">
            <a href="" class="nav-link last-nav-link"><i class="icofont-ui-cell-phone"></i> &nbsp;+91 78767878987</a>
          </li> -->


        </ul>
      </div>
    </nav>
  </div>
</section>