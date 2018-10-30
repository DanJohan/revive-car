<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Edit car model</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body my-form-body">
           
       <form class="form-horizontal" method="post" action="<?php echo base_url() . 'admin/car/edit_carmodel/'.$model['id']; ?>" enctype="multipart/form-data"> 
              <div class="form-group">
                <label for="firstname" class="col-sm-3 control-label">Select Car Model Name</label>

                <div class="col-sm-8">
                  <select name="brand_id" class="form-control" required>
                  	<option value="">Please select</option>
                    <?php foreach($all_carbrand as $row):?>
                      <option value="<?= $row['id']; ?>" <?= ($row['id'] == $model['brand_id']) ? 'selected' : ''; ?> ><?= $row['brand_name']; ?></option>
                    <?php endforeach; ?> 
                  </select>
                </div>
              </div>

             <div class="form-group">
                <label for="firstname" class="col-sm-3 control-label">Model Name</label>

                <div class="col-sm-8">
                  <input type="text" name="model_name" class="form-control" value="<?php echo $model['model_name']; ?>" required>
                </div>
              </div>
             <div class="form-group">
               <label for="car_type" class="col-sm-3 control-label">Car Type</label>
             
               <div class="col-sm-8">
                 <select name="car_type" id="car_type" class="form-control" required>
                 	<option value="">Please select</option>
                 	<?php
                 		foreach ($car_types as $index => $car_type) {
                 	?>
                 		<option value="<?php echo $car_type['id']; ?>" <?= ($car_type['id'] == $model['car_type']) ? 'selected' : ''; ?>><?php echo $car_type['name']; ?></option>
                 	<?php
                 		}
                 	?>
                 
                 </select>
               </div>
             </div> 
               <div class="form-group">
                <label for="exampleInputFile" class="col-sm-3 control-label">Upload Image</label>
                   <div class="col-sm-8">
                      <input type="file" id="exampleInputFile" name="image" class="form-control">
                  </div>
              </div>
              <div class="form-group">
                <div class="col-md-11">
                  <input type="submit" name="submit" value="Edit" class="btn btn-info pull-right">
                </div>
              </div>
            </form>
          </div>
          <!-- /.box-body -->
      </div>
    </div>
  </div>  

</section> 
