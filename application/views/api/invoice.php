<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="../../favicon.ico">
<title>Invoice</title>

<!-- Bootstrap core CSS -->
<link rel="stylesheet" href="<?php echo base_url(); ?>public/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>public/dist/css/invoice.css">
</head>


<!--=======TOP-SEC==========-->
<section class="top-sec">
  <div class="container">
    <div class="text-center" style="margin-top:10px;"><img src="<?php echo base_url()?>public/images/revive-logo.png" style="width:150px;height: 70px;"></div>
    <div class="top-text text-center">
      <h1>Tax Invoice</h1>
      <h2 class="top-head">Revive Auto Care</h2>
      <p class="top-phr">9/11 Near Atul Kataria Chowk Kila No. , Opp Huda Nursery,
Sector 17A, Gurgaon, Haryana-122001 GSTIN: 06AFVPJ6337B1ZD 
Email:customercare@reviveauto.in</p>
    </div>
    <div class="row" style="margin:0px;">
      <div class="col-xs-12 col-md-4 cust-border">
        <div class="cust-wrapper">
          <h2 class="cust-head">Customer Details</h2>
          <div class="cust-inner">
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
      </div>
      <div class="col-xs-12 col-md-4 cust-border">
        <div class="cust-wrapper">
          <h2 class="cust-head">Vehicle Details</h2>
          <div class="cust-inner">
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
      </div>
      <div class="col-xs-12 col-md-4 cust-border">
        <div class="cust-wrapper">
          <h2 class="cust-head">Invoice Details</h2>
          <div class="cust-inner">
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
    </div>
  </div>
</section>

<section class="middle">
  <div class="container">
    <div class="table-responsive">
      <table class="table">
        <thead class="border">
          <tr>
            <th>SR</th>
            <th>Service name</th>
            <th>Price</th>
          </tr>
        </thead>
        <tbody style="border-bottom: 1px solid #ddd;">
          <?php 
            if(!empty($invoice['invoice_items'])) {
                $i=1;
               foreach ($invoice['invoice_items'] as $index => $data) {
          ?>
            <tr>
              <td><?php echo $i.'.'; ?></td>
              <td><?php echo $data['item_name']; ?></td>
              <td><?php echo $data['price']; ?></td>
            </tr>
          <?php
                $i++;
                } 
            }
          ?>
         

        </tbody>
      </table>
    </div>
  </div>
</section>



<section class="bottom">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-sm-6 invoice-notes">
        <h3>Notes</h3>
        <p style="white-space: pre-line;"><?php echo $invoice['notes']; ?></p>
      </div>
      <div class="col-xs-12 col-sm-6">
        <table class="table table-bordered table-sm">
          <thead>
            <tr>
              <th>Summary</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
                <tr>
                  <td >Sub total</td>
                  <td>&#x20b9; <?php echo $invoice['sub_total']; ?></td>
                </tr>
                <tr>
                  <td >Discount Amount </td>
                  <td>&#x20b9; <?php echo $invoice['discount_amount']; ?></td>
                </tr>
                <tr>
                  <td >Total amount</td>
                  <td>&#x20b9; <?php echo $invoice['total_amount']; ?></td>
                </tr>
                <tr>
                  <td>Gst </td>
                  <td>&#x20b9; <?php echo $invoice['gst_amount']; ?></td>
                </tr>
                <tr>
                  <td>Grand Total</td>
                  <td>&#x20b9; <?php echo $invoice['total_pay_amount']; ?></td>
                </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
<section>
  <div class="container text-right" style="margin-bottom: 20px;">
    <a href="<?php echo base_url();?>api/web/printInvoicePdf/<?php echo $invoice['id']; ?>" class="btn btn-primary">Download PDF</a>
  </div>
</section>
