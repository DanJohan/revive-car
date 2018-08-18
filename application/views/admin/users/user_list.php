
 <section class="content">
   <div class="box">
    <div class="box-header">
      <h3 class="box-title">Registered Users</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
      <table id="example1" class="table table-bordered table-striped ">
        <thead>
        <tr>
          <th>User id</th>
          <th>Username</th>
          <th>Email</th>
          <th>Mobile No.</th>
         <!--  <th>Device</th> -->
          <th>Created At</th>
          <th style="width: 150px;" class="text-right">Option</th>
        </tr>
        </thead>
        <tbody>
          <?php foreach($all_users as $user){ ?>
          <tr>
            <td><?php echo $user['id']; ?></td>
            <td><?php echo $user['name']; ?></td>
            <td><?php echo $user['email']; ?></td>
            <td><?php echo $user['phone']; ?></td>
            <td><?php echo date('d M Y h:i A',strtotime($user['created_at'])); ?></td>
           <td class="text-right">
              <a data-toggle="modal" class="btn btn-success" data-toggle="tooltip" href="<?= base_url('admin/users/show/'.$user['id']); ?>" data-original-title="View"><i class="fa fa-eye"></i></a>
            <a class="btn btn-primary" data-toggle="tooltip" href="<?= base_url('admin/users/edit/'.$user['id']); ?>" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
            <a class="btn btn-danger" onclick="return confirm('Are you sure to delete this record?')" data-toggle="tooltip" href="<?= base_url('admin/users/del/'.$user['id']); ?>" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>
            
            </td>
          </tr>
          <?php } ?>
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
    $("#example1").DataTable({
      'order':[[0,'desc']]
    });
  });
</script> 
     
