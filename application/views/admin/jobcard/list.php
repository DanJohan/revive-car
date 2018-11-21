 <?php $this->widget->beginBlock('stylesheets'); ?>
<link rel="stylesheet" href="<?= base_url() ?>public/plugins/datatables/dataTables.bootstrap.css">
 <?php $this->widget->endBlock(); ?>
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
              		<div class="dropdown">
			          <button class="btn btn-primary dropdown-toggle" type="button" id="menu1" data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></button>
			                <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
			                    <li><a href="<?php echo base_url(); ?>admin/jobCard/show/<?php echo $job['id']; ?>">View</a></li>
			                </ul>
		          </div>
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
<?php $this->widget->beginBlock('scripts'); ?>
<script type="text/javascript" src="<?php echo base_url(); ?>public/plugins/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/plugins/datatables/dataTables.bootstrap.min.js"></script>
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
<?php $this->widget->endBlock(); ?>

      
