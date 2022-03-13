<section class="pro_content">
    <div class="container new-content">
        <div class="row">

        <?php if ($this->session->flashdata('suc_msg')) { ?>
        <div class="room_content suc_msg_hide">
            <div class="row">
                <h3 class="Sign_text box-title suc_msg_hide"><?php echo $this->session->flashdata('suc_msg'); ?></h3>
            </div>
        </div>
    <?php } ?>

    <?php if ($this->session->flashdata('err_msg')) { ?>
        <div class="room_content suc_msg_hide" style="background-color:red">
            <div class="row">
                <h3 class="Sign_text box-title suc_msg_hide"><?php echo $this->session->flashdata('err_msg'); ?></h3>
            </div>
        </div>
    <?php } ?>


            <?php //$this->load->view('front/products_midddel_page/index'); ?>     
            
        </div>
    </div>
</section>