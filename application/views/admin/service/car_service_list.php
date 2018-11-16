
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
					<!-- <th>Image</th> -->
					<th>Service Name</th>
					<th>Service Category</th>
					<th>Manufacturer Name</th>
					<th>Model Name</th>
					<th>Price</th>
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
						<td><?php echo $service['name']; ?></td>
						<td><?php echo $service['category_name']?></td>
						<td><?php echo $service['brand_name']; ?></td>
						<td><?php echo $service['model_name']; ?></td>
						<td><?php echo number_format($service['price'],2,".",","); ?></td>
						<td><?php echo date('d M Y h:i A',strtotime($service['created_at'])); ?></td>
						<td>
								<div class="dropdown">
	                <button class="btn btn-primary dropdown-toggle" type="button" id="menu1" data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></button>
	                <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
	                    <li><a href="<?php echo base_url('admin/service/change_price/'.$service['id']); ?> ">Change Price</a></li>
	                    <li><a href="<?php echo base_url('admin/service/add_coupan/'.$service['id']); ?> ">Add Coupan</a></li>
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
<?php $this->widget->beginBlock('scripts'); ?>
<script>
	$(function () {
		$("#example1").DataTable({
			'order':[[0,'desc']]
		});
	});
</script> 
<?php $this->widget->endBlock(); ?>
		 