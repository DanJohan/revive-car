<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Change Services price</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body my-form-body">
           
       <form id="change_service_price" class="form-horizontal" method="post" action="<?php echo base_url().'admin/service/change_service_price'; ?>" > 
              <div class="form-group">
                <label for="service_type" class="col-sm-3 control-label">Select service type</label>

                <div class="col-sm-8">
                  <select name="service_type" class="form-control" required>
                  	<option value="">Please select</option>
                    <?php foreach($service_categories as $service_category):?>
                      <option value="<?= $service_category['id']; ?>" ><?= $service_category['name']; ?></option>
                    <?php endforeach; ?> 
                  </select>
                   <div class="form-error"></div>
                </div>
              </div>
             
             <div class="form-group">
               <label for="car_type" class="col-sm-3 control-label">Car Type</label>
             
               <div class="col-sm-8">
                 <select name="car_type" id="car_type" class="form-control">
                 	<option value="">Please select</option>
                 	<?php
                 		foreach ($car_types as $index => $car_type) {
                 	?>
                 		<option value="<?php echo $car_type['id']; ?>" ><?php echo $car_type['name']; ?></option>
                 	<?php
                 		}
                 	?>
                 
                 </select>
                  <div class="form-error"></div>
               </div>
             </div> 

             <div class="form-group">
                <label for="firstname" class="col-sm-3 control-label">Price</label>

                <div class="col-sm-8">
                	<div class="input-group">
                		<span class="input-group-addon">₹</span>
                  		<input type="text" name="service_price" class="form-control price-field" placeholder="0.00" required>
                  	</div>
                  <div class="form-error"></div>
                </div>
              </div>
            
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
<?php $this->widget->beginBlock('scripts'); ?>
<script type="text/javascript" src="<?php echo base_url() ?>public/dist/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/dist/js/jquery.number.min.js"></script>
<script type="text/javascript">
  $('.price-field').number(true,2);

     $("#change_service_price").validate({
      	errorClass: "error",
      	errorPlacement: function(error, element) {
			error.appendTo(element.parents('.form-group').find('.form-error'));
		},
	     rules: {
	        service_type:{
	          required:true
	        },
	        car_type: {
	          required: true,
	        },
	        service_price: {
	          required: true,
	          number: true
	        }
	     }
   });
</script>
<?php $this->widget->endBlock(); ?>
