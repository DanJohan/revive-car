<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Edit User</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body my-form-body">
          <?php if(isset($msg) || validation_errors() !== ''): ?>
              <div class="alert alert-warning alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                  <?= validation_errors();?>
                  <?= isset($msg)? $msg: ''; ?>
              </div>
            <?php endif; ?>

             <?php
            if(!empty($this->session->flashdata('validation_error'))) {
              echo "<div class='alert alert-danger'>"; 
                echo $this->session->flashdata('validation_error'); 
              echo "</div>"; 
            }
            ?>
           
            <form method="post" action="<?= base_url('admin/users/edit/'.$user['id']); ?>" class="form-horizontal">
              <div class="form-group">
                <label for="firstname" class="col-sm-2 control-label">First Name</label>

                <div class="col-sm-9">
                  <input type="text" name="name" value="<?= $user['name']; ?>" class="form-control" pattern="[A-Za-z\s]+" title="only letters" required>
                </div>
              </div>

              <div class="form-group">
                <label for="email" class="col-sm-2 control-label">Email</label>

                <div class="col-sm-9">
                  <input type="email" name="email" value="<?= $user['email']; ?>" class="form-control" pattern="[^@\s]+@[^@\s]+\.[^@\s]+" title="Invalid email address" required>
                </div>
              </div>
              <div class="form-group">
                <label for="mobile_no" class="col-sm-2 control-label">Mobile No</label>

                <div class="col-sm-9">
                  <div class="input-group">
                      <span class="input-group-addon">+ 91</span>
                      <input type="text" name="phone" value="<?= $user['phone']; ?>" class="form-control" pattern="[789][0-9]{9}" title="Enter valid number" required>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-11">
                  <input type="submit" name="submit" value="Update User" class="btn btn-info pull-right">
                </div>
              </div>
            </form>
          </div>
          <!-- /.box-body -->
      </div>
    </div>
  </div>  

</section> 