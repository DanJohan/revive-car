 <!-- Datatable style -->
<link rel="stylesheet" href="<?= base_url() ?>public/plugins/datatables/dataTables.bootstrap.css">  

 <section class="content">
   <div class="box">
    <div class="box-header">
      <h3 class="box-title">Workshop Drivers Detail</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
      <table id="example1" class="table table-bordered table-striped ">
        <thead>
        <tr>
          <th>Username</th>
          <th>Email</th>
          <th>Mobile No.</th>
          <th>Address</th>
          <th>Created At</th>
         <!-- <th style="width: 150px;" class="text-right">Option</th>-->
        </tr>
        </thead>
        <tbody>
          
          <?php foreach($driverData as $row):?>
      
          <tr>
            <td><?= $row['d_name']; ?></td>
            <td><?= $row['d_email']; ?></td>
            <td><?= $row['d_phone']; ?></td>
            <td><?= $row['d_address']; ?></td>
            <td><?= $row['created_at']; ?></td>
            
           <!-- <td class="text-right"><a href="" class="btn btn-info btn-flat">Edit</a>
              <a href="" class="btn btn-danger btn-flat">Delete</a></td>-->
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
