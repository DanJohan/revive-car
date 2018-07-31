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
          <th>Manager Name</th>
          <th>Email</th>
          <th>Mobile No.</th>
          <th>Workstation</th>
          <th>ID Proof</th>
          <th>Address</th>
          <th>Created At</th>
          <th style="width: 150px;" class="text-right">Option</th>
        </tr>
        </thead>
        <tbody>
          
          <?php foreach($all_manager as $row):?>
      
          <tr>
            <td><?= $row['m_name']; ?></td>
            <td><?= $row['m_email']; ?></td>
            <td><?= $row['m_phone']; ?></td>
            <td><?= $row['m_workshop_location']; ?></td>
            <td><?= $row['m_id_proof']; ?></td>
            <td><?= $row['m_address']; ?></td>
            <td><?= $row['created_at']; ?></td>
            
            <td class="text-right"><a href="<?= base_url('admin/workshop/edit_manager/'.$row['id']); ?>" class="btn btn-info btn-flat">Edit</a>
              <a href="<?= base_url('admin/workshop/del_manager/'.$row['id']); ?>" class="btn btn-danger btn-flat">Delete</a></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
       
      </table>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
</section>  

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
</script>        
