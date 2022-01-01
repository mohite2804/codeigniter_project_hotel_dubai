<section class="Banner_content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 col-lg-12  col-xl-12 col-md-12 nopadding">
        <div id="bannercarousel" class="carousel slide carousel-fade" data-ride="carousel">
          <div class="carousel-inner img_inner">

            <?php if (count($slider_images) > 0) { ?>
              <?php foreach ($slider_images as $key => $row) { ?>
                <div class="carousel-item <?php echo ($key === 0) ? 'active' : '' ?>">
                  <img class="d-block img-fluid w-100" src="<?php echo base_url() . FRONT_CSS_JS; ?><?php echo $row->image; ?>" alt="<?php echo $key . ' ' . $row->image; ?>">
                </div>
              <?php } ?>
            <?php } ?>

          </div>
          <a class="carousel-control-prev cust_prev" href="#bannercarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next cust_prev" href="#bannercarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- <section class="about_content">
  <div class="container new-content">
    <div class="row">
      <div class="col-12 col-lg-12 col-xl-12 col-md-12">
        <h2 class="Title_text text-center"><?php echo $result->heading ?></h2>
        <?php //echo $result->description 
        ?>

      </div>
    </div>
  </div>
</section> -->



<!-- <section class="Location_content">
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d506.3767207248028!2d55.30811006742938!3d25.235476767649246!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e5f433988e205c3%3A0x5c1cc4e15b9ddfd3!2sSITARA%20HOTEL%20APARTMENT!5e0!3m2!1sen!2sus!4v1639052045755!5m2!1sen!2sus" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
  <div class="container new-content">
    <div class="row">
      <div class="col-12 col-lg-12 col-xl-12 col-md-12">
        

        <div class="location_part">
          <h3><?php //echo//$result2->heading ?></h3>
          <?php// echo //$result2->description ?>
         
        </div>
      </div>
  </div>
  </div>  
</section> -->

<section class="about_content">
  <div class="container new-content">
    <div class="row">
      <div class="col-12 col-lg-12 col-xl-12 col-md-12">
        <h2 class="Title_text text-center">Contact Us</h2>
      </div>
    </div>
  </div>
</section>

<section class="Location_content">
  <div class="container new-content">
    <div class="row">
      <div class="col-12 col-lg-4 col-xl-4 col-md-12">
        <div class="location_part">
          <h3>Get In Touch</h3>
          <address><strong>Sitara Hotel Apartment LLC</strong><br>
            P.O. Box 62850,
            “Oud Metha”<br>
            Dubai, UAE<br>

          </address>
          <p><span><i class="icofont-ui-call"></i></span>+971 4 232 3636‬</p>
          <p><span><i class="icofont-brand-whatsapp"></i></span>+971 54 252 3690</p>
          <p><span><i class="icofont-location-pin"></i></span><a href="https://goo.gl/maps/wBX4ppb55EcgiyS88" style="color: #ffffff;text-decoration: none;" target="_blank">Sitara Hotel Apartment LLC Location</a></p>
          <p><span><i class="icofont-email"></i></span><a href="mailto:fo@sitarahotelapartment.com" style="color: #ffffff;text-decoration: none;">fo@sitarahotelapartment.com</a></p>
        </div>
      </div>

      <div class="col-12 col-lg-8 col-xl-8 col-md-12">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d506.3767207248028!2d55.30811006742938!3d25.235476767649246!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e5f433988e205c3%3A0x5c1cc4e15b9ddfd3!2sSITARA%20HOTEL%20APARTMENT!5e0!3m2!1sen!2sus!4v1639052045755!5m2!1sen!2sus" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
      </div>
    </div>
  </div>
</section>


<?php //$this->load->view('front/newsletter_page/index'); 
?>