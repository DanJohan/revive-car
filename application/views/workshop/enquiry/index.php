  <style type="text/css">
.btn{
  padding: 3px 6px !important;
}
 </style>
 <!-- Datatable style -->
<link rel="stylesheet" href="<?php echo base_url(); ?>public/plugins/datatables/dataTables.bootstrap.css">  

 <section class="content">
   <div class="box">
    <div class="box-header bg-green">
      <h3 class="box-title">Customer Confirm enquiry</h3>
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
          <th style="width:100px; class="text-right"">Actions</th>
        </tr>
        </thead>
        <tbody>
          <?php 
            if(!empty($enquiries)) {
              foreach ($enquiries as $index => $enquiry) {
          ?>
            <!--<tr style="<?php //echo ($enquiry['confirmed'])?'background-color: lightgreen':''; ?>">-->
              <tr>
                <td><?php echo $enquiry['name']; ?></td>
                <td><?php echo $enquiry['brand_name']."-".$enquiry['model_name']; ?></td>
                <td><?php echo ($enquiry['loaner_vehicle'])? 'Required' : 'Not required'; ?></td>
                <td><?php echo $enquiry['enquiry']; ?></td>
                <td><?php echo date('d M Y h:i A',strtotime($enquiry['created_at'])); ?></td>
                <td style="width: 100px;" class="text-right"">
                  <a class="btn btn-success" data-toggle="tooltip" href="<?php echo base_url('workshop/enquiry/show/'.$enquiry['id']); ?>" data-original-title="View"><i class="fa fa-eye"></i></a>
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

<!-- DataTables -->
<script src="<?php echo base_url(); ?>public/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>public/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script>
  $(function () {
    $("#example1").DataTable();
  });
</script> 
<script>
$("#view_users").addClass('active');
</script>        
