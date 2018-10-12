
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
					<th>Service id</th>
					<th>Image</th>
					<th>Name</th>
					<th>Category</th>
					<th>Created At</th>
					<th>Option</th>
				</tr>
				</thead>
				<tbody>
					<?php 
					if(!empty($services)) {
					foreach($services as $service){ 
					?>
					<tr>
						<td><?php echo $service['id']; ?></td>
						<td><img src="<?php echo base_url().'public/images/admin/car/'.$service['image']; ?>" style="width:100px;height: 100px;"/></td>
						<td><?php echo $service['name']; ?></td>
						<td><?php echo $service['category']; ?></td>
						<td><?php echo date('d M Y h:i A',strtotime($service['created_at'])); ?></td>
						<td>
								<div class="dropdown">
	                <button class="btn btn-success dropdown-toggle" type="button" id="menu1" data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></button>
	                <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
	                    <li><a href="<?php echo base_url('admin/service/add_carservice/'.$service['id']); ?> ">Add cars</a></li>
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
<?php $this->load->view('common/modal'); ?>
<script>
	$(function () {
		$("#example1").DataTable({
			'order':[[0,'desc']]
		});
	});
</script> 
		 
