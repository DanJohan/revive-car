 <section class="content">

    <div class="box">
        <div class="box-header bg-green">
           <h3 class="box-title">Customer detail</h3>
        </div>
    
      <div class="box-body">
           <div class="text-center">
            <?php if(!empty($job_card['profile_image'])) { ?>
              <img class="photo_img_round img-thumbnail" height="150" width="150" src="<?php echo base_url() ?>uploads/app/<?php echo $job_card['profile_image']; ?>">
            <?php }else{ ?>
              <img class="photo_img_round img-thumbnail" height="150" width="150" src="<?= base_url() ?>public/images/admin/no_image.jpeg">
            <?php } ?>
          </div>
          <table class="table">
              <tr>
                  <td style="width: 50%"><b>User Name</b></td>
                  <td><?php echo $job_card['name']; ?></td>
              </tr>
               <tr>
                  <td><b>Phone</b></td>
                  <td><?php echo $job_card['phone']; ?></td>
              </tr>
              <tr>
                  <td><b>Email</b></td>
                  <td><?php echo $job_card['email']; ?></td>
              </tr>
          </table>
      </div>
    </div><!-- end of user detail box -->


        <div class="box">
        <div class="box-header bg-green">
           <h3 class="box-title">Vehicle detail</h3>
        </div>
    
      <div class="box-body">
          <table class="table">
              <tr>
                  <td><b>Registertion No</b></td>
                  <td><?php echo $job_card['registration_no']; ?></td>
              </tr>
               <tr>
                  <td><b>Brand Name</b></td>
                  <td><?php echo $job_card['brand_name']; ?></td>
              </tr>
              <tr>
                  <td><b>Model</b></td>
                  <td><?php echo $job_card['model_name']; ?></td>
              </tr>
              <tr>
                  <td><b>VIN No</b></td>
                  <td><?php echo $job_card['vin_no']; ?></td>
              </tr>
              <tr>
                  <td><b>S A Name & No</b></td>
                  <td><?php echo $job_card['sa_name_no']; ?></td>
              </tr>
              <tr>
                  <td><b>Delivery Date And Time</b></td>
                  <td><?php echo $job_card['delivery_datetime']; ?></td>
              </tr>
              <tr>
                  <td><b>Reporting Date and Time</b></td>
                  <td><?php echo $job_card['reporting_datetime']; ?></td>
              </tr>
              <tr>
                  <td><b>Km</b></td>
                  <td><?php echo $job_card['ride_kms']; ?></td>
              </tr>
               <tr>
                  <td><b>Type Of Services</b></td>
                  <td>
                    <?php
                    $type_of_services=json_decode($job_card['type_of_service']);
                    if(!empty($type_of_services)) {
                      foreach ($type_of_services as $index => $type_of_service) {
                        if(($index+1) < count($type_of_services)){
                          $suffix=", ";
                        }else{
                          $suffix='';
                        }
                  ?>
                    <span><?php echo $type_of_service.$suffix; ?></span>
                  <?php
                      }
                    }
                  ?>
                  </td>
              </tr>
          </table>
      </div>
    </div><!-- end of vehicle detail box -->

    <div class="box">
          <div class="box-header bg-green">
            <h3 class="box-title">Repair orders</h3>
          </div>
          <div class="box-body">
                <div class="table-responsive">
                      <table class="table ">
                        <thead>
                          <tr>
                            <th>Customer Request</th>
                            <th>S.A  Remarks</th>
                            <th>Parts Name</th>
                            <th> Qty</th>
                            <th>Parts Price</th>
                            <th>Labour Price</th>
                            <th>Total Price</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $repair_orders = $job_card['repair_orders'];
                          if(!empty($repair_orders)) {
                            foreach ($repair_orders as $index => $repair_order) {
                          ?>
                            <tr>
                            <td><?php echo $repair_order['customer_request']; ?></td>
                            <td><?php echo $repair_order['sa_remarks']; ?></td>
                            <td><?php echo $repair_order['parts_name']; ?></td>
                            <td><?php echo $repair_order['qty']; ?></td>
                            <td><?php echo $repair_order['price_parts']; ?></td>
                            <td><?php echo $repair_order['price_labour']; ?></td>
                            <td><?php echo $repair_order['price_total']; ?></td>
                            <td>
                              <?php if($repair_order['status']) { ?>
                                <a href="javascript:void(0)" class="btn btn-success">Completed</a>
                            <?php }else { ?>

                              <a href="javascript:void(0)" data-job-id="<?php echo $repair_order['repair_order_id']; ?>" class="btn btn-danger job-complete">Mark as complete</a>
                            <?php } ?>
                            </td>
                          </tr>
                          <?php
                            }
                          }
                          ?>
                          
                        </tbody>
                        <tfoot>
                          <tr>

                          </tr>
                        </tfoot>
                      </table>
              </div><!--end of .table-responsive-->
        </div>
    </div><!-- end of repair order box -->

    <div class="box">
    
      <div class="box-body">
            <a href="<?php echo base_url();?>workshop/jobCard/list" class="btn btn-success">Go back</a>
      </div>
    </div><!-- end of button box -->

</section>
<script>
  $(document).on('click','.job-complete',function(){
    var btn = $(this);
    var jobId = btn.data('job-id');
    if(jobId){
      $.ajax({
        url:"<?php echo base_url();?>workshop/jobCard/markJobComplete",
        method:"POST",
        data:{'job_id':jobId},
        success:function(response){

        }
      });
    }
  });
</script>


