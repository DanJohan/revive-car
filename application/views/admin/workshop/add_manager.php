<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Add New Manager</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body my-form-body">
          <?php if(isset($msg)): ?> 
              <div class="alert alert-warning alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                  
                  <?= isset($msg)? $msg: ''; ?>
              </div>
            <?php endif; ?>
           
           <form method="post" action="<?php echo base_url() . 'admin/workshop/insert_manager'; ?>" enctype="multipart/form-data">
              <div class="form-group">
                <label for="managername" class="col-sm-3 control-label">Manager Name</label>

                <div class="col-sm-8">
                  <input type="text" name="m_name" class="form-control" pattern="[A-Za-z]+" title="only letters" required>
                </div> 
              </div>
              <br></br><br>

              <div class="form-group">
                <label for="email" class="col-sm-3 control-label">Email</label>

                <div class="col-sm-8">
                  <input type="email" name="m_email" class="form-control" id="email" pattern="[^@\s]+@[^@\s]+\.[^@\s]+" title="Invalid email address" required>
                </div>
              </div>
              <br></br>
               <div class="form-group">
                <label for="password" class="col-sm-3 control-label">Password</label>

                <div class="col-sm-8">
                  <input type="password" name="m_password" class="form-control" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,20}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or not more then 20 characters" required>
                </div>
              </div>
              <br></br>
              <div class="form-group">
                <label for="mobile_no" class="col-sm-3 control-label">Mobile No</label>

                <div class="col-sm-8">
                  <div class="input-group">
                      <span class="input-group-addon">+ 91</span>
                      <input type="text" name="m_phone" class="form-control" id="mobile_no" pattern="[789][0-9]{9}" title="Enter valid number" required>
                  </div>
                </div>
              </div>
              <br></br>
               <div class="form-group">
                <label for="password" class="col-sm-3 control-label">Complete Address</label>

                <div class="col-sm-8">
                  <textarea type="text" name="m_address" class="form-control" id="password" required></textarea>
                </div>
              </div>
              <br></br><br>
              <div class="form-group">
                <label for="role" class="col-sm-3 control-label">Workshop Location</label>

                <div class="col-sm-8">
                  <select name="m_workshop_location" class="form-control" title="select any option" required>
                    <option value="location not selected">Select Location</option>
                    <option value="Delhi">Delhi</option>
                    <option value="Gurugram">Gurugram</option>
                    <option value="Noida">Noida</option>
                    <option value="Gaziabad">Gaziabad</option>
                  </select>
                </div>
              </div>
             <br></br>
               <div class="form-group">
                <label for="password" class="col-sm-3 control-label">ID Proof</label>

                <div class="col-sm-8">
                  <input type="text" name="m_id_proof" class="form-control" id="password" placeholder="Adharcard/Pancard.." required>
                </div>
              </div>
              <br></br>
               <div class="form-group">
                <label for="exampleInputFile" class="col-sm-3 control-label">Upload Photo</label>
                   <div class="col-sm-8">
                      <input type="file" id="exampleInputFile" name="m_photo" class="form-control">
                  </div>
              </div>
              <br></br>
              <div class="form-group">
                <div class="col-md-11">
                  <input type="submit" name="submit" value="Add User" class="btn btn-info pull-right">
                </div>
              </div>
            </div>
          </div>
          <!-- /.box-body -->
      </div>
    </div>
  </div>  

</section> 
