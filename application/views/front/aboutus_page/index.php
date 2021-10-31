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

       


        <h3 class="Title_text">All our rooms include:</h3>

        <ul class="Room_service">
          <li>
            <i class="fa fa-wifi"></i>
            <p> Wifi</p>
          </li>
          <li>
            <i class="fa fa-bath"></i>
            <p> Sauna</p>
          </li>
          <li>
            <i class="fa fa-coffee"></i>
            <p> Coffee Maker</p>
          </li>
          <li>
            <i class="fa fa-glass"></i>
            <p> Mini Bar</p>
          </li>
          <li>
            <i class="fa fa-snowflake-o"></i>
            <p> Air Conditioner</p>
          </li>

        </ul>

      </div>
    </div>
  </div>
</section>

<?php $this->load->view('front/newsletter_page/index'); ?>