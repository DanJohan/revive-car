<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Add New Driver</h3>
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
           
             <form method="post" action="<?php echo base_url() . 'admin/driver/edit_driver/'.$driver['id']; ?>"> 
              <div class="form-group">
                <label for="firstname" class="col-sm-3 control-label">Driver Name</label>

                <div class="col-sm-8">
                  <input type="text" name="d_name" class="form-control" value="<?= $driver['d_name']; ?>" id="firstname" pattern="[A-Za-z]+" title="only letters" required>
                </div>
              </div>
              <br><br></br>
              <div class="form-group">
                <label for="email" class="col-sm-3 control-label">Email</label>

                <div class="col-sm-8">
                  <input type="email" name="d_email" class="form-control" value="<?= $driver['d_email']; ?>" id="email"  pattern="[^@\s]+@[^@\s]+\.[^@\s]+" title="Enter valid number" required>
                </div>
              </div>
              <br></br>
              <div class="form-group">
                <label for="mobile_no" class="col-sm-3 control-label">Mobile No</label>

                <div class="col-sm-8">
                  <input type="number" name="d_phone" class="form-control" value="<?= $driver['d_phone']; ?>" id="mobile_no" pattern="[789][0-9]{9}" title="Enter valid number" required>
                </div>
              </div>
              <br></br>
              <div class="form-group">
                <label for="password" class="col-sm-3 control-label">Complete Address</label>

                <div class="col-sm-8">
                  <textarea type="text" name="d_address" class="form-control" id="password" required><?= $driver['d_address']; ?></textarea>
                </div>
              </div>
              <br><br></br>
               <div class="form-group">
                <label for="password" class="col-sm-3 control-label">ID Proof</label>

                <div class="col-sm-8">
                  <input type="text" name="d_idproof" class="form-control" value="<?= $driver['d_idproof']; ?>" id="password" placeholder="Adharcard/Pancard/License.." required>
                </div>
              </div>
              <br></br>
               <div class="form-group">
                <label for="exampleInputFile" class="col-sm-3 control-label">Upload Photo</label>
                   <div class="col-sm-8">
                      <input type="file" id="exampleInputFile" name="d_photo" class="form-control">
                  </div>
              </div>
              <br><br></br>
              <div class="form-group">
                <div class="col-md-11">
                  <input type="submit" name="submit" value="Update Driver" class="btn btn-info pull-right">
                </div>
              </div>
            </form>
          </div>
          <!-- /.box-body -->
      </div>
    </div>
  </div>  

</section> 
