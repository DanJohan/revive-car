   <style type="text/css">
.btn{
  padding: 3px 6px !important;
}
 </style>
 <!-- Datatable style -->
<link rel="stylesheet" href="<?= base_url() ?>public/plugins/datatables/dataTables.bootstrap.css">  

 <section class="content">
   <div class="box">
    <div class="box-header">
      <h3 class="box-title">Registered Manager</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
      <table id="example1" class="table table-bordered table-striped ">
        <thead>
        <tr>
          <th>Image</th>
          <th>Manager Name</th>
          <th>Email</th>
          <th>Mobile No.</th>
          
          <th>Created At</th>
          <th style="width: 150px;" class="text-right">Option</th>
        </tr>
        </thead>
        <tbody>
          
          <?php 
          if(!empty($all_manager)) {
            foreach($all_manager as $row) {
          ?>
      
          <tr>
            <td><?php if($row['m_photo']){?>
              <img class="photo_img_round" height="50" width="50" src="<?= base_url() ?>uploads/admin/<?= $row['m_photo']; ?>">
              <?php }else {?>
             <img class="photo_img_round" height="50" width="50" src="<?= base_url() ?>public/images/admin/no_image.jpeg">
             <?php } ?>
           </td>
            
            <td><?php echo $row['m_name']; ?></td>
            <td><?php echo $row['m_email']; ?></td>
            <td><?php echo $row['m_phone']; ?></td>
            <td><?php echo date('d M Y h:i A',strtotime($row['created_at'])); ?></td>

         
            <td class="text-right">
              <a data-toggle="modal" id="view-detail" class="btn btn-success" data-toggle="tooltip" data-link="<?php echo  base_url('admin/workshop/view_record_by_id/'.$row['id']); ?>" data-original-title="View"><i class="fa fa-eye"></i></a>
              <a class="btn btn-primary" data-toggle="tooltip" href="<?php echo base_url('admin/workshop/edit_manager/'.$row['id']); ?>" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
              <a class="btn btn-danger" data-toggle="tooltip" onclick="return confirm('Are you sure to delete this record?')" href="<?php echo base_url('admin/workshop/del_manager/'.$row['id']); ?>" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>
            

          </tr>
          <?php
               }
            } 
          ?>
        </tbody>
       
      </table>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
</section>  
<?php $this->load->view('common/modal');?>

<!-- DataTables -->
<script src="<?= base_url() ?>public/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>public/plugins/datatables/dataTables.bootstrap.min.js"></script>
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
