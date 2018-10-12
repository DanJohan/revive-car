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
           
              <form id="add-service" class="form-horizontal" method="post" action="<?php echo base_url() . 'admin/service/insert_carservice'; ?>"> 
              <div class="form-group">
                <label for="firstname" class="col-sm-3 control-label">Manufacturer Name</label>

                <div class="col-sm-8">
                  <select name="brand_id" id="brand" class="form-control">
                    <option value="">Please select</option>
                    <?php foreach($all_carbrand as $row):?>
                      <option value="<?= $row['id']; ?>"><?= $row['brand_name']; ?></option>
                    <?php endforeach; ?> 
                  </select>
                </div>
              </div>

             <div class="form-group">
                <label for="firstname" class="col-sm-3 control-label">Model Name</label>

                <div class="col-sm-8">
                  <select name="model_id" id="model_id" class="form-control">
                   <!--  <?php foreach($all_carmodel as $mn):?>
                      <option value="<?= $mn['brand_id']; ?>"><?= $mn['model_name']; ?></option>
                    <?php endforeach; ?>  -->
                  </select>
                </div>
              </div>

               <div class="form-group">
                <label for="firstname" class="col-sm-3 control-label">Services</label>

                <div class="col-sm-8">
                  <select name="service" class="form-control">
                     <?php foreach($all_carservice as $cs):?>
                      <option value="<?= $cs['id']; ?>"><?= $cs['name']; ?></option>
                    <?php endforeach; ?> 
                  </select>
                </div>
              </div>

               <div class="form-group">
                <label for="firstname" class="col-sm-3 control-label">Price</label>

                <div class="col-sm-8">
                  <div class="input-group"><span class="input-group-addon">&#x20b9;</span><input type="text" class="form-control price-field" name="price" placeholder ="0.00" /></div>
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
        brand_id:{
          required:true
        },
        model_id: {
          required: true,
        },
        price: {
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
 

