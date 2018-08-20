  <div class="modal-header workshop-header">
        <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
        <h3 class="modal-title">Edit repair order</h3>
  </div>
  <div class="modal-body model_view admin-body" align="center">
   <form id="order-edit-form" method="post" class="form-horizontal" action="<?php echo base_url()?>workshop/jobCard/editRepairOrder">
    <input type="hidden" name="job_id" value="<?php echo $job['id']; ?>">
    <input type="hidden" name="job_card_id" value="<?php echo $job_card_id; ?>">
    <div class="form-group">
      <label class="control-label col-sm-2" for="customer_request">Customer Request:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="customer_request" id="customer_request" value="<?php echo $job['customer_request']; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="sa_remarks">S.A Remarks:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="sa_remarks" id="sa_remarks" value="<?php echo $job['sa_remarks']; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="parts_name">Parts Name:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="parts_name" id="parts_name" value="<?php echo $job['parts_name']; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="qty">Quantity:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="quantity" id="qty" value="<?php echo $job['qty']; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="parts_price">Parts price:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="parts_price" id="parts_price" value="<?php echo $job['parts_price']; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="labour_price">Labour price:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="labour_price" id="labour_price" value="<?php echo $job['labour_price']; ?>">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="total_price">Total price:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="total_price" id="total_price" value="<?php echo $job['total_price']; ?>">
      </div>
    </div>
    <div>
      <button type="submit" class="btn btn-success" name="submit"  value="submit">Submit</button>
    </div>
  </form>
</div>
<script src="<?php echo base_url() ?>public/dist/js/jquery.validate.min.js"></script>
<script>
    $("#order-edit-form").validate({
      errorClass: "error",
      rules: {
        customer_request:{
          required:true
        },
        sa_remarks: {
          required: true,
        },
        parts_name: {
          required: true,
        },
        parts_price: {
          required: true,
          number: true
        },
        labour_price: {
          required: true,
          number: true
        },
        quantity: {
          required: true,
          digits: true
        },
        total_price: {
          required: true,
          number: true
        },
      },
    });
</script>