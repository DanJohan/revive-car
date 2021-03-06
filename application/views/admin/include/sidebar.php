
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <!-- <img src="<?= base_url() ?>public/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image"> -->
        </div>
        <div class="pull-left info">
         <!--  <p><?= ucwords($this->session->userdata('name')); ?></p> -->
         <!--  <a href="#"><i class="fa fa-circle text-success"></i> Online</a> -->
        </div>
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
      <ul class="sidebar-menu" >
        <li id="" class="treeview active">
          <a href="javascript:void(0)">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
           </a>
           <ul class="treeview-menu">
               <li id="index" class=""><a href="<?= base_url('admin/dashboard'); ?>"><i class="fa fa-arrow-circle-right text-aqua"></i>Dashboard</a></li>
            </ul>
        </li>
        <li id="" class="treeview active" >
            <a href="#" class="sidebar-toggle">
              <i class="fa fa-users"></i> <span>Customers</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
               <li id="index" class=""><a href="<?= base_url('admin/users'); ?>"><i class="fa fa-arrow-circle-right text-aqua"></i> Customers Detail</a></li>
            <li id="list"><a href="<?= base_url('admin/jobCard/list'); ?>"><i class="fa fa-arrow-circle-right text-aqua"></i>Customers job cards</a></li>
            <li id="list"><a href="<?= base_url('admin/invoice/list'); ?>"><i class="fa fa-arrow-circle-right text-aqua"></i>Customers invoices</a></li> 
            </ul>
          </li>
        <li id="" class="treeview active">
            <a href="#" class="sidebar-toggle">
              <i class="fa fa-car"></i> <span>Car Management</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li id="add_carbrand"><a href="<?= base_url('admin/car/add_carbrand'); ?>"><i class="fa fa-arrow-circle-right text-aqua"></i> Add Car Brand</a></li>
              <li id="add_carmodel"><a href="<?= base_url('admin/car/add_carmodel'); ?>"><i class="fa fa-arrow-circle-right text-aqua"></i> Add Car Model</a></li>
           </ul>
        </li>
        <li id="" class="treeview active">
            <a href="#" class="sidebar-toggle">
              <i class="fa fa-car"></i> <span>Services Management</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li id="add_carbrand"><a href="<?= base_url('admin/service/add_carservice'); ?>"><i class="fa fa-arrow-circle-right text-aqua"></i>Add cars to services</a></li>
              <li id="add_carbrand"><a href="<?= base_url('admin/service/car_services_list'); ?>"><i class="fa fa-arrow-circle-right text-aqua"></i>View Car Services</a></li>
              <li id="add_carbrand"><a href="<?= base_url('admin/service/change_service_price'); ?>"><i class="fa fa-arrow-circle-right text-aqua"></i>Change services price</a></li>
           </ul>
        </li>

	<li id="" class="treeview active">
            <a href="#" class="sidebar-toggle">
              <i class="fa fa-car"></i> <span>Order Management</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li id="add_carbrand"><a href="<?= base_url('admin/order/list'); ?>"><i class="fa fa-arrow-circle-right text-aqua"></i>View orders</a></li>
           </ul>
     </li>

        <li id="" class="treeview active">
            <a href="#" class="sidebar-toggle">
              <img src="<?php echo base_url()?>public/images/admin/driver.png" style="height: 20px;width: 20px;"><span>Driver Management</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li id="add_driver"><a href="<?= base_url('admin/driver/add_driver'); ?>"><i class="fa fa-arrow-circle-right text-aqua"></i> Add Driver</a></li>
              <li id="view_driver" class=""><a href="<?= base_url('admin/driver/view_driver'); ?>"><i class="fa fa-arrow-circle-right text-aqua"></i> View Driver Details</a></li>
            </ul>
        </li>
        <li id="" class="treeview active">
            <a href="#" class="sidebar-toggle">
              <img src="<?php echo base_url()?>public/images/admin/workshop.png"><span>Workshop Management</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li id="add_manager"><a href="<?= base_url('admin/workshop/add_manager'); ?>"><i class="fa fa-arrow-circle-right text-aqua"></i> Add Manager</a></li>
              <li id="view_manager" class=""><a href="<?= base_url('admin/workshop/view_manager'); ?>"><i class="fa fa-arrow-circle-right text-aqua"></i> View Manager</a></li>
            </ul>
        </li>
        <li id="" class="treeview active" >
            <a href="#" class="sidebar-toggle">
              <i class="fa fa-cog"></i> <span>Site Management</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
               <li id="index" class=""><a href="<?= base_url('admin/blog/list'); ?>"><i class="fa fa-arrow-circle-right text-aqua"></i> Blogs</a></li>
            	<li id="e_index"><a href="<?= base_url('admin/gallery/list'); ?>"><i class="fa fa-arrow-circle-right text-aqua"></i>Gallery images</a></li>
            	<li id="list"><a href="<?= base_url('admin/testimonial/list'); ?>"><i class="fa fa-arrow-circle-right text-aqua"></i>Testimonials</a></li>
            </ul>
          </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

