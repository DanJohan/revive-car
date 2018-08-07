      <div class="modal-header orange_header">
        <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
        <h3 class="modal-title">User Detail</h3>
      </div>
      <div class="modal-body model_view" align="center">&nbsp;
        <div><?php if(!empty($user['profile_image'])) { ?>
          <img class="photo_img_round" height="150" width="150" src="<?php echo base_url() ?>uploads/admin/<?php echo $user['profile_image']; ?>">
        <?php }else{ ?>
         <img class="photo_img_round" height="150" width="150" src="<?= base_url() ?>public/images/admin/no_image.jpeg"><?php } ?></div>
         <div class="model_title"><b><?php echo $user['name']; ?></b></div>
       </div>
       <div class="modal-body">
        <h3 style="text-decoration:underline;">Details Infromation</h3>
        <div class="row">
          <div class="col-xs-12">

          	<b>Name: </b> <?php echo $user['name']; ?><br>
          	<b>Email Address: </b> <?php echo $user['email']; ?><br>
          	<b>Contact No. </b> <?php echo $user['phone']; ?><br>
          	
          </div>
        </div>
      </div>
    </div>
                    <!-- /.modal-content -->