  <style type="text/css">
.btn{
  padding: 3px 6px !important;
}
 </style>
 <section class="content">
   <div class="box">
    <div class="box-header">
      <h3 class="box-title">Registered Drivers</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
      <table id="example1" class="table table-bordered table-striped ">
        <thead>
        <tr>
          <th>Image</th>
          <th>Username</th>
          <th>Email</th>
          <th>Mobile No.</th>
          <th>Created at</th>
          <th style="width: 150px;" class="text-right">Option</th>
        </tr>
        </thead>
        <tbody>
          
          <?php foreach($all_driver as $row):?>
      
          <tr>

            <td><?php if($row['d_photo']){?>
              <img class="photo_img_round" height="50" width="50" src="<?= base_url() ?>uploads/admin/<?= $row['d_photo']; ?>">
              <?php }else {?>
             <img class="photo_img_round" height="50" width="50" src="<?= base_url() ?>public/images/admin/no_image.jpeg"><?php } ?></td>
              
            <td><?= $row['d_name']; ?></td>
            <td><?= $row['d_email']; ?></td> 
            <td><?= $row['d_phone']; ?></td>
            <td><?= date('d M Y h:i A',strtotime($row['created_at'])); ?></td>
            <td class="text-right">
              <a data-toggle="modal" id="view-detail" class="btn btn-success" data-toggle="tooltip" data-link="<?= base_url('admin/driver/view_record_by_id/'.$row['id']); ?>" data-original-title="View"><i class="fa fa-eye"></i></a>
              
            <a class="btn btn-primary" data-toggle="tooltip" href="<?= base_url('admin/driver/edit_driver/'.$row['id']); ?>" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
            <a class="btn btn-danger" data-toggle="tooltip" onclick="return confirm('Are you sure to delete this record?')" href="<?= base_url('admin/driver/del_driver/'.$row['id']); ?>" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>
            
            </td>
           
          </tr>
          <?php endforeach; ?>
        </tbody>
       
      </table>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
</section>  
<?php $this->load->view('common/modal'); ?>
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
