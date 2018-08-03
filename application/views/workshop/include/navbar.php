<header class="main-header">
    <!-- Logo -->
    <a href="<?= base_url('admin');?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>REVIVE</b> CAR</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>REVIVE</b> CAR</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
         <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?= base_url() ?>uploads/admin/<?= $this->session->userdata('m_photo'); ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?= ucwords($this->session->userdata('m_name')); ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?= base_url() ?>uploads/admin/<?= $this->session->userdata('m_photo'); ?>" class="user-image" alt="User Image">
             
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
 