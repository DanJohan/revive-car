<section class="content">
    <div class="box">
        <div class="box-header bg-green">
         <h3 class="box-title">Invoice</h3>
       </div>
      <form id="invoice-form" action="<?php echo base_url(); ?>workshop/jobCard/createInvoice" method="post">
       <div class="box-body">
        <div class="row">
            <div class="col-xs-6">
                <h3>Customer Details</h3>
                <div class="row">
                    <div class="col-xs-4"><b>Client Name</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-7">
                      <?php echo $job_card['name']; ?>
                      <input type="hidden" name="client_name" value="<?php echo $job_card['name']; ?>" />
                      <input type="hidden" name="job_card_id" value="<?php echo $job_card['id']; ?>" />
                      <input type="hidden" name="user_id" value="<?php echo $job_card['user_id']; ?>" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>Phone</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-7">
                      <?php echo $job_card['phone']; ?>
                      <input type="hidden" name="client_phone" value="<?php echo $job_card['phone']; ?>" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>Email</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-7">
                      <?php echo $job_card['email']; ?>
                      <input type="hidden" name="client_email" value="<?php echo $job_card['email']; ?>" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>Address</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-7">
                      <?php echo $job_card['address']; ?>
                        <input type="hidden" name="client_address" value="<?php echo $job_card['address']; ?>" />
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
                        <input type="date" class="form-control" name="invoice_created_date" value="<?php echo date('Y-m-d');?>">
                      </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>Invoice due Date</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-7">
                      <div class="form-group">
                        <input type="date" class="form-control" name="invoice_due_date" value="<?php echo date('Y-m-d');?>">
                      </div>
                      </div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>SA Name</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-7">
                      <div class="form-group">
                        <input type="text" class="form-control" name="sa_name" value="<?php echo $this->session->userdata('m_name'); ?>" required />
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
                    <tr>
                          <td><input type="text" class="form-control labour-item" name="labour[0][item]" /></td>
                          <td><input type="text" class="form-control labour-hour validateNumeric" name="labour[0][hour]" /></td>
                          <td><input type="text" class="form-control labour-rate validateNumeric" name="labour[0][rate]" /></td>
                          <td><input type="text" class="form-control labour-cost" name="labour[0][cost]" readonly /></td>
                          <td><input type="text" class="form-control labour-gst validateNumeric" name="labour[0][gst]" value="0.00" /><input type="hidden" class="gst-amount" name="labour[0][gst_amount]" value="0.00"></td>
                          <td><input type="text" class="form-control labour-total" name="labour[0][total]" readonly /></td>
                          <td><button type="button" class="btn btn-success labour-add-button"><i class="fa fa-plus" aria-hidden="true"></i></button></td>
                    </tr>
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
                      <tr>
                          <td><input type="text" class="form-control parts-item invoice-item" name="parts[0][item]" /></td>
                          <td><input type="text" class="form-control parts-qty validateNumeric" name="parts[0][qty]" /></td>
                          <td><input type="text" class="form-control parts-cost validateNumeric" name="parts[0][cost]" /></td>
                          <td><input type="text" class="form-control parts-gst validateNumeric" name="parts[0][gst]" value="0.00" /><input type="hidden" class="gst-amount" value="0.00" name="parts[0][gst_amount]"></td>
                          <td><input type="text" class="form-control parts-total" name="parts[0][total]" readonly /></td>
                          <td><button type="button" class="btn btn-success parts-add-button"><i class="fa fa-plus" aria-hidden="true"></i></button></td>
                      </tr>
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
                    <div class="col-xs-4"><b>Total labor</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-5">
                      <span id="total-labour-amount">&#x20b9; 0.00</span>
                      <input type="hidden" name="labour_total">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>Total Parts:</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-5">
                      <span id="total-parts-amount">&#x20b9; 0.00</span>
                      <input type="hidden" name="parts_total">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>GST</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-5">
                      <span id="total-gst-amount">&#x20b9; 0.00</span>
                      <input type="hidden" name="gst_total">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>Discount(%)</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-5"><input id="discount" type="text" name="discount" class="form-control" value="0.00"/></div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>Total</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-5">
                      <span id="total-amount">&#x20b9; 0.00</span>
                      <input type="hidden" id="totalAmountAfterDiscount" name="total_amount_after_discount" value="0.00"/>
                      <input type="hidden" id="totalAmount" name="total_amount" value="0.00"/>
                      <input type="hidden" id="discountAmount" name="discount_amount" value="0.00"/>
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
<script type="text/javascript" src="<?php echo base_url() ?>public/dist/js/pages/invoice.js"></script>




