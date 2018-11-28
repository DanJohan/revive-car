 <section class="content">
    <div class="row">
    <div class="col-xs-6">
    <div class="box">
        <div class="box-header bg-green">
           <h3 class="box-title">Customer detail</h3>
        </div>
    
      <div class="box-body">
        <?php $this->load->view('common/jobcard/jobcard_user_detail'); ?>
      </div>
    </div><!-- end of user detail box -->
</div>
  <div class="col-xs-6">
        <div class="box">
        <div class="box-header bg-green">
           <h3 class="box-title">Vehicle detail</h3>
        </div>
    
      <div class="box-body">
        <?php $this->load->view('common/jobcard/jobcard_vehicle_detail'); ?>
      </div>
    </div><!-- end of vehicle detail box -->
  </div>
</div>
    <div class="box">
    
          <div class="box-body">
              <?php $this->load->view('common/jobcard/jobcard_damage'); ?>
        </div>
    </div><!-- end of damage mark image box -->

      <div class="box">
    
          <div class="box-body">
                <?php $this->load->view('common/jobcard/jobcard_car_property'); ?>
        </div>
    </div><!-- end of car accessiories box -->

    <div class="box">
            <div class="box-header bg-green">
              <h3 class="box-title">Fuel</h3>
            </div>
    
          <div class="box-body">
              <?php $this->load->view('common/jobcard/jobcard_fuel'); ?>
          </div>
    </div><!-- end of fuel box -->

    <div class="box">
          <div class="box-header bg-green">
            <h3 class="box-title">Vehicle Items</h3>
          </div>
          <div class="box-body">
               <?php $this->load->view('common/jobcard/jobcard_vehicle_items'); ?>
        </div>
    </div><!-- end of vehicle quntity box -->

    <div class="box">
          <div class="box-header bg-green">
            <h3 class="box-title">Repair orders</h3>
          </div>
          <div class="box-body">
		  <?php $this->load->view('common/jobcard/jobcard_order_item'); ?>
        </div>
    </div><!-- end of repair order box -->

     <div class="box">
        <div class="box-header bg-green">
           <h3 class="box-title">Images</h3>
        </div>
    
      <div class="box-body">
          <?php $this->load->view('common/jobcard/jobcard_images'); ?>
      </div>
    </div><!-- end of images box -->

      <div class="box">
        <div class="box-header bg-green">
           <h3 class="box-title">Signature</h3>
        </div>
    
      <div class="box-body">
           <div class="col-xs-12 text-center">
              <div class="image-responsive">
                <img class="img-thumbnail" src="<?php echo base_url(); ?>uploads/app/<?php echo $job_card['signature']; ?>">   
              </div>
            </div> 
      </div>
    </div><!-- end of signature box -->


    <div class="box">
    
      <div class="box-body">
            <a href="<?php echo base_url();?>workshop/jobCard/list" class="btn btn-success">Go back</a>
      </div>
    </div><!-- end of button box -->


</section>


