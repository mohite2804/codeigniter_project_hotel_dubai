      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="<?php echo base_url(); ?>uploads/users/<?php echo $this->session->userdata('admin_session')['user_image']; ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p><?php echo $this->session->userdata('admin_session')['user_fullname']; ?></p>

            </div>
          </div>
          <!-- sidebar menu: : style can be found in sidebar.less -->





          <ul class="sidebar-menu">

            <li class="<?php echo ($this->uri->segment(2) == 'roomTypes') ? 'active' : '' ?>">
              <a href="<?php echo base_url() . 'Admin/roomTypes'; ?>">
                <i class="fa fa-dashboard"></i> <span>Room Type</span> </i>
              </a>
            </li>


            <li class="<?php echo ($this->uri->segment(3) == 'highlights') ? 'active' : '' ?>">
              <a href="<?php echo base_url() . 'Admin/services/highlights'; ?>">
                <i class="fa fa-dashboard"></i> <span>Room Highlights</span> </i>
              </a>
            </li>

            <li class="<?php echo ($this->uri->segment(3) == 'amenities') ? 'active' : '' ?>">
              <a href="<?php echo base_url() . 'Admin/services/amenities'; ?>">
                <i class="fa fa-dashboard"></i> <span>Room Amenities</span> </i>
              </a>
            </li>

            <li class="<?php echo ($this->uri->segment(2) == 'rooms') ? 'active' : '' ?>">
              <a href="<?php echo base_url() . 'Admin/rooms'; ?>">
                <i class="fa fa-dashboard"></i> <span>Rooms</span> </i>
              </a>
            </li>

            

            <li class="<?php echo ($this->uri->segment(2) == 'gallery') ? 'active' : '' ?>">
              <a href="<?php echo base_url() . 'Admin/gallery'; ?>">
                <i class="fa fa-dashboard"></i> <span>Gallery</span> </i>
              </a>
            </li>


            <li class="<?php echo ($this->uri->segment(2) == 'getOrders') ? 'active' : '' ?>">
              <a href="<?php echo base_url() . 'Admin/getOrders'; ?>">
                <i class="fa fa-dashboard"></i> <span>Orders</span> </i>
              </a>
            </li>


            <!-- <li class="treeview">
              <a href="#">
                <i class="fa fa-dashboard"></i> <span>Reports</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu" style="display: none;">
                <li class="active">
                    <a href="<?php echo base_url() . 'Admin/getOrders'; ?>"><i class="fa fa-circle-o"></i>Orders</a></li>
                
              </ul>
            </li> -->

          
            
          
          </ul>
        </section>
      </aside>