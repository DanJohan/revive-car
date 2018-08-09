
 <section class="content">
   <div class="box">
    <div class="box-header bg-green">
      <h3 class="box-title">Registered Users</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
      <table id="example1" class="table table-bordered table-striped ">
        <thead>
        <tr>
          <th>Username</th>
          <th>Email</th>
          <th>Mobile No.</th>
          <th>Created At</th>
          <th>Actions</th>
        </tr>
        </thead>
        <tbody>
          <?php 
          if(!empty($userData))
          {
          foreach($userData as  $row)
            {
            ?>
              <tr>
                <td><?= $row['name']; ?></td>
                <td><?= $row['email']; ?></td>
                <td><?= $row['phone']; ?></td>
                <td><?= date('d M Y h:i A',strtotime($row['created_at'])); ?></td>
                <td class="text-right">
                  <a data-toggle="modal" id="view-detail" class="btn btn-success" data-toggle="tooltip" data-link="<?= base_url('workshop//users/view_record_by_id/'.$row['id']); ?>" data-original-title="View"><i class="fa fa-eye"></i></a>
                </td>
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
<?php $this->load->view('common/modal'); ?>
<script>
  $(function () {
    $("#example1").DataTable();
  });
</script> 
<script>
$("#users").addClass('active');
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
