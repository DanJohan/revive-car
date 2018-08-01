 <!-- Datatable style -->
<link rel="stylesheet" href="<?= base_url() ?>public/plugins/datatables/dataTables.bootstrap.css">  

 <section class="content">
   <div class="box">
    <div class="box-header">
      <h3 class="box-title">job card Detail</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
      <table id="jobcard" class="table table-bordered table-striped ">
        <thead>
        <tr>

         <th>User name</th>
          <th>Job Name</th>
          <th>Car</th>
          <th>Created At</th>
         <!-- <th style="width: 150px;" class="text-right">Option</th>-->
        </tr>
        </thead>
        <tbody>
        
          <?php foreach($jobcardData as $row):?>
      
          <tr>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo  $row['job_name']; ?></td>
            <td><?php echo $row['brand_name']."-".$row['model_name']; ?></td>
            <td><?php echo $row['created_at']; ?></td>
            
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
    $("#jobcard").DataTable();
  });
</script> 
<script>
$("#view_users").addClass('active');
</script>        
