 <section class="content">
   <div class="box">
    <div class="box-header">
      <h3 class="box-title">Customer detail</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="text-center">
          <?php if(!empty($user['profile_image'])) { ?>
            <img class="photo_img_round img-thumbnail" height="150" width="150" src="<?php echo base_url() ?>uploads/app/<?php echo $user['profile_image']; ?>">
          <?php }else{ ?>
            <img class="photo_img_round img-thumbnail" height="150" width="150" src="<?= base_url() ?>public/images/admin/no_image.jpeg">
          <?php } ?>
        </div>
        <table class="table" style="width:100%;">
            <tr>
                <td><b>User Name</b></td>
                <td><?php echo $user['name']; ?></td>
            </tr>
             <tr>
                <td><b>Email</b></td>
                <td><?php echo $user['email']; ?></td>
            </tr>
             <tr>
                <td><b>Phone</b></td>
                <td><?php echo $user['phone']; ?></td>
            </tr>
        </table>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
  <div class="box">
      <div class="box-header">
        <h3 class="box-title">Customer cars detail</h3>
      </div>
      <div class="box-body">
            <?php if(!empty($cars)) { 
              foreach ($cars as $index => $car) {
            ?>
              <table class="table">
                <tr style="background-color: #3c8cbd;color:white;"><td>Car No.</td><td><?php echo ($index+1); ?></td></tr>
                <tr><td><b>Brand Name: </b></td><td><?php echo $car['brand_name']; ?></td>
                <tr><td><b>Model Name: </b></td><td><?php echo $car['model_name']; ?></td>
                <tr><td><b>Year: </b></td><td><?php echo $car['year']; ?></td>
                <tr><td><b>Colour: </b></td><td><?php echo ucfirst($car['color']); ?></td>
                <tr><td><b>Year: </b></td><td><?php echo $car['year']; ?></td>
                <tr><td><b>Registration No: </b> </td><td><?php echo $car['registration_no']; ?></td>
              </table>
            <?php } }else{ ?>
                <p>No record found</p>
            <?php } ?>
          <a href="<?php echo base_url(); ?>admin/users" class="btn btn-primary">Go back</a>
      </div>
  </div>
</section>  

      
