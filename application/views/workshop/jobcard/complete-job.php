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
              <img class="photo_img_round img-thumbnail" height="150" width="150" src="<?php echo base_url() ?>public/images/admin/no_image.jpeg">
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
                            <th>S.No.</th>
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
                            $i=1;
                            foreach ($repair_orders as $index => $repair_order) {
                          ?>
                            <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $repair_order['customer_request']; ?></td>
                            <td><?php echo $repair_order['sa_remarks']; ?></td>
                            <td><?php echo $repair_order['parts_name']; ?></td>
                            <td><?php echo $repair_order['qty']; ?></td>
                            <td><?php echo number_format($repair_order['price_parts'],2,'.',','); ?></td>
                            <td><?php echo number_format($repair_order['price_labour'],2,'.',','); ?></td>
                            <td><?php echo number_format($repair_order['price_total'],2,'.',','); ?></td>
                            <td>
                              <?php if($repair_order['status']) { ?>
                                <a href="javascript:void(0)" class="btn btn-success">Completed</a>
                            <?php }else { ?>

                              <a href="javascript:void(0)" data-user-id="<?php echo $job_card['user_id']; ?>" data-job-id="<?php echo $repair_order['repair_order_id']; ?>" class="btn btn-danger job-complete">Mark as complete</a>
                            <?php } ?>
                            </td>
                          </tr>
                          <?php
                           $i++;
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
          <div class="box-header bg-green">
            <h3 class="box-title">Add Repair orders</h3>
          </div>
          <div class="box-body">
               <form id="order-form" method="post" class="form-horizontal" action="<?php echo base_url()?>workshop/jobCard/addOrder">
                <input type="hidden" name="job_card_id" value="<?php echo $job_card['id']; ?>">
                <input type="hidden" name="user_id" value="<?php echo $job_card['user_id']; ?>">
                <div class="form-group">
                  <label class="control-label col-sm-2" for="customer_request">Customer Request:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="customer_request" id="customer_request">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="sa_remarks">S.A Remarks:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="sa_remarks" id="sa_remarks">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="parts_name">Parts Name:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="parts_name" id="parts_name">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="qty">Quantity:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="quantity" id="qty">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="parts_price">Parts price:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="parts_price" id="parts_price">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="labour_price">Labour price:</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="labour_price" id="labour_price">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="total_price">Total price:</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" name="total_price" id="total_price">
                  </div>
                </div>
                <div class="col-xs-offset-2">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
              </form>
        </div>
    </div><!-- end of repair order box -->

    <div class="box">
    
      <div class="box-body">
            <a href="<?php echo base_url();?>workshop/jobCard/list" class="btn btn-success">Go back</a>
      </div>
    </div><!-- end of button box -->

</section>
<script src="<?php echo base_url() ?>public/dist/js/jquery.validate.min.js"></script>
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
          if(response.status){
            btn.removeClass('btn-danger job-complete');
            btn.addClass('btn-success');
            btn.text('Completed');

          }
        }
      });
    }
  });

  (function(){
    $("#order-form").validate({
      errorClass: "error",
      rules: {
        customer_request:{
          required:true
        },
        sa_remarks: {
          required: true,
        },
        parts_name: {
          required: true,
        },
        parts_price: {
          required: true,
          digits: true
        },
        labour_price: {
          required: true,
          digits: true
        },
        quantity: {
          required: true,
          digits: true
        },
        total_price: {
          required: true,
          digits: true
        },
      },
    });
  })();
</script>


