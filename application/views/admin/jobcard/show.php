 <section class="content">

    <div class="box">
        <div class="box-header">
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
        <div class="box-header">
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
    
          <div class="box-body">
                <?php 
                   $damage_mark = json_decode($job_card['damage_mark']);
                ?>
               <div class="img-wrapper text-center">
                <img src="<?php echo base_url(); ?>public/images/app/car.jpg" style="width:70%;height:500px;">
                  <div class="left-top damage-mark-box"><?php echo $damage_mark[0]; ?></div>
                  <div class="left-center damage-mark-box"><?php echo $damage_mark[1]; ?></div>
                  <div class="left-bottom damage-mark-box"><?php echo $damage_mark[2]; ?></div>
                  <div class="middle-top damage-mark-box"><?php echo $damage_mark[3]; ?></div>
                  <div class="middle-center damage-mark-box"><?php echo $damage_mark[4]; ?></div>
                  <div class="middle-bottom damage-mark-box"><?php echo $damage_mark[5]; ?></div>
                  <div class="right-top damage-mark-box"><?php echo $damage_mark[6]; ?></div>
                  <div class="right-center damage-mark-box"><?php echo $damage_mark[7]; ?></div>
                  <div class="right-bottom damage-mark-box"><?php echo $damage_mark[8]; ?></div>
              </div>
        </div>
    </div><!-- end of damage mark image box -->

      <div class="box">
    
          <div class="box-body">
                <table class="table">
                <?php
                    $car_properties=json_decode($job_card['car_properties'],true);
                    //dd($car_properties,false);
                    if(!empty($car_properties)){
                      foreach ($car_properties as $index => $car_property) {
                  ?>
                  <tr><td><b><?php echo $car_property['name']; ?></b>:</td><td><?php echo $car_property['value']; ?></td></tr>
                  <?php
                      }
                    }
                ?>
              </table>
        </div>
    </div><!-- end of car accessiories box -->

    <div class="box">
            <div class="box-header">
              <h3 class="box-title">Fuel</h3>
            </div>
    
          <div class="box-body">
                <div class="progress">
                  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $job_card['fuel']; ?>"
                  aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $job_card['fuel']; ?>%">
                    <?php echo $job_card['fuel']."%"; ?>
                  </div>
              </div>
          </div>
    </div><!-- end of fuel box -->

    <div class="box">
          <div class="box-header">
            <h3 class="box-title">Vehicle Items</h3>
          </div>
          <div class="box-body">
                <table class="table">
                  <tr>
                      <th>Item</th>
                      <th>Quantity</th>
                  </tr>
                <?php
                    $vehicle_qtys=json_decode($job_card['vehicle_qty'],true);
                    //dd($car_properties,false);
                    if(!empty($vehicle_qtys)){
                      foreach ($vehicle_qtys as $index => $vehicle_qty) {
                  ?>
                  <tr><td><?php echo $vehicle_qty['item']; ?></td><td><?php echo $vehicle_qty['qty']; ?></td></tr>
                  <?php
                      }
                    }
                  ?>
              </table>
        </div>
    </div><!-- end of vehicle quntity box -->

    <div class="box">
          <div class="box-header">
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
                            <td><?php echo number_format($repair_order['price_parts'],2,'.',','); ?></td>
                            <td><?php echo number_format($repair_order['price_labour'],2,'.',','); ?></td>
                            <td><?php echo number_format($repair_order['price_total'],2,'.',','); ?></td>
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
        <div class="box-header">
           <h3 class="box-title">Images</h3>
        </div>
    
      <div class="box-body">
           <div class="row">
             <?php 
            $job_card_images = $job_card['images_data'];
                        if(!empty($job_card_images)) {
                          $i=1;
                          foreach ($job_card_images as $index => $job_card_image) {
                        ?>
                            <div class="col-md-4 col-sm-4 col-xs-6">
                              <div class="image-responsive">
                                  <a target="_blank" href="<?php echo base_url().'uploads/app/'.$job_card_image['image']; ?>"><img class="img-thumbnail" src="<?php echo base_url().'uploads/app/'.$job_card_image['image']; ?>" style="height:200px;width:100%;" /></a>
                              </div>
                            </div>
                        <?php
                            if($i % 3 == 0) {

                              echo "</div><div class='row'>";
                            }
                            $i++;
                          }
                        }else{
                           echo "No image uploaded";
                        }
              ?>
          </div>
      </div>
    </div><!-- end of images box -->

      <div class="box">
        <div class="box-header">
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
            <a href="<?php echo base_url();?>admin/jobCard/list" class="btn btn-primary">Go back</a>
      </div>
    </div><!-- end of button box -->


</section>


