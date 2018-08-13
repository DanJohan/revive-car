 <section class="content">

    <div class="box">
        <div class="box-header workshop-header">
           <h3 class="box-title">User Detail</h3>
        </div>
    
      <div class="box-body">
           <div class="text-center">
            <?php if(!empty($user['profile_image'])) { ?>
              <img class="photo_img_round img-thumbnail" height="150" width="150" src="<?php echo base_url() ?>uploads/app/<?php echo $enquiry['profile_image']; ?>">
            <?php }else{ ?>
              <img class="photo_img_round img-thumbnail" height="150" width="150" src="<?= base_url() ?>public/images/admin/no_image.jpeg">
            <?php } ?>
          </div>
          <table class="table">
              <tr>
                  <td><b>User Name</b></td>
                  <td><?php echo $enquiry['name']; ?></td>
              </tr>
               <tr>
                  <td><b>Phone</b></td>
                  <td><?php echo $enquiry['phone']; ?></td>
              </tr>
              <tr>
                  <td><b>Email</b></td>
                  <td><?php echo $enquiry['email']; ?></td>
              </tr>
          </table>
      </div>
    </div><!-- end of user detail box -->
  <div class="box">
      <div class="box-header workshop-header">
        <h3 class="box-title">User cars detail</h3>
      </div>
    <div class="box-body">
        <table class="table">
          <tr><td><b>Brand Name: </b></td><td><?php echo $enquiry['brand_name']; ?></td>
          <tr><td><b>Model Name: </b></td><td><?php echo $enquiry['model_name']; ?></td>
          <tr><td><b>Year: </b></td><td><?php echo $enquiry['year']; ?></td>
          <tr><td><b>Colour: </b></td><td><?php echo ucfirst($enquiry['color']); ?></td>
          <tr><td><b>Year: </b></td><td><?php echo $enquiry['year']; ?></td>
          <tr><td><b>Registration No: </b> </td><td><?php echo $enquiry['registration_no']; ?></td>
        </table>
    </div>
  </div>
   <div class="box">
    <div class="box-header workshop-header">
      <h3 class="box-title">Customer enquiry</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table class="table">
             <tr>
                <td><b>Address</b></td>
                <td><?php echo $enquiry['address']; ?></td>
            </tr>
            <tr>
                <td><b>Location</b></td>
                <td><?php echo $enquiry['location']; ?></td>
            </tr>
             <tr>
                <td><b>Loaner vehicle</b></td>
                <td><?php echo ($enquiry['loaner_vehicle'])?'Required':'Not required'; ?></td>
            </tr>
             <tr>
                <td><b>Enquiry</b></td>
                <td><?php echo $enquiry['enquiry']; ?></td>
            </tr>
            <tr>
                <td><b>Service</b></td>
                <td><?php echo ($enquiry['service_type']==1)?"Denting":"Painting"; ?></td>
            </tr>
            <tr>
                <td><b>Pick up date</b></td>
                <td><?php echo $enquiry['pick_up_date']; ?></td>
            </tr>
            <tr>
                <td><b>Pick up time</b></td>
                <td><?php echo $enquiry['pick_up_time']; ?></td>
            </tr>
             <tr>
                <td><b>Images</b></td>
                <td>
                    <div class="row">
                    <?php 
                      if(!empty($enquiry['image_id'])) {
                        $image_id = explode('|', $enquiry['image_id']);
                        $images = explode('|', $enquiry['images']);
                        foreach ($image_id as $index => $id) {
                      ?>
                          <div class="col-md-4">
                            <div class="image-responsive">
                                <img class="img-thumbnail" src="<?php echo base_url().'uploads/app/'.$images[$index]; ?>" style="height:200px;width:100%;" />
                            </div>
                          </div>
                      <?php
                          if(($index+1) % 3 == 0) {
                            echo "</div><div class='row'>";
                          }
                        }
                      }else{
                         echo "No image uploaded";
                      }
                    ?>
                   
                 </td>
            </tr>
            <tr>
              <td>
                <a href="<?php echo base_url(); ?>workshop/enquiry/index" class="btn btn-success">Go back</a>
              </td>
            </tr>
        </table>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
</section>  

      
