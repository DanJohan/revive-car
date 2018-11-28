  <div class="modal-header workshop-header">
        <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
        <h3 class="modal-title">Order service status</h3>
  </div>
  <div class="modal-body model_view admin-body" align="center">
   <form id="status-form" method="post" class="form-horizontal" action="<?php echo base_url()?>workshop/jobCard/updateStatus">
    <input type="hidden" name="item_id" value="<?php echo $order_item['id']; ?>">
    <input type="hidden" name="order_id" value="<?php echo $order_item['order_id']; ?>">
    <input type ="hidden" name = "jobcard_id" value= "<?php echo $jobcard_id; ?>">
    <div class="form-group">
      <label class="control-label col-sm-2" for="start_date">Start Date:</label>
      <div class="col-sm-10">
      	<div class='input-group date' id='ridedatepicker'>
	        	<input type="text" class="form-control" name="start_date" id="start_date" onkeypress="return false;" value="<?php echo implode('/',array_reverse(explode('-',$order_item['start_date']))); ?>">
	          <span class="input-group-addon">
				<span class="glyphicon glyphicon-calendar"></span>
			</span>
		</div>
      </div>
      <div class="form-error"></div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="end_date">End date:</label>
      <div class="col-sm-10">
      	<div class='input-group date' id='ridedatepicker'>
        		<input type="text" class="form-control" name="end_date" id="end_date" onkeypress="return false;" value="<?php echo implode('/',array_reverse(explode('-',$order_item['end_date']))); ?>">
	        	<span class="input-group-addon">
				<span class="glyphicon glyphicon-calendar"></span>
			 </span>
		</div>
      </div>
      <div class="form-error"></div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="status">Status:</label>
      <div class="col-sm-10">
        <select name="status" id="status" class="form-control">
            <option value="">Please select</option>
            <?php
            $options = array('Pending','On process','Completed');
            foreach ($options as $index => $option) {
            ?>
            <option value="<?php echo $index ?>" <?php echo ($order_item['status']==$index)?'selected':''; ?> ><?php echo $option; ?></option>
            <?php
            }
            ?>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="delay_reason">Delay reason:</label>
      <div class="col-sm-10">
        <textarea  class="form-control" name="delay_reason" id="delay_reason"><?php echo $order_item['delay_reason']; ?></textarea>
      </div>
      <div class="form-error"></div>
    </div>

    <div>
      <button type="submit" class="btn btn-success" name="submit"  value="submit">Submit</button>
    </div>
  </form>
</div>
<script>
    $("#status-form").validate({
      errorClass: "error",
      errorPlacement: function(error, element) {
		error.appendTo(element.parents('.form-group').find('.form-error'));
	},
      rules: {
        start_date:{
          required:true
        },
        end_date: {
          required: true,
        },
        status: {
          required: true,
        }
      }
    });

     $('#start_date,#end_date').datetimepicker({
     	format:'DD/MM/YYYY',
     	minDate:new Date,
     	allowInputToggle:true,
     });
</script>

