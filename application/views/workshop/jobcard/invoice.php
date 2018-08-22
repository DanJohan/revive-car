<section class="content">
    <div class="box">
        <div class="box-header bg-green">
         <h3 class="box-title">Invoice</h3>
       </div>
      <form id="invoice-form" action="" method="post">
       <div class="box-body">
        <div class="row">
            <div class="col-xs-4">
                <h3>Customer Details</h3>
                <div class="row">
                    <div class="col-xs-4"><b>Client Name</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-5"><?php echo $job_card['name']; ?></div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>Phone</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-5"><?php echo $job_card['phone']; ?></div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>Email</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-5"><?php echo $job_card['email']; ?></div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>Address</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-5"><?php echo $job_card['address']; ?></div>
                </div>
            </div>
            <div class="col-xs-4">
                <h3>Vehicle Details</h3>
                <div class="row">
                    <div class="col-xs-4"><b>Registertion No</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-5"><?php echo $job_card['registration_no']; ?></div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>Brand Name</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-5"><?php echo $job_card['brand_name']; ?></div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>Model</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-5"><?php echo $job_card['model_name']; ?></div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>VIN No</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-5"><?php echo $job_card['vin_no']; ?></div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>KMS</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-5"><?php echo $job_card['ride_kms']; ?></div>
                </div>
            </div>
            <div class="col-xs-4">
                  <h3>Invoice Details</h3>
                  <div class="row">
                    <div class="col-xs-4"><b>Invoice No</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-5">20180000001</div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>Invoice Date</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-5"><input type="date" value="<?php echo date('Y-m-d');?>"></div>
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
                          <td><input type="text" class="form-control" /></td>
                          <td><input type="number" class="form-control labour-hour" /></td>
                          <td><input type="number" class="form-control labour-rate" /></td>
                          <td><input type="number" class="form-control labour-cost" readonly /></td>
                          <td><input type="number" class="form-control labour-gst" /><input type="hidden" class="gst-amount" value="0.00"></td>
                          <td><input type="number" class="form-control labour-total" readonly /></td>
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
                          <td><input type="text" class="form-control" /></td>
                          <td><input type="number" class="form-control parts-qty" /></td>
                          <td><input type="number" class="form-control parts-cost"/></td>
                          <td><input type="number" class="form-control parts-gst" /><input type="hidden" class="gst-amount" value="0.00"></td>
                          <td><input type="number" class="form-control parts-total" readonly /></td>
                          <td><button type="button" class="btn btn-success parts-add-button"><i class="fa fa-plus" aria-hidden="true"></i></button></td>
                      </tr>
                  </table>
              </div>
          </div>
        </div>
    
        <div class="row">
          <div class="col-xs-6">
              <h3>Notes</h3>
              <textarea class="form-control" rows="7"></textarea>
          </div>
          <div class="col-xs-6">
                  <br><br><br>
                 <div class="row">
                    <div class="col-xs-4"><b>Total labor</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-5"><span id="total-labour-amount">&#x20b9; 0.00</span></div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>Total Parts:</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-5"><span id="total-parts-amount">&#x20b9; 0.00</span></div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>GST</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-5"><span id="total-gst-amount">&#x20b9; 0.00</span></div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>Discount(%)</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-5"><input id="discount" type="text" class="form-control" value="0"/></div>
                </div>
                <div class="row">
                    <div class="col-xs-4"><b>Total</b></div>
                    <div class="col-xs-1">:</div>
                    <div class="col-xs-5">
                      <span id="total-amount">&#x20b9; 0.00</span>
                      <input type="hidden" id="totalAmountAfterDiscount" value="0.00"/>
                      <input type="hidden" id="totalAmount" value="0.00"/>
                      <input type="hidden" id="discountAmount" value="0.00"/>
                    </div>
                </div>
          </div>
        </div>
        <div class="row">
            <div class="col-xs-6">
                <div class="form-group" style="margin-top:50px;">
                    <input type="submit" class="btn btn-success" value="Save">
                </div>
            </div>
        </div>
        </form>
  </div>
</div>
</section>
<script type="text/javascript" src="<?php echo base_url() ?>public/dist/js/pages/invoice.js"></script>




