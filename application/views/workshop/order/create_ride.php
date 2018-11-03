
 <section class="content">
	 <div class="box">
		<div class="box-header bg-green">
			<h3 class="box-title">Scheduled ride for driver</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body table-responsive">
			<form id="create_ride" action="<?php echo base_url();?>workshop/order/create_ride/<?php echo $order_id; ?>" method="post" class="form-horizontal col-xs-8">
					<input type="hidden" value="<?php echo $order_id; ?>" name="order_id">
					<div class="form-group">
							<label for="driver" class="col-xs-2 control-label">Drivers</label>
							<div class="col-xs-10">
								<select name="driver" id="driver" class="form-control">
										<option value="">Please select</option>
										<?php
											foreach ($drivers as $index => $driver) {
										?>
												<option value="<?php echo $driver['id']?>"><?php echo $driver['d_name']; ?></option>
										<?php
											}
										?>
								</select>
							</div>
					</div>
					<div class="form-group">
						<label for="" class="col-xs-2 control-label">Ride date</label>
						<div class="col-xs-10">
							<input type="date" class="form-control" name="ride_date"/>
						</div>

					</div>
					<div class="form-group">
						<label for="" class="col-xs-2 control-label">Ride time</label>
						<div class="col-xs-10">
							<input type="time" class="form-control" name="ride_time"/>
						</div>

					</div>
					<div class="form-group">
						<label for="" class="col-xs-2 control-label">Ride type</label>
						<div class="col-xs-10">
							<select name="ride_type" id="" class="form-control">
								<option value="">Please select</option>
								<option value="1">Picup</option>
								<option value="2">Drop</option>
							</select>
						</div>

					</div>
					<div class="form-group">
							<div class="col-xs-offset-2">
								<button type="submit" name="submit" class="btn btn-success" value="submit">Create</button>
							</div>
					</div>
			</form>
		</div>
	</div>
</section>  
<?php $this->load->view('common/modal'); ?>
<?php $this->widget->beginBlock('scripts'); ?>
<script type="text/javascript">

$("#create_ride").validate({
	errorClass: "error",
	rules: {
		driver:{
			required:true
		},
		ride_date: {
			required: true,
		},
		ride_time: {
			required: true,
		},
		ride_type:{
			required:true
		}
	}
});


</script> 
<?php $this->widget->endBlock(); ?>
		 
