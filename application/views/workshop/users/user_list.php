 <!-- Datatable style -->
<link rel="stylesheet" href="<?= base_url() ?>public/plugins/datatables/dataTables.bootstrap.css">  

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
                <td><?= $row['created_at']; ?></td>
              
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

<!-- DataTables -->
<script src="<?= base_url() ?>public/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>public/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
  $(function () {
    $("#example1").DataTable();
  });
</script> 
<script>
$("#users").addClass('active');
</script>        
