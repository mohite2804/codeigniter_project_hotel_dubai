<script type="text/javascript" src="<?php echo base_url() . FRONT_CSS_JS; ?>js/main.js"></script>
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

<section>
  <div class="container new-content">
    <div class="row">
      <div class="col-12  col-lg-12 col-xl-12 col-md-12">
        <div class="filters">
          <ul>
            <span class="filter_label">Filter:</span>

            <?php if (count($room_types) > 0) { ?>
              <li class="active" data-filter="*">All</li>
              <?php foreach ($room_types as $key => $row) { ?>               
                <li data-filter=".filter_<?php echo $row->id; ?>"><?php echo $row->name; ?> </li>                
              <?php } ?>
            <?php } ?>

          </ul>
        </div>

        <div class="filters-content">
          <div class="row grid">

            <?php if (count($slider_images) > 0) { ?>
              <?php foreach ($slider_images as $key => $row) { ?>


                <div class="col-lg-4 col-md-12 col-12 col-xl-4 all <?php echo 'filter_'.$row->room_type_id; ?>">
                  <div class="bx_content_filter">
                    <div class="img_box">
                      <img src="<?php echo base_url() . FRONT_CSS_JS; ?><?php echo $row->image; ?>" class="img-fluid d-block mx-auto">
                    </div>
                    <div class="img_content">
                      <p><?php echo $row->room_type_name; ?></p>
                      <a href="">Book Now</a>
                    </div>
                  </div>
                </div>

              <?php } ?>
            <?php } ?>






          </div>
        </div>



      </div>
    </div>
  </div>
</section>



<?php $this->load->view('front/newsletter_page/index'); ?>