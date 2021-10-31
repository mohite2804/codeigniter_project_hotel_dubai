
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

<section class="about_content">
  <div class="container new-content">
    <div class="row">
      <div class="col-12 col-lg-12 col-xl-12 col-md-12">
        <h2 class="Title_text text-center"><?php echo $result->heading ?></h2>
        <?php echo $result->description ?>
       
      </div>
    </div>
  </div>
</section>

<section class="Location_content">
  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3609.087701924008!2d55.309479615010275!3d25.233970883879117!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e5f5ce81f19350d%3A0x5fedaa5b4db56a4e!2sM%C3%B6venpick%20Hotel%20%26%20Apartments%20Bur%20Dubai!5e0!3m2!1sen!2sin!4v1632218409291!5m2!1sen!2sin" width="100%" height="450px" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
  <div class="container new-content">
    <div class="row">
      <div class="col-12 col-lg-12 col-xl-12 col-md-12">
        

        <div class="location_part">
          <h3><?php echo $result2->heading ?></h3>
          <?php echo $result2->description ?>
         
        </div>
      </div>
  </div>
  </div>  
</section>


<?php $this->load->view('front/newsletter_page/index'); ?>