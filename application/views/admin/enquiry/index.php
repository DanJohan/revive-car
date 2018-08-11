 <section class="content">
    <?php 
     $this->load->view('common/flashmessage'); 
    ?>
   <div class="box">
    <div class="box-header">
      <h3 class="box-title">Customer enquiry</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
      <table id="example1" class="table table-bordered table-striped ">
        <thead>
        <tr>
          <th>enquiry_id</th>
          <th>user_id</th>
          <th>Username</th>
          <th>Car-Model</th>
          <th>Loaner vehicle</th>
          <th>Enquiry</th>
          <th>Status</th>
          <th>Created At</th>
          <th style="width: 150px;" class="text-right">Actions</th>
        </tr>
        </thead>
        <tbody>
          <?php 
            if(!empty($enquiries)) {
              foreach ($enquiries as $index => $enquiry) {
          ?>
            <tr style="<?php //echo ($enquiry['confirmed'])?'background-color: lightgreen':''; ?>">
                <td><?php echo $enquiry['id']; ?></td>
                <td><?php echo $enquiry['user_id']; ?></td>
                <td><?php echo $enquiry['name']; ?></td>
                <td><?php echo $enquiry['brand_name']."-".$enquiry['model_name']; ?></td>
                <td><?php echo ($enquiry['loaner_vehicle'])? 'Required' : 'Not required'; ?></td>
                <td><?php echo $enquiry['enquiry']; ?></td>
                <td><?php echo ($enquiry['confirmed']) ? '<span class="label label-success">Confirmed</span>':'<span class="label label-warning">Pending</span>'?></td>
                <td><?php echo date('d M Y h:i A',strtotime($enquiry['created_at'])); ?></td>
                <td>
                  <a class="btn btn-success" data-toggle="tooltip" href="<?php echo base_url('admin/enquiry/show/'.$enquiry['id']); ?>" data-original-title="View"><i class="fa fa-eye"></i></a>
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

<script>
  $(function () {
    $("#example1").DataTable({
      'order':[[0,'desc']],
      "columnDefs": [
            {
                "targets": [0],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [1],
                "visible": false,
                "searchable": true
            }
        ]
    });
  });
</script> 
<script>
$("#view_users").addClass('active');
</script>        
