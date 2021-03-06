<section class="content">
   <div class="box">
    <div class="box-header bg-green">
      <h3 class="box-title">Driver Details</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
      <table id="example1" class="table table-bordered table-striped ">
        <thead>
        <tr>
          <th>Image</th>
          <th>Name</th>
          <th>Email</th>
          <th>Mobile No.</th>
          <th>Address</th>
          <th>Created At</th>
          <th>Actions</th>
        </tr>
        </thead>
        <tbody>
          
          <?php 
          if(!empty($driverData))
          {
          foreach($driverData as $row) {?>
      
          <tr>
            <td><?php if($row['d_photo']){?>
              <img class="photo_img_round" height="50" width="50" src="<?= base_url() ?>uploads/admin/<?= $row['d_photo']; ?>">
              <?php }else {?>
             <img class="photo_img_round" height="50" width="50" src="<?= base_url() ?>public/images/admin/no_image.jpeg"><?php } ?></td>
            <td><?= $row['d_name']; ?></td>
            <td><?= $row['d_email']; ?></td>
            <td><?= $row['d_phone']; ?></td>
            <td><?= $row['d_address']; ?></td>
            <td><?= date('d M Y h:i A',strtotime($row['created_at'])); ?></td>
            <td class="text-right">
              <a data-toggle="modal" id="view-detail" class="btn btn-success" data-toggle="tooltip" data-link="<?= base_url('workshop/driver/view_record_by_id/'.$row['id']); ?>" data-original-title="View"><i class="fa fa-eye"></i></a>
            </td>
          </tr>
          <?php }} ?>
        </tbody>
       
      </table>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
</section>  
<?php $this->load->view('common/modal'); ?>
<?php echo $this->widget->beginBlock('scripts'); ?>
<script>
  $(function () {
    $("#example1").DataTable();
  });
</script> 
<script>
$("#view_users").addClass('active');
$(document).on('click','#view-detail',function(){

  $.ajax({
    url:$(this).data('link'),
    method:"POST",
    success:function(response){
        if(response) {
          $('.modal-content').html(response);
          $('#basicModal').modal();
        }
    }
  });
});
</script>
<?php $this->widget->endBlock(); ?>
