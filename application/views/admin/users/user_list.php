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
         <!--  <th>Device</th> -->
          <th>Created At</th>
          <th style="width: 150px;" class="text-right">Option</th>
        </tr>
        </thead>
        <tbody>
          <?php foreach($all_users as $row): ?>
          <tr>
            <td><?= $row['name']; ?></td>
            <td><?= $row['email']; ?></td>
            <td><?= $row['phone']; ?></td>
            <!-- <td><?= $row['device_type']; ?></td> -->
            <td><?= $row['created_at']; ?></td>
           <td class="text-right">
            <a class="btn btn-primary" data-toggle="tooltip" href="<?= base_url('admin/users/edit/'.$row['id']); ?>" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
            <a class="btn btn-danger" data-toggle="tooltip" href="<?= base_url('admin/users/del/'.$row['id']); ?>" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>
            
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
