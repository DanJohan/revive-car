<header class="main-header">
    <!-- Logo -->
    <a href="<?= base_url('admin');?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>REVIVE</b> CAR</span>
      <!-- logo ofr regular state and mobile devices -->
      <span class="logo-lg"><b>REVIVE</b> AUTO CARE</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning" id="notification-count">0</span>
            </a>
            <ul class="dropdown-menu" id="notification-list">

            </ul>
          </li>
         <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <?php if($this->session->userdata('m_photo') != '') { ?>
              <img src="<?= base_url() ?>uploads/admin/<?= $this->session->userdata('m_photo'); ?>" class="user-image" alt="User Image">
            <?php }else {?>
              <img src="<?= base_url() ?>public/images/admin/no_image.jpeg" class="user-image" alt="User Image">
            <?php } ?>
              <span class="hidden-xs"><?= ucwords($this->session->userdata('m_name')); ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <?php if($this->session->userdata('m_photo') != '') { ?>
                <img src="<?= base_url() ?>uploads/admin/<?= $this->session->userdata('m_photo'); ?>" class="user-image" alt="User Image">
                <?php }else {?>
                  <img src="<?= base_url() ?>public/images/admin/no_image.jpeg" class="user-image" alt="User Image">
                <?php } ?>
             
                  <p style="text-transform:capitalize;">
                  <b style="color:#fff;font-weight:normal !important;"><?= ucwords($this->session->userdata('m_name')); ?></b>
                  <small style="color:#fff;font-weight:bold;">Manager</small> </p>

              </li>
             <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-right">
                  <a href="<?= site_url('workshop/auth/logout'); ?>" class="btn btn-danger btn-flat">Sign out</a>
                </div>
                <div class="pull-left">
                  <a href="<?= site_url('workshop/auth/change_pwd'); ?>" class="btn btn-primary btn-flat">Change Password</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
         
        </ul>
      </div>
    </nav>
  </header>
 
