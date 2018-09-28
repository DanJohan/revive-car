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