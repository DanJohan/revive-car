<div class="modal-header admin-header">
  <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
  <h3 class="modal-title">Confirm Enquiry</h3>
</div>
<div class="modal-body model_view admin-body" align="center">&nbsp;
        <form action="<?php echo base_url(); ?>admin/enquiry/save_enquiry_confirm" method="post">
        <input type="hidden" name="enquiry_id" value="<?php echo $enquiry['id']; ?>">
        <table class="table"> 

           <tr>
                <td><b>Assign Manager</b></td>
                <td>
                    <select class="form-control" name="wmanager" id="wmanager" required="required">
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


            <tr>
                <td><b>Assign driver</b></td>
                <td>
                    <select class="form-control" name="driver" id="driver_id">
                        <option value="">Please select</option>
                    </select>
                </td>
            </tr>
          <?php if($enquiry['loaner_vehicle']) { ?>
            <tr>
              <td><b>Loaner vechicle cost/Day</b></td>
              <td><input type="text" class="form-control" name="loaner_vehicle_cost" value=""  required="" /></td>
          </tr>
          <?php } ?>
          <tr>
              <td><b>Estimated cost</b></td>
              <td><input type="text" class="form-control" name="estimated_cost"  required="required"/></td>
          </tr>
          <tr>

         

            <td>&nbsp;</td>
            <td><button type="submit" class="btn btn-primary" name="submit">Submit</button></td>
          </tr>
        </table>
      </form>     
<script type="text/javascript">
 jQuery(document).ready(function(){
   var manager_id = jQuery('#wmanager').val();
    jQuery('#wmanager').on("change",function () {
        var manager_id = jQuery(this).find('option:selected').val();
    
        jQuery.ajax({
            url: "<?php echo base_url(); ?>admin/enquiry/get_AssignDriver",
            type: "POST",
            data: "manager_id="+manager_id,
            success: function (response) {
                //console.log(response);
               jQuery("#driver_id").html(response);
            },
        });
    });  
  
});
</script>
