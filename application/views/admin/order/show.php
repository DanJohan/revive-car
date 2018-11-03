
 <section class="content">
	 <div class="box">
		<div class="box-header">
			<h3 class="box-title">Order</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
			<div class="panel-group">
				<div class="panel panel-info">
					<div class="panel-heading">Order detail</div>
				   	<div class="panel-body">
				   		<div class="row">
				   			<div class="col-xs-12">
				   				<div class="row row-pb-5">
				   					<div class="col-xs-3">Order No</div>
				   					<div class="col-xs-3">#<?php echo $order['order_no']; ?></div>
				   				</div>
				   				<div class="row row-pb-5">
				   					<div class="col-xs-3">Service</div>
				   					<div class="col-xs-3"><?php echo $order['service_type']; ?></div>
				   				</div>
				   				<div class="row row-pb-5">
				   					<div class="col-xs-3">Service center</div>
				   					<div class="col-xs-3"><?php echo $order['service_center']; ?></div>
				   				</div>
				   				<div class="row row-pb-5">
				   					<div class="col-xs-3">Loaner vehicle</div>
				   					<div class="col-xs-3"><?php echo ($order['loaner_vehicle']) ? 'Required' : 'Not required' ; ?></div>
				   				</div>
				   				<div class="row row-pb-5">
				   					<div class="col-xs-3">Pick up date</div>
				   					<div class="col-xs-3"><?php echo date('dS M Y',strtotime($order['pick_up_date'])); ?></div>
				   				</div>
				   				<div class="row row-pb-5">
				   					<div class="col-xs-3">Pick up time</div>
				   					<div class="col-xs-3"><?php echo $order['pick_up_time']; ?></div>
				   				</div> 
				   				<div class="row row-pb-5">
				   					<div class="col-xs-3">Sub total</div>
				   					<div class="col-xs-3"><?php echo $order['sub_total']; ?></div>
				   				</div>
				   				<div class="row row-pb-5">
				   					<div class="col-xs-3">Discount Amount</div>
				   					<div class="col-xs-3"><?php echo $order['discount_amount']; ?></div>
				   				</div>
				   				<div class="row row-pb-5">
				   					<div class="col-xs-3">Total amount</div>
				   					<div class="col-xs-3"><?php echo $order['net_pay_amount']; ?></div>
				   				</div>
				   				<div class="row row-pb-5">
				   					<div class="col-xs-3">Payment</div>
				   					<div class="col-xs-3"><?php echo ($order['paid']) ? 'Paid' : 'Not Paid'; ?></div>
				   				</div>
				   				<div class="row row-pb-5">
				   					<div class="col-xs-3">Payment type</div>
				   					<div class="col-xs-3"><?php echo $order['payment_type']; ?></div>
				   				</div>
				   				<div class="row row-pb-5">
				   					<div class="col-xs-3">Created_at</div>
				   					<div class="col-xs-3"><?php echo date('dS M Y H:i:s',strtotime($order['created_at'])); ?></div>
				   				</div>
				   			</div>
				   		</div>
				   	</div>
				</div>
				<div class="panel panel-info">
					<div class="panel-heading">Customer deatail</div>
				    <div class="panel-body">
						<div class="row">
				   			<div class="col-xs-12">
				   				<div class="row row-pb-5">
				   					<div class="col-xs-3">Customer name</div>
				   					<div class="col-xs-3"><?php echo $order['customer_name']; ?></div>
				   				</div>
				   				<div class="row row-pb-5">
				   					<div class="col-xs-3">Customer email</div>
				   					<div class="col-xs-3"><?php echo $order['customer_email']; ?></div>
				   				</div>
				   				<div class="row row-pb-5">
				   					<div class="col-xs-3">Customer phone</div>
				   					<div class="col-xs-3"><?php echo $order['customer_phone']; ?></div>
				   				</div>
				   				<div class="row row-pb-5">
				   					<div class="col-xs-3">Customer address</div>
				   					<div class="col-xs-3"><?php echo $order['customer_address']; ?></div>
				   				</div>
				   			</div>
				   		</div>
				    </div>
				</div>
				<div class="panel panel-info">
					<div class="panel-heading">Car deatail</div>
				    <div class="panel-body">
						<div class="row">
				   			<div class="col-xs-12">
				   				<div class="row row-pb-5">
				   					<div class="col-xs-3">Brand name</div>
				   					<div class="col-xs-3"><?php echo $order['brand_name']; ?></div>
				   				</div>
				   				<div class="row row-pb-5">
				   					<div class="col-xs-3">Model name</div>
				   					<div class="col-xs-3"><?php echo $order['model_name']; ?></div>
				   				</div>
				   				<div class="row row-pb-5">
				   					<div class="col-xs-3">Registration no</div>
				   					<div class="col-xs-3"><?php echo $order['registration_no']; ?></div>
				   				</div>
				   			</div>
				   		</div>
				    </div>
				</div>
				<div class="panel panel-info">
					<div class="panel-heading">Order service</div>
				    	<div class="panel-body">
				    		<div class="table-responsive">
				    			<table class="table table-bordered">
				    				<tr>
				    					<td>S. No</td>
				    					<td>Service Name</td>
				    					<td>Price</td>
				    				</tr>
				    				<?php
				    					foreach ($order['order_item'] as $index => $order_item) {
				    				?>
				    					<tr>
				    						<td><?php echo ($index+1); ?></td>
				    						<td><?php echo $order_item['service_name']; ?></td>
				    						<td><?php echo $order_item['price']; ?></td>
				    					</tr>
				    				<?php
				    					}
				    				?>
				    			</table>
				    		</div>
				    </div>
				</div>
				<div class="panel panel-info">
					<div class="panel-heading">Car images</div>
				    	<div class="panel-body">
						<div class="row">
				   			<?php 
				   				if(count($order['order_car_images'])){
				   				foreach ($order['order_car_images'] as $index => $car_image) {
				   			?>
				   				<div class="col-md-4">
			                            	<div class="image-responsive">
			                                	<img class="img-thumbnail" src="<?php echo base_url().'uploads/app/'.$car_image; ?>" style="height:200px;width:100%;" />
			                            	</div>
			                         </div>
				   			<?php
				   			     if(($index+1) % 3 == 0) {
			                            echo "</div><div class='row'>";
			                            }
			                         }
			                      }else{
			                         echo "<div class='text-center text-bold'>No image found</div>";
			                      }
				   			?>
				   		</div>
				    	</div>
				</div>

				</div>
			</div>
		</div>
	</div>
</section>  

		 
