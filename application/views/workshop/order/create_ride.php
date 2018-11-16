<?php $this->widget->beginBlock('stylesheets'); ?>
<link rel="stylesheet" href="<?php echo  base_url() ?>public/dist/css/bootstrap-datetimepicker.min.css"> 
<?php $this->widget->endBlock(); ?>
 <section class="content">
	 <div class="box">
		<div class="box-header bg-green">
			<h3 class="box-title">Scheduled ride for driver</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body table-responsive">
			<form id="create_ride" action="<?php echo base_url();?>workshop/order/create_ride/<?php echo $hash; ?>" method="post" class="form-horizontal col-xs-8" autocomplete="off">
					<div class="form-group">
							<label for="driver" class="col-xs-3 control-label">Drivers</label>
							<div class="col-xs-9">
								<div class="form-group">
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
									<div class="form-error"></div>
								</div>
							</div>
					</div>
					<div class="form-group">
						<label for="" class="col-xs-3 control-label">Ride date</label>
						<div class="col-xs-9">
							<!-- <input type="date" class="form-control" name="ride_date"/> -->
							<div class="form-group">
					                <div class='input-group date' id='ridedatepicker'>
					                    <input type='text' class="form-control" name="ride_date" onkeypress="return false;"/>
					                    <span class="input-group-addon">
					                        <span class="glyphicon glyphicon-calendar"></span>
					                    </span>
					                </div>
					                <div class="form-error"></div>
					          </div>
						</div>

					</div>
					<div class="form-group">
						<label for="" class="col-xs-3 control-label">Ride time</label>
						<div class="col-xs-9">
							<!-- <input type="time" class="form-control" name="ride_time"/> -->
							<div class="form-group">
					                <div class='input-group date' id='ridetimepicker' >
					                    <input type='text' class="form-control" name="ride_time" onkeypress="return false;" />
					                    <span class="input-group-addon">
					                        <span class="glyphicon glyphicon-time"></span>
					                    </span>
					                </div>
					                <div class="form-error"></div>
					          </div>
						</div>

					</div>
					<div class="form-group">
						<label for="" class="col-xs-3 control-label">Ride type</label>
						<div class="col-xs-9">
							<div class="form-group">
								<label class="radio-inline"><input type="radio" name="ride_type" value="1">Pickup</label>
								<label class="radio-inline"><input type="radio" name="ride_type" value="2">Delivery</label>
								<div class="form-error"></div>
							</div>
						</div>

					</div>
					<div class="form-group">
						<label for="" class="col-xs-3 control-label">Loaner vehicle</label>
						<div class="col-xs-9">
							<div class="form-group">
								<label class="radio-inline"><input type="radio" class="loaner_vehicle" name="loaner_vehicle" value="1" <?php echo ($order['loaner_vehicle'] ) ? "checked" : ""; ?> >Required</label>
								<label class="radio-inline"><input type="radio" class="loaner_vehicle" name="loaner_vehicle" value="0" <?php echo (!$order['loaner_vehicle'] ) ? "checked" : ""; ?> >Not required</label>
							</div>						</div>

					</div>

					<div class="form-group" id ="lv_reg_no_input">
						<label for="" class="col-xs-3 control-label">Loaner vehicle registration number <span>(optional)</span></label>
						<div class="col-xs-9">
							<div class="form-group">
								<input type="text" name = "lv_reg_no" class="form-control">
							</div>
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
<script type="text/javascript" src="<?php echo base_url(); ?>public/dist/js/moment.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/dist/js/bootstrap-datetimepicker.min.js"></script>

<script type="text/javascript">

$(function () {
     $('#ridedatepicker').datetimepicker({
     	format:'DD/MM/YYYY',
     	minDate:new Date,
     	allowInputToggle:true,
     });
});

$(function () {
	 $('#ridetimepicker').datetimepicker({
	     format: 'LT',
	     minDate:new Date,
	     allowInputToggle:true,
	 });
 });

function toggleLoanerVehicleInput(value) {
 if(value==1){
       $('#lv_reg_no_input').show();
   }else{
     $('#lv_reg_no_input').hide();
   }
}
var loaner_value = $('.loaner_vehicle:checked').val();
toggleLoanerVehicleInput(loaner_value);

$(document).on('change','.loaner_vehicle',function(){
   var loaner_vehicle = $(this).val();
   toggleLoanerVehicleInput(loaner_vehicle);
   
});

$("#create_ride").validate({
	errorClass: "error",
	errorPlacement: function(error, element) {
		error.appendTo(element.parents('.form-group').find('.form-error'));
	},
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
		 
