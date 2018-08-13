      <div class="modal-header workshop-header">
        <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
        <h3 class="modal-title">Driver Details</h3>
      </div>
      <div class="modal-body model_view admin-body" align="center">&nbsp;
        <div><?php if(!empty($driver_by_id['d_photo'])){?>
              <img class="photo_img_round img-thumbnail" height="150" width="150" src="<?= base_url() ?>uploads/admin/<?= $driver_by_id['d_photo']; ?>">
              <?php }else {?>
             <img class="photo_img_round img-thumbnail" height="150" width="150" src="<?= base_url() ?>public/images/admin/no_image.jpeg"><?php } ?></div>
        <div class="model_title"><h3><b><?php echo $driver_by_id['d_name']; ?></b></h3></div>
      </div>
      <div class="modal-body">
        <h3 style="text-decoration:underline;">Details Infromation</h3>
        <div class="row">
          <div class="col-xs-12">

          	<p><b>Name: </b> <?php echo $driver_by_id['d_name']; ?><br></p>
          	<p><b>Email Address: </b> <?php echo $driver_by_id['d_email']; ?><br></p>
          	<p><b>Contact No. </b> <?php echo $driver_by_id['d_phone']; ?><br></p>
          	<p><b>Location: </b> <?php echo $driver_by_id['d_location']; ?><br></p>
          	<p><b>Address: </b> <?php echo $driver_by_id['d_address']; ?><br></p>
          	<p><b>ID Proof: </b> <?php echo $driver_by_id['d_idproof']; ?><br></p>
            <p><b>License: </b> <?php echo $driver_by_id['d_license']; ?><br></p>
            <p><b>Workshop Manager Assign: </b> <?php echo $driver_by_id['m_name']." - ".$driver_by_id['m_workshop_location']; ?><br>
          	
          </div>
        </div>
      </div>
    </div>
                    <!-- /.modal-content -->


