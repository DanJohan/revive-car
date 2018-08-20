  <div class="modal-header workshop-header">
        <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
        <h3 class="modal-title">Repair order status</h3>
  </div>
  <div class="modal-body model_view admin-body" align="center">
   <form id="status-form" method="post" class="form-horizontal" action="<?php echo base_url()?>workshop/jobCard/updateStatus">
    <input type="hidden" name="job_id" value="<?php echo $job['id']; ?>">
    <input type="hidden" name="job_card_id" value="<?php echo $job_card_id; ?>">
    <div class="form-group">
      <label class="control-label col-sm-2" for="start_date">Start Date:</label>
      <div class="col-sm-10">
        <input type="date" class="form-control" name="start_date" id="start_date" value="<?php echo $job['start_date']; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="end_date">End date:</label>
      <div class="col-sm-10">
        <input type="date" class="form-control" name="end_date" id="end_date" value="<?php echo $job['end_date']; ?>">
      </div>
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
            <option value="<?php echo $index ?>" <?php echo ($job['status']==$index)?'selected':''; ?> ><?php echo $option; ?></option>
            <?php
            }
            ?>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="delay_reason">Delay reason:</label>
      <div class="col-sm-10">
        <textarea  class="form-control" name="delay_reason" id="delay_reason"><?php echo $job['delay_reason']; ?></textarea>
      </div>
    </div>

    <div>
      <button type="submit" class="btn btn-success" name="submit"  value="submit">Submit</button>
    </div>
  </form>
</div>
<script src="<?php echo base_url() ?>public/dist/js/jquery.validate.min.js"></script>
<script>
    $("#status-form").validate({
      errorClass: "error",
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
</script>