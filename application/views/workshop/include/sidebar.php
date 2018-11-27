
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <!-- <img src="<?= base_url() ?>public/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image"> -->
        </div>
       <!--  <div class="pull-left info">
          <p><?= ucwords($this->session->userdata('m_name')); ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div> -->
      </div>
      <!-- search form -->
      <!-- <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form> -->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li id="" class="treeview dashboard active">
          <a href="javascript:void(0)">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
           </a>
            <ul class="treeview-menu">
              <li id="u_index" class=""><a href="<?= base_url('workshop/dashboard'); ?>"><i class="fa fa-arrow-circle-right text-green"></i>Dashboard</a></li>
            </ul>
        </li>
      </ul>

    <ul class="sidebar-menu">
        <li id="" class="treeview users enquiry jobCard active">
            <a href="#">
              <i class="fa fa-users"></i> <span>Customers</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li id="u_index" class=""><a href="<?= base_url('workshop/users'); ?>"><i class="fa fa-arrow-circle-right text-green"></i>Customers Detail</a></li>
        <!--      <li id="e_index"><a href="<?= base_url('workshop/enquiry/index'); ?>"><i class="fa fa-arrow-circle-right text-green"></i>Customers enquiry</a></li> -->
           <li id="list"><a href="<?= base_url('workshop/jobCard/list'); ?>"><i class="fa fa-arrow-circle-right text-green"></i>Customers job cards</a></li>
            </ul>
          </li>

        <li id="" class="treeview driver active">
            <a href="#">
              <img src="<?php echo base_url()?>public/images/admin/driver.png" style="height: 20px;width: 20px;"><span>Driver Management</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li id="view_driver" class=""><a href="<?= base_url('workshop/driver/view_driver'); ?>"><i class="fa fa-arrow-circle-right text-green"></i> View Driver Details</a></li>
            </ul>
        </li>

        <li id="" class="treeview car active">
            <a href="#" class="sidebar-toggle">
              <i class="fa fa-car"></i> <span>Order Management</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li id="add_carbrand"><a href="<?= base_url('workshop/order/list'); ?>"><i class="fa fa-arrow-circle-right text-green"></i>View orders</a></li>
           </ul>
     </li>
      </ul> 
       
    </section>
    <!-- /.sidebar -->
  </aside>

