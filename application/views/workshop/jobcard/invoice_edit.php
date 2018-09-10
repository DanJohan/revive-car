<section class="content">
    <div class="box">
        <div class="box-header bg-green">
         <h3 class="box-title">Invoice</h3>
       </div>
      <form id="invoice-form" action="<?php echo base_url(); ?>workshop/jobCard/invoiceUpdate" method="post">
       <div class="box-body">
        <div class="row">
            <div class="col-xs-6">
                <h3>Customer Details</h3>
                <div class="row">
                    <div class="col-xs-4"><b>Client Name</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-7">
                      <?php echo $invoice['client_name']; ?>
                      <input type="hidden" name="invoice_id" value="<?php echo $invoice['id']; ?>" />
                      <input type="hidden" name="user_id" value="<?php echo $invoice['user_id']; ?>" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>Phone</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-7">
                      <?php echo $invoice['client_phone']; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>Email</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-7">
                      <?php echo $invoice['client_email']; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>Address</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-7">
                      <?php echo $invoice['client_address']; ?>
                      </div>
                </div>
            </div>
            <div class="col-xs-6">
                <h3>Vehicle Details</h3>
                <div class="row">
                    <div class="col-xs-4"><b>Registertion No</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-7">
                      <?php echo $invoice['vehicle_reg_no']; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>Brand Name</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-7">
                      <?php echo $invoice['vehicle_brand_name']; ?>/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>Model</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-7">
                      <?php echo $invoice['vehicle_model_name']; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>VIN No</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-7">
                      <?php echo $invoice['vehicle_vin_no']; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>KMS</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-7">
                      <?php echo $invoice['vehicle_kms']; ?>
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
                    <div class="col-xs-7"><?php echo $invoice['invoice_number']; ?></div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>Invoice Date</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-7">
                        <div class="form-group">
                          <input type="date" class="form-control" name="invoice_created_date" value="<?php echo $invoice['date_created'];?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>Invoice due Date</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-7">
                      <div class="form-group">
                        <input type="date" class="form-control" name="invoice_due_date" value="<?php echo $invoice['due_date'];?>">
                      </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>SA Name</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-7">
                     <div class="form-group">
                        <input type="text" class="form-control" name="sa_name" value="<?php echo $invoice['sa_name']; ?>" required />
                      </div>        
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
          <div class="col-xs-12">
              <h3>Labour</h3>
              <div class="table-responsive">
                  <table class="table labour-table">
                    <tr>
                        <td style="width:40%;">Item</td>
                        <td style="width:10%;">Hours</td>
                        <td style="width:10%;">Rate/Day</td>
                        <td style="width:10%;">Cost</td>
                        <td style="width:10%;">GST (%)</td>
                        <td style="width:10%;">Total</td>
                        <td>Actions</td>
                    </tr>
                    <?php 
                      if(!empty($invoice['labour'])) { 
                        foreach ($invoice['labour'] as $index => $labour) {
                    ?>
                    <tr>
                          <td>
                            <input type="hidden" name="labour[<?php echo $index; ?>][id]"  value="<?php echo $labour['invoice_labour_id']?>"/>
                            <input type="text" class="form-control labour-item" name="labour[<?php echo $index; ?>][item]"  value="<?php echo $labour['invoice_labour_item']?>"/>
                          </td>
                          <td><input type="text" class="form-control labour-hour validateNumeric" name="labour[<?php echo $index; ?>][hour]" value="<?php echo $labour['invoice_labour_hour']?>" /></td>
                          <td><input type="text" class="form-control labour-rate validateNumeric" name="labour[<?php echo $index; ?>][rate]" value="<?php echo $labour['invoice_labour_rate']?>" /></td>
                          <td><input type="text" class="form-control labour-cost" name="labour[<?php echo $index; ?>][cost]" value="<?php echo $labour['invoice_labour_cost']?>" readonly /></td>
                          <td><input type="text" class="form-control labour-gst validateNumeric" name="labour[<?php echo $index; ?>][gst]" value="<?php echo $labour['invoice_labour_gst']?>" /><input type="hidden" class="gst-amount" name="labour[<?php echo $index; ?>][gst_amount]" value="<?php echo $labour['invoice_labour_gst_amount']?>" /></td>
                          <td><input type="text" class="form-control labour-total" name="labour[<?php echo $index; ?>][total]" value="<?php echo $labour['invoice_labour_total']?>" readonly /></td>
                          <?php if($index == 0) { ?>
                          <td><button type="button" class="btn btn-success labour-add-button"><i class="fa fa-plus" aria-hidden="true"></i></button></td>
                        <?php }else{ ?>
                            <td><button class="btn btn-success labour-delete-button"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
                        <?php } ?>
                    </tr>
                    <?php
                      }
                    }
                    ?>
                  </table>
              </div>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-12">
              <h3>Parts</h3>
              <div class="table-responsive">
                  <table class="table parts-table">
                    <tr>
                        <td style="width:50%;">Item</td>
                        <td style="width:10%;">Qty</td>
                        <td style="width:10%;">Cost</td>
                        <td style="width:10%;">GST (%)</td>
                        <td style="width:10%;">Total</td>
                        <td>Actions</td>
                    </tr>
                    <?php 
                      if(!empty($invoice['parts'])) {
                        foreach ($invoice['parts'] as $index => $parts) {
                      
                    ?>
                      <tr>
                          <td>
                            <input type="hidden" name="parts[<?php echo $index; ?>][id]" value="<?php echo $parts['invoice_parts_id']; ?>" />
                            <input type="text" class="form-control parts-item invoice-item" name="parts[<?php echo $index; ?>][item]" value="<?php echo $parts['invoice_parts_item']; ?>" />
                          </td>
                          <td><input type="text" class="form-control parts-qty validateNumeric" name="parts[<?php echo $index; ?>][qty]" value="<?php echo $parts['invoice_parts_quantity']; ?>" /></td>
                          <td><input type="text" class="form-control parts-cost validateNumeric" name="parts[<?php echo $index; ?>][cost]" value="<?php echo $parts['invoice_parts_cost']; ?>" /></td>
                          <td><input type="text" class="form-control parts-gst validateNumeric" name="parts[<?php echo $index; ?>][gst]" value="<?php echo $parts['invoice_parts_gst']; ?>" /><input type="hidden" class="gst-amount" name="parts[<?php echo $index; ?>][gst_amount]" value="<?php echo $parts['invoice_parts_gst_amount']; ?>" ></td>
                          <td><input type="text" class="form-control parts-total" name="parts[<?php echo $index; ?>][total]" value="<?php echo $parts['invoice_parts_total']; ?>" readonly /></td>
                          <?php if($index == 0) { ?>
                          <td><button type="button" class="btn btn-success parts-add-button"><i class="fa fa-plus" aria-hidden="true"></i></button></td>
                          <?php }else { ?>
                            <td><button class="btn btn-success parts-delete-button"><i class="fa fa-trash" aria-hidden="true"></i></button></td>
                          <?php } ?>
                      </tr>
                    <?php
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
              <textarea class="form-control" rows="7" name="notes"><?php echo $invoice['notes']; ?></textarea>
          </div>
          <div class="col-xs-6">
                  <br><br><br>
                 <div class="row">
                    <div class="col-xs-4"><b>Total labor</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-5">
                      <span id="total-labour-amount">&#x20b9; <?php echo $invoice['labour_total']; ?></span>
                      <input type="hidden" id="labourTotal" name="labour_total" value="<?php echo $invoice['labour_total']; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>Total Parts:</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-5">
                      <span id="total-parts-amount">&#x20b9; <?php echo $invoice['parts_total']; ?></span>
                      <input type="hidden" name="parts_total" id="partsTotal" value="<?php echo $invoice['parts_total']; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>GST</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-5">
                      <span id="total-gst-amount">&#x20b9; <?php echo $invoice['gst_total']; ?></span>
                      <input type="hidden" name="gst_total" id="gstTotal" value="<?php echo $invoice['gst_total']; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>Discount(%)</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-5"><input id="discount" type="text" name="discount" class="form-control" value="<?php echo $invoice['discount']; ?>" /></div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>Total</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-5">
                      <span id="total-amount">&#x20b9; <?php echo $invoice['total_amount_after_discount']; ?></span>
                      <input type="hidden" id="totalAmountAfterDiscount" name="total_amount_after_discount" value="<?php echo $invoice['total_amount_after_discount']; ?>"/>
                      <input type="hidden" id="totalAmount" name="total_amount" value="<?php echo $invoice['total_amount']; ?>"/>
                      <input type="hidden" id="discountAmount" name="discount_amount" value="<?php echo $invoice['discount_amount']; ?>"/>
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
<script type="text/javascript">
  var invoiceConfig = {
          'labourFieldStart':"<?php echo count($invoice['labour'])+1;?>",
          'partsFieldStart':"<?php echo count($invoice['parts'])+1;?>",
          'labourTotalSum':$('#labourTotal').val(),
          'partsTotalSum' : $('#partsTotal').val(),
          'gstTotalSum':$('#gstTotal').val(),
          'totalAmount':$('#totalAmount').val(),
          'totalAmountAfterDiscount': $('#totalAmountAfterDiscount').val(),
          'discountAmount' : $('#discountAmount').val()
  };

</script>
<script type="text/javascript" src="<?php echo base_url() ?>public/dist/js/pages/invoice.js"></script>




