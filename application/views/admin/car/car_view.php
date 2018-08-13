      <div class="modal-header custom-modal-header">
        <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
        <h3 class="modal-title">Car Detail</h3>
      </div>
      <div class="modal-body">
        <h3 style="text-decoration:underline;">Car Details Infromation</h3>
        <div class="row">
          <div class="col-xs-12">

            <p><b>Brand Name: </b> <?php echo $car['brand_name']; ?><br></p>
            <p><b>Model Name: </b> <?php echo $car['model_name']; ?><br></p>
            <p><b>Year: </b> <?php echo $car['year']; ?><br></p>
            <p><b>Colour: </b> <?php echo ucfirst($car['color']); ?><br></p>
            <p><b>Year: </b> <?php echo $car['year']; ?><br></p>
            <p><b>Registration No: </b> <?php echo $car['registration_no']; ?><br></p>
          </div>
        </div>
      </div>
      <div class="modal-header custom-modal-header">
        <h3 class="modal-title">User Detail</h3>
      </div>
      <div class="modal-body model_view custom-modal-body" align="center">&nbsp;
        <div><?php if(!empty($user['profile_image'])) { ?>
          <img class="photo_img_round img-thumbnail" height="150" width="150" src="<?php echo base_url() ?>uploads/app/<?php echo $car['profile_image']; ?>">
        <?php }else{ ?>
         <img class="photo_img_round img-thumbnail" height="150" width="150" src="<?= base_url() ?>public/images/admin/no_image.jpeg"><?php } ?></div>
         <div class="model_title"><b><?php echo $car['name']; ?></b></div>
       </div>
       <div class="modal-body">
        <h3 style="text-decoration:underline;">User Detail Infromation</h3>
        <div class="row">
          <div class="col-xs-12">
            <p><b>User id: </b> <?php echo $car['user_id']; ?><br></p>
          	<p><b>Name: </b> <?php echo $car['name']; ?><br></p>
          	<p><b>Email Address: </b> <?php echo $car['email']; ?><br></p>
          	<p><b>Contact No. </b> <?php echo $car['phone']; ?><br></p>
          	
          </div>
        </div>
      </div>
    </div>
                    <!-- /.modal-content -->