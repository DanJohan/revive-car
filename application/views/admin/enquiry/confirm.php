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
          <tr>
              <td style="width: 252px;"><b>Loander vechicle</b></td>
              <td>
                  <label class="radio-inline"><input type="radio"  class="loaner_vehicle" name="loaner_vehicle" value="1" <?php echo ($enquiry['loaner_vehicle'])?"checked":""; ?>/>Required</label>
                  <label class="radio-inlin"><input type="radio" class="loaner_vehicle" name="loaner_vehicle" value="0" <?php echo ($enquiry['loaner_vehicle'])?"":"checked"; ?> />Not Required</label>
              </td>
          </tr>
          <tr id="loaner-vehicle-cost">
              <td><b>Loaner vechicle cost per day</b></td>
              <td><div class="input-group"><span class="input-group-addon">&#x20b9;</span><input type="text" class="form-control price-field" name="loaner_vehicle_cost" value="0.00"  required="" /></div></td>
          </tr>
          
          <tr>
              <td><b>Estimated cost</b></td>
              <td><div class="input-group"><span class="input-group-addon">&#x20b9;</span><input type="text" class="form-control price-field" name="estimated_cost" value="0.00"  required="required"/></div></td>
          </tr>
          <tr>

         

            <td>&nbsp;</td>
            <td><button type="submit" class="btn btn-primary" name="submit">Submit</button></td>
          </tr>
        </table>
      </form>

<script type="text/javascript">
 $(document).ready(function(){

   var manager_id = $('#wmanager').val();
    $('#wmanager').on("change",function () {
        var manager_id = $(this).find('option:selected').val();
    
        $.ajax({
            url: "<?php echo base_url(); ?>admin/enquiry/get_AssignDriver",
            type: "POST",
            data: "manager_id="+manager_id,
            success: function (response) {
                //console.log(response);
               $("#driver_id").html(response);
            },
        });
    });

    function toggleLoanerCost(value) {
      if(value==1){
            $('#loaner-vehicle-cost').show();
        }else{
          $('#loaner-vehicle-cost').find('input').val('0.00');
          $('#loaner-vehicle-cost').hide();
        }
    }
    var loaner_value = $('.loaner_vehicle:checked').val();
    toggleLoanerCost(loaner_value);

    $(document).on('change','.loaner_vehicle',function(){
        var loaner_vehicle = $(this).val();
        toggleLoanerCost(loaner_vehicle);
        
    });
     $('.price-field').number(true,2);
  
});
</script>
