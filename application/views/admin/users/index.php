
 <section class="content">
   <div class="box">
    <div class="box-header">
      <h3 class="box-title">Registered Customers</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
      <table id="example1" class="table table-bordered table-striped ">
        <thead>
        <tr>
          <th>User id</th>
          <th>Username</th>
          <th>Email</th>
          <th>Mobile No.</th>
         <!--  <th>Device</th> -->
          <th>Created At</th>
          <th style="width: 150px;" class="text-right">Option</th>
        </tr>
        </thead>
        <tbody>
          <?php foreach($all_users as $user){ ?>
          <tr>
            <td><?php echo $user['id']; ?></td>
            <td><?php echo $user['name']; ?></td>
            <td><?php echo $user['email']; ?></td>
            <td><?php echo $user['phone']; ?></td>
            <td><?php echo date('d M Y h:i A',strtotime($user['created_at'])); ?></td>
           <td class="text-right">

           	<div class="dropdown">
	                <button class="btn btn-primary dropdown-toggle" type="button" id="menu1" data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></button>
	                <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
	                    <li><a href="<?= base_url('admin/users/show/'.$user['id']); ?>">View</a></li>
	                    <li><a href="<?= base_url('admin/users/edit/'.$user['id']); ?>">Edit</a></li>
	                    <li><a href="<?= base_url('admin/users/del/'.$user['id']); ?>" onclick="return confirm('Are you sure to delete this record?')">Delete</a></li>
	                </ul>
            	</div>
            
            </td>
          </tr>
          <?php } ?>
        </tbody>
       
      </table>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
</section>
<?php $this->load->view('common/modal'); ?>
<?php $this->widget->beginBlock('scripts')?>
<script>
  $(function () {
    $("#example1").DataTable({
      'order':[[0,'desc']]
    });
  });
</script> 
<?php $this->widget->endBlock(); ?>
     
