
 <section class="content">
   <div class="box">
    <div class="box-header bg-green">
      <h3 class="box-title">Registered Customers</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
      <table id="example1" class="table table-bordered table-striped ">
        <thead>
        <tr>
          <th>Customer id</th>
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
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td><?php echo date('d M Y h:i A',strtotime($row['created_at'])); ?></td>
                <td class="text-right">
                  <a data-toggle="modal" class="btn btn-success" data-toggle="tooltip" href="<?php echo base_url('workshop/users/show/'.$row['id']); ?>" data-original-title="View"><i class="fa fa-eye"></i></a>
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
    $("#example1").DataTable({
      'order':[[0,'desc']]
    });
  });
</script> 
<script>
$("#users").addClass('active');

</script>        
