<div class="table-responsive">
	<table class="table ">
		<thead>
			<tr>
				<th>S.No.</th>
				<th>Service Name</th>
				<th>Price</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if(!empty($job_card['order_items'])) {
				$i = 1;
				foreach ($job_card['order_items'] as $index => $order_item) {
					$order_item['status'] =0;
					?>
					<tr>
						<td><?php echo $i; ?></td>
						<td><?php echo $order_item['service_name']; ?></td>
						<td><?php echo $order_item['price']; ?></td>
						<td>
							<?php 
							if($order_item['status']==0){
								echo "<span class='label label-danger'>Pending</span>";
							}elseif($order_item['status']==1){
								echo "<span class='label label-warning'>Processing</span>";
							}elseif($order_item['status']==2){
								echo "<span class='label label-success'>completed</span>";
							}
							?>
						</td>
					</tr>
					<?php
					$i++;
				}
			}
			?>

		</tbody>
		<tfoot>
			<tr>

			</tr>
		</tfoot>
	</table>
</div><!--end of .table-responsive-->
