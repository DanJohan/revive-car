<div class="table-responsive">
	<table class="table ">
		<thead>
			<tr>
				<th>Customer Request</th>
				<th>S.A  Remarks</th>
				<th>Parts Name</th>
				<th> Qty</th>
				<th>Parts Price</th>
				<th>Labour Price</th>
				<th>Total Price</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$repair_orders = $job_card['repair_orders'];
//dd($repair_orders);
			if(!empty($repair_orders)) {
				foreach ($repair_orders as $index => $repair_order) {
					?>
					<tr>
						<td><?php echo $repair_order['customer_request']; ?></td>
						<td><?php echo $repair_order['sa_remarks']; ?></td>
						<td><?php echo $repair_order['parts_name']; ?></td>
						<td><?php echo $repair_order['qty']; ?></td>
						<td><?php echo number_format($repair_order['parts_price'],2,'.',','); ?></td>
						<td><?php echo number_format($repair_order['labour_price'],2,'.',','); ?></td>
						<td><?php echo number_format($repair_order['total_price'],2,'.',','); ?></td>
						<td>
							<?php 
							if($repair_order['status']==0){
								echo "<span class='label label-danger'>Pending</span>";
							}elseif($repair_order['status']==1){
								echo "<span class='label label-warning'>Processing</span>";
							}elseif($repair_order['status']==2){
								echo "<span class='label label-success'>completed</span>";
							}
							?>
						</td>
					</tr>
					<?php
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
