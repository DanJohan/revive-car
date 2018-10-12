<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Add Coupan for service</h3>
				</div>
				<!-- /.box-header -->
				<!-- form start -->
				<div class="box-body my-form-body">
					 
							<form id="add-service" class="form-horizontal" method="post" action="<?php echo base_url() . 'admin/service/save_coupan'; ?>"> 
								<div class="form-group">
								<label for="firstname" class="col-sm-3 control-label">Service Name</label>

								<div class="col-sm-8">
									<input type="hidden" name="service_id" value="<?php echo $service['id']; ?>">
									<input type="text" class="form-control" value="<?php echo $service['name']; ?>" readonly="">
								</div>
							</div>
							<div class="form-group">
								<label for="firstname" class="col-sm-3 control-label">Coupan code</label>

								<div class="col-sm-8">
									<input type="text" name="coupan_code" class="form-control">
								</div>
							</div>

						 <div class="form-group">
								<label for="firstname" class="col-sm-3 control-label">Coupan price</label>

								<div class="col-sm-8">
									<div class="input-group"><span class="input-group-addon">&#x20b9;</span><input type="text" class="form-control price-field" name="coupan_price" placeholder ="0.00" /></div>
								</div>
							</div>
							 <div class="form-group">
								<label for="firstname" class="col-sm-3 control-label">Expire date</label>

								<div class="col-sm-8">
									<input type="datetime-local" name="expire_at" class="form-control" name="price"  />
								</div>
							</div>

						 
							<br><br></br>
							<div class="form-group">
								<div class="col-md-11">
									<input type="submit" name="submit" value="Submit" class="btn btn-info pull-right">
								</div>
							</div>
						</form>
					</div>
					<!-- /.box-body -->
			</div>
		</div>
	</div>  

</section>
<script src="<?php echo base_url() ?>public/dist/js/jquery.validate.min.js"></script>
<script type="text/javascript">
	 $(document).ready(function(){
		 $('.price-field').number(true,2);

		 $(document).on('change','#brand',function(){
			 var brand_id = $(this).val();
			 $('#model_id').html('<option value="">Please select</option>')
				$.ajax({
					url:config.baseUrl+"admin/car/getCarModels",
					method:"POST",
					data:{'brand_id':brand_id},
					success:function(response){
						 if(response.status){
								$('#model_id').html(response.template);
						 }
					}
				});

		 });

		$("#add-service").validate({
			errorClass: "error",
			rules: {
				expire_at:{
					required:true
				},
				coupan_code: {
					required: true,
				},
				coupan_price: {
					required: true,
					number: true
				},
				service:{
					required:true
				}
		}
	 });
	});// end of ready function
</script>
 

