      <div class="modal-header orange_header">
        <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
        <h3 class="modal-title">Manager Details</h3>
      </div>
      <div class="modal-body model_view" align="center">&nbsp;
        <div><?php if(!empty($manager_by_id['m_photo'])) { ?>
              <img class="photo_img_round" height="150" width="150" src="<?= base_url() ?>uploads/admin/<?= $manager_by_id['m_photo']; ?>">
              <?php }else{ ?>
             <img class="photo_img_round" height="150" width="150" src="<?= base_url() ?>public/images/admin/no_image.jpeg"><?php } ?></div>
        <div class="model_title"><b><?php echo $manager_by_id['m_name']; ?></b></div>
      </div>
      <div class="modal-body">
        <h3 style="text-decoration:underline;">Details Infromation</h3>
        <div class="row">
          <div class="col-xs-12">

          	<b>Name: </b> <?php echo $manager_by_id['m_name']; ?><br>
          	<b>Email Address: </b> <?php echo $manager_by_id['m_email']; ?><br>
          	<b>Contact No. </b> <?php echo $manager_by_id['m_phone']; ?><br>
          	<b>Workshop Location: </b> <?php echo $manager_by_id['m_workshop_location']; ?><br>
          	<b>Address: </b> <?php echo $manager_by_id['m_address']; ?><br>
          	<b>ID Proof: </b> <?php echo $manager_by_id['m_id_proof']; ?><br>
          	
          </div>
        </div>
      </div>
    </div>
                    <!-- /.modal-content -->


