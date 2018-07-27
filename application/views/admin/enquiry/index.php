 <!-- Datatable style -->
<link rel="stylesheet" href="<?= base_url() ?>public/plugins/datatables/dataTables.bootstrap.css">  

 <section class="content">
   <div class="box">
    <div class="box-header">
      <h3 class="box-title">Customer enquiry</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
      <table id="example1" class="table table-bordered table-striped ">
        <thead>
        <tr>
          <th>Username</th>
          <th>Car-Model</th>
          <th>Loaner vehicle</th>
          <th>Enquiry</th>
          <th>Created At</th>
          <th style="width: 150px;" class="text-right">Actions</th>
        </tr>
        </thead>
        <tbody>
          <?php 
            if(!empty($enquiries)) {
              foreach ($enquiries as $index => $enquiry) {
          ?>
            <tr>
                <td><?php echo $enquiry['name']; ?></td>
                <td><?php echo $enquiry['brand_name']."-".$enquiry['model_name']; ?></td>
                <td><?php echo ($enquiry['loaner_vehicle'])? 'Required' : 'Not required'; ?></td>
                <td><?php echo $enquiry['enquiry']; ?></td>
                <td><?php echo date('d M Y',strtotime($enquiry['created_at'])); ?></td>
                <td><a class="btn btn-success" href="<?= base_url('admin/enquiry/show/'.$enquiry['id']); ?>">View</a></td>
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
$("#view_users").addClass('active');
</script>        
