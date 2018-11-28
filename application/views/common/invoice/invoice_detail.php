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