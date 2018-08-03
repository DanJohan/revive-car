<?php 
$cur_tab = $this->uri->segment(2)==''?'dashboard': $this->uri->segment(2);  
?>  
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
        <li id="dashboard" class="treeview">
          <a href="<?= base_url('workshop/dashboard'); ?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
           </a>
        </li>
      </ul>

    <ul class="sidebar-menu">
        <li id="users" class="treeview">
            <a href="#">
              <i class="fa fa-dashboard"></i> <span>Users</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li id="view_users" class=""><a href="<?= base_url('workshop/users'); ?>"><i class="fa fa-circle-o"></i> View User Details</a></li>
            </ul>
          </li>
          </ul>
      <ul class="sidebar-menu">
        <li id="users" class="treeview">
            <a href="#">
              <i class="fa fa-dashboard"></i> <span>Driver Management</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
           <!--<li id="add_driver"><a href="<?= base_url('workshop/driver/add_driver'); ?>"><i class="fa fa-circle-o"></i> Add Driver</a></li>-->
              <li id="view_driver" class=""><a href="<?= base_url('workshop/driver/view_driver'); ?>"><i class="fa fa-circle-o"></i> View Driver Details</a></li>
            </ul>
        </li>
      </ul>
       
      <!--<ul class="sidebar-menu">
        <li id="manager" class="treeview">
            <a href="#">
              <i class="fa fa-dashboard"></i> <span>Workshop Management</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li id="add_manager"><a href="<?= base_url('admin/workshop/add_manager'); ?>"><i class="fa fa-circle-o"></i> Add Manager</a></li>
              <li id="view_manager" class=""><a href="<?= base_url('admin/workshop/view_manager'); ?>"><i class="fa fa-circle-o"></i> View Manager</a></li>
            </ul>-->
        </li>
      </ul>   
       
    </section>
    <!-- /.sidebar -->
  </aside>

  
<script>
  $("#<?= $cur_tab; ?>").addClass('active');
</script>
