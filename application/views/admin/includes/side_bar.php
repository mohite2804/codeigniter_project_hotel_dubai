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

            <li class="<?php echo ($this->uri->segment(2) == 'gallery') ? 'active' : '' ?>">
              <a href="<?php echo base_url() . 'Admin/gallery'; ?>">
                <i class="fa fa-dashboard"></i> <span>Gallery</span> </i>
              </a>
            </li>


            <li class="treeview">
              <a href="#">
                <i class="fa fa-dashboard"></i> <span>Reports</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu" style="display: none;">
                <li class="active">
                    <a href="<?php echo base_url() . 'Admin/getOrders'; ?>"><i class="fa fa-circle-o"></i>Orders</a></li>
                
              </ul>
            </li>

          
            <!-- <li class="active treeview">
              <a href="<?php echo base_url() . 'Admin/dashboard'; ?>">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
            </li>

            <li class="treeview">
              <a href="<?php echo base_url() . 'Admin/usersManagement'; ?>">
                <i class="fa fa-dashboard"></i> <span>Users</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
            </li>



            <li class="treeview">
              <a href="<?php echo base_url() . 'Admin/messageManagement'; ?>">
                <i class="fa fa-dashboard"></i> <span>Message Management</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
            </li> -->





            <!-- <li class="treeview">
              <a href="<?php echo base_url() . 'Admin/adminAlbumManagement'; ?>">
                <i class="fa fa-dashboard"></i> <span>Admin Album</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
            </li>
			
			 -->
            <!-- <li class="treeview">
              <a href="<?php echo base_url() . 'Admin/videoManagement'; ?>">
                <i class="fa fa-dashboard"></i> <span>Video Management</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
            </li> -->


            <!-- <li class="treeview">
              <a href="<?php echo base_url() . 'Admin/siteManagement'; ?>">
                <i class="fa fa-dashboard"></i> <span>Site Setting</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
            </li> -->

          </ul>
        </section>
      </aside>