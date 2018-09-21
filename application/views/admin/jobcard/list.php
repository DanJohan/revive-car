 <section class="content">
   <div class="box">
    <div class="box-header">
      <h3 class="box-title">Customer job cards</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
      <table id="example1" class="table table-bordered table-striped ">
        <thead>
        <tr>
          <th>Job card id</th>
          <th>User id</th>
          <th>Customer name</th>
          <th>Phone</th>
          <th>Car</th>
          <th>Registration no.</th>
          <th>Created At</th>
          <th style="width: 150px;" class="text-right">Option</th>
        </tr>
        </thead>
        <tbody>
          
          <?php 
          if(!empty($jobs)) {
            foreach($jobs as $index=>$job) {
          ?>
      
          <tr>
            <td><?php echo $job['id']; ?></td>
            <td><?php echo $job['user_id']; ?></td>
            <td><?php echo $job['name']; ?></td>
            <td><?php echo $job['phone']; ?></td>
            <td><?php echo $job['brand_name']." - ".$job['model_name']; ?></td>
            <td><?php echo $job['registration_no']; ?></td>
            <td><?php echo date('d M Y h:i A',strtotime($job['created_at'])); ?></td>

         
            <td class="text-right">
              <a data-toggle="modal" class="btn btn-success" data-toggle="tooltip" href="<?php echo  base_url('admin/jobCard/show/'.$job['id']); ?>" data-original-title="View"><i class="fa fa-eye"></i></a>
            
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
                "visible": true,
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

      
