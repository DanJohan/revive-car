<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Add Car Services</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body my-form-body">
          <?php if(isset($msg)):?>
              <div class="alert alert-warning alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                 <?= isset($msg)? $msg: ''; ?>
              </div>
            <?php endif; ?>
           
              <form class="form-horizontal" method="post" action="<?php echo base_url() . 'admin/car/insert_carservice'; ?>"> 
              <div class="form-group">
                <label for="firstname" class="col-sm-3 control-label">Select Car Model Name</label>

                <div class="col-sm-8">
                  <select name="brand_id" class="form-control" required>
                    <?php foreach($all_carbrand as $row):?>
                      <option value="<?= $row['id']; ?>"><?= $row['brand_name']; ?></option>
                    <?php endforeach; ?> 
                  </select>
                </div>
              </div>

             <div class="form-group">
                <label for="firstname" class="col-sm-3 control-label">Model Name</label>

                <div class="col-sm-8">
                  <select name="brand_id" class="form-control" required>
                    <?php foreach($all_carmodel as $row):?>
                      <option value="<?= $row['id']; ?>"><?= $row['model_name']; ?></option>
                    <?php endforeach; ?> 
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="firstname" class="col-sm-3 control-label">Fuel Type</label>

                <div class="col-sm-8">
                  <select name="fuel_type" class="form-control" required>
                      <option value="1">Petrol</option>
                      <option value="2">CNG</option>
                      <option value="3">Diesel</option>
                  
                  </select>
                </div>
              </div>

               <div class="form-group">
                <label for="firstname" class="col-sm-3 control-label">Price</label>

                <div class="col-sm-8">
                  <div class="input-group"><span class="input-group-addon">&#x20b9;</span><input type="text" class="form-control price-field" name="price" value="0.00"  required="required"/></div>
                </div>
              </div>

              <div class="form-group">
                <label for="firstname" class="col-sm-3 control-label">Service Parts</label>

                <div class="col-sm-8">
                  <select name="fuel_type" class="form-control" required>
                     <?php foreach($all_carservice as $cs):?>
                      <option value="<?= $cs['id']; ?>"><?= $cs['name']; ?></option>
                    <?php endforeach; ?> 
                  </select>
                </div>
              </div>
              <br><br></br>
              <div class="form-group">
                <div class="col-md-11">
                  <input type="submit" name="submit" value="Add Car Model" class="btn btn-info pull-right">
                </div>
              </div>
            </form>
          </div>
          <!-- /.box-body -->
      </div>
    </div>
  </div>  

</section> 
<script type="text/javascript">
   $(document).ready(function(){
     $('.price-field').number(true,2);
  });
</script>
 

