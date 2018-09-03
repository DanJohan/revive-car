    <div class="row">
    <div class="cn_diver">
    
      <div class="col-sm-12 col-md-12 col-xs-12">
      <table id="example" class="table table-striped table-bordered" style="width:100%">
        <?php 
          if(isset($msg) && !empty($msg)) {
        ?>
          <div class="alert alert-danger">
            <?php echo $msg; ?>
          </div>
        <?php
          }
        ?>
        <thead>
            <tr>
                <th>User ID</th>
                <th>Car ID</th>
                <th>Model Name</th>
                <th>Brand Name</th>
                <th>Enquiry</th>
                <th>Service Type</th>
                <th>Registration No.</th>
                <th>Address</th>
                <th>Updated Time</th>
               
            </tr>
        </thead>
        <tbody>

            <?php 
            if(!empty($enquiries)){
            foreach ($enquiries as $key => $enq) {
               //print_r($enquiries);
             ?>
           
            <tr>
                <td><?php echo $enq['user_id']; ?></td>
                <td><?php echo $enq['car_id']; ?></td>
                <td><?php echo $enq['model_name']; ?></td>
                <td><?php echo $enq['brand_name']; ?></td>
                <td><?php echo $enq['enquiry']; ?></td>
                <td><?php echo $enq['service_type']; ?></td>
                <td><?php echo $enq['registration_no']; ?></td>
                <td><?php echo $enq['address']; ?></td>
                <td><?php echo $enq['updated_at']; ?></td>
            </tr>

            <?php } }?>
           
        </tbody>

       
    </table>
       </div>
     </div>
    </div>