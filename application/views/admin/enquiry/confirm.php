<section class="content">
   <div class="box">
    <div class="box-header">
      <h3 class="box-title">Customer enquiry</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <form action="<?php ?>">
        <table class="table">
          <?php if($enquiry['loaner_vehicle']) { ?>
            <tr>
                <td><b>Assign driver</b></td>
                <td>
                    <select class="form-control">
                        <option>Please select</option>
                        <?php
                          if(!empty($drivers)) {
                            foreach ($drivers as $index => $driver) {
                        ?>
                          <option value="<?php echo $driver['d_id']; ?>"><?php echo $driver['d_name']; ?></option>
                        <?php
                            }
                          }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
              <td><b>Loaner vechicle cost</b></td>
              <td><input type="text" class="form-control" name="loaner_vehicle_cost" /></td>
          </tr>
          <?php } ?>
          <tr>
              <td><b>Estimated cost</b></td>
              <td><input type="text" class="form-control" name="estimated_cost" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><button type="submit" class="btn btn-primary">Confirm</button></td>
          </tr>
        </table>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
</section>  

      
