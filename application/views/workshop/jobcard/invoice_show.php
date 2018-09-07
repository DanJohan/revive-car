   <section class="content">
    <div class="box">
      <div class="box-header bg-green">
         <h3 class="box-title">Invoice detail</h3>
     </div>

     <div class="box-body">
      <div class="row" style="margin-bottom: 20px;">
        <div class="col-md-4 cust-border">
          <div class="cust-wrapper">
            <h2 class="cust-head">Customer Details</h2>
              <div class="row">
                <div class="col-xs-4"><b>Client name </b></div>
                <div class="col-xs-1">:</div>
                <div class="col-xs-6"><?php echo $invoice['client_name']; ?></div>
              </div>
              <div class="row">
                <div class="col-xs-4"><b>Client phone </b></div>
                <div class="col-xs-1">:</div>
                <div class="col-xs-6"><?php echo $invoice['client_phone']; ?></div>
              </div>
              <div class="row">
                <div class="col-xs-4"><b>Client email </b></div>
                <div class="col-xs-1">:</div>
                <div class="col-xs-6"><?php echo $invoice['client_email']; ?></div>
              </div>
              <div class="row">
                <div class="col-xs-4"><b>Client address </b></div>
                <div class="col-xs-1">:</div>
                <div class="col-xs-6"><?php echo $invoice['client_address']; ?></div>
              </div>
          </div>
        </div>
        <div class="col-md-4 cust-border">
          <div class="cust-wrapper">
            <h2 class="cust-head">Vehicle Details</h2>
              <div class="row">
                <div class="col-xs-4"><b>Registration No  </b></div>
                <div class="col-xs-1">:</div>
                <div class="col-xs-6"><?php echo $invoice['vehicle_reg_no']; ?></div>
              </div>
              <div class="row">
                <div class="col-xs-4"><b>Brand </b></div>
                <div class="col-xs-1">:</div>
                <div class="col-xs-6"><?php echo $invoice['vehicle_brand_name']; ?></div>
              </div>
              <div class="row">
                <div class="col-xs-4"><b>Model </b></div>
                <div class="col-xs-1">:</div>
                <div class="col-xs-6"><?php echo $invoice['vehicle_model_name']; ?></div>
              </div>
              <div class="row">
                <div class="col-xs-4"><b>VIN </b></div>
                <div class="col-xs-1">:</div>
                <div class="col-xs-6"><?php echo $invoice['vehicle_vin_no']; ?></div>
              </div>
              <div class="row">
                <div class="col-xs-4"><b>KMS </b></div>
                <div class="col-xs-1">:</div>
                <div class="col-xs-6"><?php echo $invoice['vehicle_kms']; ?></div>
              </div>
          </div>
        </div>
        <div class="col-md-4 cust-border">
          <div class="cust-wrapper">
            <h2 class="cust-head">Invoice Details</h2>
              <div class="row">
                <div class="col-xs-4"><b>Invoice </b></div>
                <div class="col-xs-1">:</div>
                <div class="col-xs-6"><?php echo $invoice['invoice_number']; ?></div>
              </div>
              <div class="row">
                <div class="col-xs-4"><b>Invoice Date </b></div>
                <div class="col-xs-1">:</div>
                <div class="col-xs-6"><?php echo date('d-m-Y',strtotime($invoice['date_created'])); ?></div>
              </div>
              <div class="row">
                <div class="col-xs-4"><b>Invoice Due Date </b></div>
                <div class="col-xs-1">:</div>
                <div class="col-xs-6"><?php echo date('d-m-Y',strtotime($invoice['due_date'])); ?></div>
              </div>
              <div class="row">
                <div class="col-xs-4"><b>SA Name </b></div>
                <div class="col-xs-1">:</div>
                <div class="col-xs-6"><?php echo $invoice['sa_name']; ?></div>
              </div>
          </div>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered table-sm">
          <thead class="border">
            <tr>
              <th>SR</th>
              <th>Labor</th>
              <th>Hour</th>
              <th>Rate/Day</th>
              <th>Cost</th>
              <th>GST (%)</th>
              <th>Total Amount</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            if(!empty($invoice['labour'])) {
              $i=1;
              foreach ($invoice['labour'] as $index => $data) {
                ?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <td><?php echo $data['invoice_labour_item']; ?></td>
                  <td><?php echo $data['invoice_labour_hour']; ?></td>
                  <td><?php echo $data['invoice_labour_rate']; ?></td>
                  <td><?php echo $data['invoice_labour_cost']; ?></td>
                  <td><?php echo $data['invoice_labour_gst']; ?></td>
                  <td><?php echo $data['invoice_labour_total']; ?></td>
                </tr>
                <?php
                $i++;
              } 
            }
            ?>


          </tbody>
          <thead class="border">
            <tr>
              <th colspan="6">Total</th>
              <th><?php echo $invoice['labour_total']; ?></th>
            </tr>
          </thead>
        </table>
      </div>


      <div class="table-responsive">
        <table class="table table-bordered table-sm">
          <thead class="border">
            <tr>
              <th>SR</th>
              <th>Parts</th>
              <th>Quantity</th>
              <th>Cost</th>
              <th>GST (%)</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            if(!empty($invoice['parts'])){
             $i=1;
             foreach ($invoice['parts'] as $index => $data) {
              ?>
              <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $data['invoice_parts_item']; ?></td>
                <td><?php echo $data['invoice_parts_quantity']; ?></td>
                <td><?php echo $data['invoice_parts_cost']; ?></td>
                <td><?php echo $data['invoice_parts_gst']; ?></td>
                <td><?php echo $data['invoice_parts_total']; ?></td>
              </tr>
              <?php
              $i++;
            }
          } 
          ?>


        </tbody>
        <thead class="border">
          <tr>
            <th colspan="5">Total</th>
            <th><?php echo $invoice['parts_total']; ?></th>
          </tr>
        </thead>
      </table>
    </div>

      <div class="row">
        <div class="col-sm-6">
          <h3>Notes</h3>
          <p style="white-space: pre-line;"><?php echo $invoice['notes']; ?></p>
        </div>
        <div class="col-sm-6">
          <table class="table table-bordered table-sm">
            <thead>
              <tr>
                <th>Summary</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Total labour</td>
                <td>&#x20b9; <?php echo $invoice['labour_total']; ?></td>
              </tr>
              <tr>
                <td>Total Parts </td>
                <td>&#x20b9; <?php echo $invoice['parts_total']; ?></td>
              </tr>
              <tr>
                <td>GST</td>
                <td>&#x20b9; <?php echo $invoice['gst_total']; ?></td>
              </tr>
              <tr>
                <td>Discount</td>
                <td>&#x20b9; <?php echo $invoice['discount_amount']; ?></td>
              </tr>
              <tr>
                <td>Grand Total</td>
                <td>&#x20b9; <?php echo $invoice['total_amount_after_discount']; ?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
</section>
<section class="content">
  <div class="box">
    <div class="box-body">
      <a href="<?php echo base_url();?>workshop/jobCard/list" class="btn btn-success">Go back</a>
    </div>
  </div><!-- end of button box -->
</section>



