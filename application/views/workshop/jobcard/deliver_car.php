	 <section class="content">
	 	<div class="box">
	 		<div class="box-header bg-green">
	 			<h3 class="box-title">Deliver Car</h3>
	 		</div>
	 		<!-- /.box-header -->
	 		<div class="box-body">
	 			<form id="car-delivery" class="form-horizontal" action="<?php echo base_url()."workshop/jobCard/save_ride"?>" method="post">
	 				<input type="hidden" name="job_card_id" value="<?php echo $job_card['id']; ?>">
	 				<div class="form-group">
	 					<label class="control-label col-sm-2" for="pwd">Customer Name:</label>
	 					<div class="col-sm-6"> 
	 						<input type="text" class="form-control" id="c_name" name="c_name" value="<?php echo $job_card['name']; ?>">
	 					</div>
	 				</div>
	 				<div class="form-group">
	 					<label class="control-label col-sm-2" for="pwd">Customer Phone:</label>
	 					<div class="col-sm-6"> 
	 						<div class="input-group">
				                    <span class="input-group-addon">+ 91</span>
				                    <input type="text" class="form-control" id="c_phone" name="c_phone" value="<?php echo ($job_card['phone']) ? substr($job_card['phone'],-10):''; ?>">
				               </div>
	 						
	 					</div>
	 				</div>
	 				<div class="form-group">
	 					<label class="control-label col-sm-2" for="pwd">Customer Address:</label>
	 					<div class="col-sm-6"> 
	 						<textarea style="resize: none;" class="form-control" rows="5" id="c_address" name="c_address"><?php echo $job_card['address']; ?></textarea>
	 					</div>
	 				</div>
	 				<div class="form-group">
	 					<label class="control-label col-sm-2" for="email">Assign driver:</label>
	 					<div class="col-sm-6">
	 						<select  class="form-control" id="drivers" name="driver">
	 								<option value="">Please select</option>
	 								<?php
	 									 if(!empty($drivers)){
	 									 		foreach ($drivers as $index => $driver) {
	 								?>
	 									<option value="<?php echo $driver['id']; ?>"><?php echo $driver['d_name']; ?></option>
	 								<?php	 				
	 									 		}
	 									 }
	 								?>
	 						</select>
	 					</div>
	 				</div>
	 				<div class="form-group">
	 					<label class="control-label col-sm-2" for="pwd">Delivery Date:</label>
	 					<div class="col-sm-6"> 
	 						<input type="date" class="form-control" id="deliver_date" name="deliver_date">
	 					</div>
	 				</div>
	 				<div class="form-group">
	 					<label class="control-label col-sm-2" for="pwd">Delivery Time:</label>
	 					<div class="col-sm-6"> 
	 						<input type="time" class="form-control" id="deliver_time" name="deliver_time">
	 					</div>
	 				</div>

	 				<div class="form-group"> 
	 					<div class="col-sm-offset-2 col-sm-10">
	 						<button type="submit" class="btn btn-success"name="submit" value="save">Submit</button>
	 					</div>
	 				</div>
	 			</form>
	 		</div>
	 		<!-- /.box-body -->
	 	</div>
	 	<!-- /.box -->
</section>
<script src="<?php echo base_url() ?>public/dist/js/jquery.validate.min.js"></script>
<script type="text/javascript">
	$("#car-delivery").validate({
      errorClass: "error",
      rules: {
        c_name:{
          required:true
        },
        c_phone: {
          required: true
        },
        c_address: {
          required: true
        },
        deliver_date: {
          required: true
        },
        deliver_time: {
          required: true
        },
        driver: {
          required: true,

        }
      }
    });
</script> 
