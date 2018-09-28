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
    <td><?php echo $job_card['user_name']; ?></td>
  </tr>
  <tr>
    <td><b>Phone</b></td>
    <td><?php echo $job_card['user_phone']; ?></td>
  </tr>
  <tr>
    <td><b>Email</b></td>
    <td><?php echo $job_card['user_email']; ?></td>
  </tr>
  <tr>
    <td><b>Address</b></td>
    <td><?php echo $job_card['user_address']; ?></td>
  </tr>
</table>