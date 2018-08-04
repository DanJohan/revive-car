section class="content">
   <div class="box">
    <div class="box-header">
      <h3 class="box-title">Confirm enquiry</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <form action="<?php echo base_url(); ?>admin/enquiry/save_enquiry_confirm" method="post">
        <input type="hidden" name="enquiry_id" value="<?php echo $enquiry['id']; ?>">
        <table class="table"> 
            <tr>
                <td><b>Assign driver</b></td>
                <td>
                    <select class="form-control" name="driver">
                        <option value="">Please select</option>
                        <?php
                          if(!empty($drivers)) {
                            foreach ($drivers as $index => $driver) {
                        ?>
                          <option value="<?php echo $driver['id']; ?>"><?php echo $driver['d_name']; ?></option>
                        <?php
                            }
                          }
                        ?>
                    </select>
                </td>
            </tr>
          <?php if($enquiry['loaner_vehicle']) { ?>
            <tr>
              <td><b>Loaner vechicle cost</b></td>
              <td>150 / Day <input type="hidden" class="form-control" name="loaner_vehicle_cost" value="150" /></td>
          </tr>
          <?php } ?>
          <tr>
              <td><b>Estimated cost</b></td>
              <td><input type="text" class="form-control" name="estimated_cost"  required="required"/></td>
          </tr>
          <tr>

          <tr>
                <td><b>Assign Manager</b></td>
                <td>
                    <select class="form-control" name="wmanager" required="required">
                        <option value="">Please select</option>
                        <?php
                          if(!empty($wmanagers)) {
                            foreach ($wmanagers as $index => $wmanager) {
                        ?>
                          <option value="<?php echo $wmanager['id']; ?>"><?php echo $wmanager['m_name']; ?></option>
                        <?php
                            }
                          }
                        ?>
                    </select>
                </td>
            </tr>


            <td>&nbsp;</td>
            <td><button type="submit" class="btn btn-primary" name="submit">Submit</button></td>
          </tr>
        </table>
      </form>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
</section>  

      
