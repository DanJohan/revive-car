<?php $this->widget->beginBlock('stylesheets'); ?>
<link rel="stylesheet" href="<?php echo  base_url() ?>public/dist/css/bootstrap-datetimepicker.min.css"> 
<?php $this->widget->endBlock(); ?>
<section class="content">
    <div class="box">
        <div class="box-header bg-green">
         <h3 class="box-title">Invoice</h3>
       </div>
      <form id="invoice-form" action="<?php echo base_url(); ?>workshop/invoice/save" method="post">
       <div class="box-body">
        <div class="row">
            <div class="col-xs-6">
                <h3>Customer Details</h3>
                <div class="row">
                    <div class="col-xs-4"><b>Client Name</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-7">
                      <?php echo $job_card['user_name']; ?>
                      <input type="hidden" name="client_name" value="<?php echo $job_card['user_name']; ?>" />
                      <input type="hidden" name="order_id" value="<?php echo $job_card['order_id']; ?>" />
                      <input type="hidden" name="user_id" value="<?php echo $job_card['user_id']; ?>" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>Phone</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-7">
                      <?php echo $job_card['user_phone']; ?>
                      <input type="hidden" name="client_phone" value="<?php echo $job_card['user_phone']; ?>" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>Email</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-7">
                      <?php echo $job_card['user_email']; ?>
                      <input type="hidden" name="client_email" value="<?php echo $job_card['user_email']; ?>" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>Address</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-7">
                      <?php echo $job_card['user_address']; ?>
                        <input type="hidden" name="client_address" value="<?php echo $job_card['user_address']; ?>" />
                      </div>
                </div>
            </div>
            <div class="col-xs-6">
                <h3>Vehicle Details</h3>
                <div class="row">
                    <div class="col-xs-4"><b>Registertion No</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-7">
                      <?php echo $job_card['registration_no']; ?>
                      <input type="hidden" name="vehicle_reg_no" value="<?php echo $job_card['registration_no']; ?>" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>Brand Name</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-7">
                      <?php echo $job_card['brand_name']; ?>
                      <input type="hidden" name="vehicle_brand_name" value="<?php echo $job_card['brand_name']; ?>" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>Model</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-7">
                      <?php echo $job_card['model_name']; ?>
                      <input type="hidden" name="vehicle_model_name" value="<?php echo $job_card['model_name']; ?>" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>VIN No</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-7">
                      <?php echo $job_card['vin_no']; ?>
                         <input type="hidden" name="vehicle_vin_no" value="<?php echo $job_card['model_name']; ?>" />
                      </div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>KMS</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-7">
                      <?php echo $job_card['ride_kms']; ?>
                      <input type="hidden" name="vehicle_kms" value="<?php echo $job_card['ride_kms']; ?>" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6">
                  <h3>Invoice Details</h3>
                <div class="row">
                    <div class="col-xs-4"><b>Invoice No</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-7"><?php echo $sequence['sequence']; ?></div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>Invoice Date</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-7">
                      <div class="form-group">
                      	<div class='input-group date' id='invoice_created_date'>
                        		<input type="text" class="form-control" id="invoice_created_date" name="invoice_created_date" value="<?php echo date('d/m/Y');?>">
                        		<span class="input-group-addon">
					            <span class="glyphicon glyphicon-calendar"></span>
					     </span>
					     <div class="form-error"></div>
                        	</div>
                      </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>Invoice due Date</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-7">
                      <div class="form-group">
                      	<div class='input-group date' id='invoice_created_date'>
                        		<input type="text" class="form-control" id="invoice_due_date" name="invoice_due_date" value="">
                        		<span class="input-group-addon">
					            <span class="glyphicon glyphicon-calendar"></span>
					     </span>
                        	</div>
                        	<div class="form-error"></div>
                      </div>
                      </div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>SA Name</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-7">
                      <div class="form-group">
                        <input type="text" class="form-control" name="sa_name" value="<?php echo $this->session->userdata('m_name'); ?>" required />
                        <div class="form-error"></div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
          <div class="col-xs-12">
              <h3>Order service</h3>
              <div class="table-responsive">
                  <table class="table labour-table">
                    <tr>
                        <td class="text-bold" >S. No.</td>
                        <td class="text-bold" >Service Name</td>
                        <td class="text-bold" >Price</td>
                    <?php 
                    	if(!empty($job_card['order_items'])){
                    		$i=1;
                    		foreach ($job_card['order_items'] as $index => $order_item) {
                   	?>
                   		<tr>
                   			<td><?php echo $i."."; ?></td>
                   			<td><?php echo $order_item['service_name']; ?><input type="hidden" name="order_items[<?php echo $i-1; ?>][service_name]" value="<?php echo $order_item['service_name']; ?>" /></td>
                   			<td><?php echo $order_item['price']; ?><input type="hidden" name="order_items[<?php echo $i-1; ?>][price]" value="<?php echo $order_item['price']; ?>" /></td>
                   		</tr>
                   	<?php
                    		$i++;
                    		}
                    	}

                    ?>
                  </table>
              </div>
          </div>
        </div>


    
        <div class="row">
          <div class="col-xs-6">
              <h3>Notes</h3>
              <textarea class="form-control" rows="7" name="notes"></textarea>
          </div>
          <div class="col-xs-6">
                  <br><br><br>
			<div class="row">
                    <div class="col-xs-4"><b>Sub Total:</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-5">
                      <span id="sub_total">&#x20b9; <?php echo $job_card['sub_total']; ?></span>
                      <input type="hidden" id="sub_total" name="sub_total" value="<?php echo $job_card['sub_total']; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>Discount Amount:</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-5">
                      <span id="discount_amount">&#x20b9; <?php echo $job_card['discount_amount']; ?></span>
                      <input type="hidden" id="discount_amount" name="discount_amount" value="<?php echo $job_card['discount_amount']; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>Total Amount:</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-5">
                      <span id="total_amount-text">&#x20b9; <?php echo $job_card['net_pay_amount']; ?></span>
                      <input type="hidden" id="total_amount" name="total_amount" value="<?php echo $job_card['net_pay_amount']; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>GST(%)</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-5">
                    	<input id="gst" type="text" name="gst" class="form-control" value="0.00"/>
                    	<input type="hidden" id="gst-amount" name="gst_amount" value="0.00">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>Total Pay amount</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-5">
                      <span id="total-pay-amount-text">&#x20b9;  <?php echo $job_card['net_pay_amount']; ?></span>
                      <input type="hidden" id="total-pay-amount" name="total_pay_amount" value=" <?php echo $job_card['net_pay_amount']; ?>"/>
                    </div>
                </div>
          </div>
        </div>
        <div class="row">
            <div class="col-xs-6">
                <div class="form-group" style="margin-top:50px;">
                    <button type="submit" class="btn btn-success" name="submit" value="save">Save</button>
                </div>
            </div>
        </div>
        </div>
      </form>
</div>
</section>
<?php $this->widget->beginBlock('scripts'); ?>

<script type="text/javascript" src="<?php echo base_url(); ?>public/dist/js/moment.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/dist/js/bootstrap-datetimepicker.min.js"></script>
<!-- <script type="text/javascript" src="<?php //echo base_url() ?>public/dist/js/pages/invoice.js"></script> -->
<script type="text/javascript">
	var date = new Date();
 	var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
	$('#invoice_created_date,#invoice_due_date').datetimepicker({
     	format:'DD/MM/YYYY',
     	minDate:today,
     	allowInputToggle:true,
     });

     $(document).on('keyup','#gst',function(){

		var gst = $(this).val();
		var amount = $('#total_amount').val();
		var gstAmount=((amount/100)*gst).toFixed(2);
		var total_pay_amount = (Number(amount)+Number(gstAmount)).toFixed(2);
		console.log(total_pay_amount);
		$('#gst-amount').val(gstAmount);
		$('#total-pay-amount').val(total_pay_amount);
		$('#total-pay-amount-text').html('&#x20b9; '+total_pay_amount);


	});

	$("#invoice-form").validate({
		errorClass: "error",
		errorPlacement: function(error, element) {
			error.appendTo(element.parents('.form-group').find('.form-error'));
		},
		rules: {
			invoice_due_date:{
				required:true
			},
			invoice_created_date: {
				required: true,
			},
			sa_name: {
				required: true,
			}
		}
	});
</script>
<?php $this->widget->endBlock(); ?>




