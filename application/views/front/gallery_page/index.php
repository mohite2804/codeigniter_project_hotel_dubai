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


<section class="slider_content">
  <div class="container new-content nopadding">
    <div class="row">
      <div class="col-12 col-lg-12 col-xl-12 col-md-12">
        <h2 class="Title_text text-center">Gallery</h2>
      </div>
    </div>
    <div class="row">

      <?php if (count($result) > 0) { ?>
        <?php foreach ($result as $key => $row) { ?>

          <div class="col-12 col-lg-4 col-xl-4 col-md-12 gal_slide " dir="ltr" style="direction: ltr;">
            <div class="Gal_box">
              <img src="<?php echo base_url() . FRONT_CSS_JS; ?><?php echo $row->image; ?>" class="img-fluid d-block mx-auto img-thumbnail">
            </div>
          </div>
        <?php } ?>
      <?php } ?>
  



    </div>
  </div>
</section>



<div class="modal" id="ImageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog imageDialog" role="document">
        <div class="modal-content imgmodal-content">
            <div class="modal-header modal-head">
                
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body zoom_body">
                <div id="carouselExampleControls" class="carousel slide carousel-fade zoom_control" data-ride="carousel">
                    <div class="carousel-inner">
                        <?php if (count($result) > 0) { ?>
                            <?php foreach ($result as $key => $row) { ?>
                                <div class="carousel-item">
                                    <img class="d-block img-fluid mx-auto" src="<?php echo base_url() . FRONT_CSS_JS; ?><?php echo $row->image; ?>" alt="<?php echo base_url() . FRONT_CSS_JS; ?><?php echo $row->image; ?>">
                                </div>

                            <?php } ?>
                        <?php } ?>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>