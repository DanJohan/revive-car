<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Add New Car Brand</h3>
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
           
             <form method="post" action="<?php echo base_url() . 'admin/car/insert_carbrand'; ?>"> 
              <div class="form-group">
                <label for="firstname" class="col-sm-3 control-label">Car Brand Name</label>

                <div class="col-sm-8">
                  <input type="text" name="brand_name" class="form-control" required>
                </div>
              </div>
             
              <br><br></br>
              <div class="form-group">
                <div class="col-md-11">
                  <input type="submit" name="submit" value="Add Car Brand" class="btn btn-info pull-right">
                </div>
              </div>
            </form>
          </div>
          <!-- /.box-body -->
      </div>
    </div>
  </div>  

</section> 

<section class="content">
   <div class="box">
    <div class="box-header">
      <h3 class="box-title">Added Car Brands</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
      <table id="example1" class="table table-bordered table-striped ">
        <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Updated At</th>
          <th style="width: 150px;" class="text-right">Option</th>
        </tr>
        </thead>
        <tbody>
          
          <?php foreach($all_carbrand as $row):?>
      
          <tr>
            <td><?= $row['id']; ?></td>
            <td><?= $row['brand_name']; ?></td>
            <td><?= date('d M Y h:i A',strtotime($row['created_at'])); ?></td>
            
            <td class="text-right">
             <a class="btn btn-danger" onclick="return confirm('Are you sure to delete this record?')" data-toggle="tooltip" href="<?= base_url('admin/car/del_carbrand/'.$row['id']); ?>" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>
            </tr>
          <?php endforeach; ?>
        </tbody>
       
      </table>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
</section>
<?php $this->widget->beginBlock('scripts')?>
<script>
  $(function () {
    $("#example1").DataTable({
      'order':[[0,'desc']]
    });
  });
</script> 
<?php $this->widget->endBlock(); ?>
