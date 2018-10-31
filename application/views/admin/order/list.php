
 <section class="content">
	 <div class="box">
		<div class="box-header">
			<h3 class="box-title">Orders</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body table-responsive">
			<table id="example1" class="table table-bordered table-striped dataTable">
				<thead>
				<tr>
					<th style="width: 10%;">Order no</th>
					<th style="width: 10%;">Pick up date</th>
					<th style="width: 5%;">Pick up time</th>
					<th style="width: 5%;">Amount</th>
					<th style="width: 10%;">Paid</th>
					<th style="width: 20%;">Status</th>
					<th style="width: 15%;">Created at</th>
					<th>Option</th>
				</tr>
				</thead>
				<tbody>
				 <?php 
					if(count($orders)) {
					foreach($orders as $order){ 
				?>
					<tr>
						<td><?php echo $order['order_no']; ?></td>
						<td><?php echo date('dS M Y', strtotime($order['pick_up_date'])); ?></td>
						<td><?php echo $order['pick_up_time']; ?></td>
						<td><?php echo $order['net_pay_amount']; ?></td>
						<td><?php echo ($order['paid']) ? '<span class="label label-success">Paid</span>' : '<span class="label label-danger">Not Paid</span>' ; ?>
							
						</td>
						<td><?php echo ($order['status']) ? '<span class="label label-success">Confirmed</span>' : '<span class="label label-danger">Not Confirmed</span>' ; ?>
							
						</td>
						<td><?php echo date('dS M Y h:i A',strtotime($order['created_at'])); ?></td>
						<td class="text-right">
							<div class="dropdown">
					                <button class="btn btn-primary dropdown-toggle" type="button" id="menu1" data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></button>
					                <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
					                    <li><a href="<?php echo base_url('admin/order/show/'.$order['id']); ?> ">View</a></li>
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
	</div>
</section>  
<?php $this->load->view('common/modal'); ?>
<?php $this->widget->beginBlock('scripts'); ?>
<script type="text/javascript">
	$(function () {
		$("#example1").DataTable({
			'order':[[0,'desc']]
		});
	});
</script> 
<?php $this->widget->endBlock(); ?>
		 
