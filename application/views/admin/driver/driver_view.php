      <div class="modal-header orange_header">
        <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
        <h3 class="modal-title">Driver Details</h3>
      </div>
      <div class="modal-body model_view" align="center">&nbsp;
        <div><?php if(!empty($driver_by_id['d_photo'])){?>
              <img class="photo_img_round" height="150" width="150" src="<?= base_url() ?>uploads/admin/<?= $driver_by_id['d_photo']; ?>">
              <?php }else {?>
             <img class="photo_img_round" height="150" width="150" src="<?= base_url() ?>public/images/admin/no_image.jpeg"><?php } ?></div>
        <div class="model_title"><h3><b><?php echo $driver_by_id['d_name']; ?></b></h3></div>
      </div>
      <div class="modal-body">
        <h3 style="text-decoration:underline;">Details Infromation</h3>
        <div class="row">
          <div class="col-xs-12">

          	<b>Name: </b> <?php echo $driver_by_id['d_name']; ?><br>
          	<b>Email Address: </b> <?php echo $driver_by_id['d_email']; ?><br>
          	<b>Contact No. </b> <?php echo $driver_by_id['d_phone']; ?><br>
          	<b>Location: </b> <?php echo $driver_by_id['d_location']; ?><br>
          	<b>Address: </b> <?php echo $driver_by_id['d_address']; ?><br>
          	<b>ID Proof: </b> <?php echo $driver_by_id['d_idproof']; ?><br>
            <b>License: </b> <?php echo $driver_by_id['d_license']; ?><br>
            <b>Workshop Manager Assign: </b> <?php echo $driver_by_id['m_name']." - ".$driver_by_id['m_workshop_location']; ?><br>
          	
          </div>
        </div>
      </div>
    </div>
                    <!-- /.modal-content -->


