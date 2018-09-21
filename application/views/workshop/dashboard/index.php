 <!-- Datatable style -->
<link rel="stylesheet" href="<?= base_url() ?>public/plugins/datatables/dataTables.bootstrap.css">  

 <section class="content">
   <div class="box">
    <div class="box-header text-center  bg-green">
     <h1 class="box-title" style="text-transform:uppercase;font-weight:bold;">Revive Car Workshop Management Dashboard</h1>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
        <div class="row">
        <div class="col-lg-6 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php echo $userCount; ?></h3>

              <p>Customers</p>
            </div>
            <div class="icon">
             <img height="80" width="80" src="<?= base_url() ?>public/dist/img/customer.png">
            </div>
            <a href="<?= base_url('workshop/users'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
       <!-- ./col -->

        <div class="col-lg-6 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $driverCount; ?></h3>

              <p>Drivers</p>
            </div>
            <div class="icon">
              <img height="80" width="80" src="<?= base_url() ?>public/dist/img/driver.png">
            </div>
            <a href="<?= base_url('workshop/driver/view_driver'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-6 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo $enquiryCount; ?></h3>

              <p>Enquiry</p>
            </div>
            <div class="icon">
              <img height="80" width="80" src="<?= base_url() ?>public/dist/img/enquiry.png">
            </div>
            <a href="<?= base_url('workshop/driver/view_driver'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>


      </div>

    
      <!-- /.row -->
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
</section>  

  
