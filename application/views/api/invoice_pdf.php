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

<link rel="stylesheet" href="<?php echo base_url(); ?>public/dist/css/invoice.css" >
<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
<style>
  body {
  font-family: 'Open Sans', sans-serif;
}
h1, h2, h3, h4, h5, h6, p {
  margin: 0px;
  padding: 0px;
}
section.top-sec {
  margin-bottom: 20px;
}
{
 text-align: center;
 font-size: 24px;
 font-weight: bold;
 color: #3e3e3e;
}
h2.top-head {
    border: 1px solid #ddd;
    background-color: #ededed;
}
p.top-phr {
  font-size: 14px;
}
.cust-border {
  border-right: 1px solid #ddd;
  height: -webkit-fill-available;
  padding: 0px 1px;
  margin: 0px;
  height: 219px;
}
.cust-inner {
  padding: 10px 10px;
}
h2.cust-head {
  text-align: center;
  border: 1px solid #ddd;
  border-left: none;
  border-top: none;
  border-right: none;
}
/*.cust-wrapper {
  height: 100%;
  min-height: 200px;
}*/
section.middle tr td {
  border: none;
}
section.middle thead th {
  border: 1px solid #ddd;
}
thead.border {
  border-top: 1px solid #ddd;
}
section.bottom tbody td {
  border: none;
  border-bottom: 1px solid #ddd;
  text-align: right;
}
section.bottom thead th {
  border-right: none;
  border: none;
  border-bottom: 1px solid #ddd;
  text-align: right;
}
.b-text
{
  float:right;
}
.sign
{
  float:right;
}
.top-text{
  padding-bottom: 20px;
}
</style>
</head>


<!--=======TOP-SEC==========-->
<section class="top-sec">
  <div class="container">
    <div class="top-text text-center">
      <h1>Tax Invoice</h1>
      <h2 class="top-head">Shekhawati Electronics Private Ltd</h2>
      <p class="top-phr">39/3, Site-IV Ind Area, Sahibabad, Ghazibad, Uttar pradesh India-201010<br>
        Phone:9911440398, Email:crm@zedexnissan.co.in CIN:U74899DL1984PTCO18299, GSTIN #: 09aaacs3634F1Z1,PAN: AAACS3634F </p>
    </div>
    <div class="row " style="
   border: 1px solid #ddd;
    width: 100%;
    margin: 0 auto;
">
      <div class="col-md-4 cust-border">
        <div class="cust-wrapper">
          <h2 class="cust-head">Customer Details</h2>
          <div class="cust-inner">
            <div class="row">
              <div class="col-xs-5"><b>Client name </b></div>
              <div class="col-xs-1">:</div>
              <div class="col-xs-6"><?php echo $invoice['client_name']; ?></div>
            </div>
            <div class="row">
              <div class="col-xs-5"><b>Client phone </b></div>
              <div class="col-xs-1">:</div>
              <div class="col-xs-6"><?php echo $invoice['client_phone']; ?></div>
            </div>
            <div class="row">
              <div class="col-xs-5"><b>Client email </b></div>
              <div class="col-xs-1">:</div>
              <div class="col-xs-6"><?php echo $invoice['client_email']; ?></div>
            </div>
            <div class="row">
              <div class="col-xs-5"><b>Client address </b></div>
              <div class="col-xs-1">:</div>
              <div class="col-xs-6"><?php echo $invoice['client_address']; ?></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 cust-border">
        <div class="cust-wrapper">
          <h2 class="cust-head">Vehicle Details</h2>
          <div class="cust-inner">
            <div class="row">
              <div class="col-xs-5"><b>Registration No  </b></div>
              <div class="col-xs-1">:</div>
              <div class="col-xs-6"><?php echo $invoice['vehicle_reg_no']; ?></div>
            </div>
             <div class="row">
              <div class="col-xs-5"><b>Brand </b></div>
              <div class="col-xs-1">:</div>
              <div class="col-xs-6"><?php echo $invoice['vehicle_brand_name']; ?></div>
            </div>
             <div class="row">
              <div class="col-xs-5"><b>Model </b></div>
              <div class="col-xs-1">:</div>
              <div class="col-xs-6"><?php echo $invoice['vehicle_model_name']; ?></div>
            </div>
             <div class="row">
              <div class="col-xs-5"><b>VIN </b></div>
              <div class="col-xs-1">:</div>
              <div class="col-xs-6"><?php echo $invoice['vehicle_vin_no']; ?></div>
            </div>
             <div class="row">
              <div class="col-xs-5"><b>KMS </b></div>
              <div class="col-xs-1">:</div>
              <div class="col-xs-6"><?php echo $invoice['vehicle_kms']; ?></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 cust-border">
        <div class="cust-wrapper">
          <h2 class="cust-head">Invoice Details</h2>
          <div class="cust-inner">
            <div class="row">
              <div class="col-xs-5"><b>Invoice </b></div>
              <div class="col-xs-1">:</div>
              <div class="col-xs-6"><?php echo $invoice['invoice_number']; ?></div>
            </div>
            <div class="row">
              <div class="col-xs-5"><b>Invoice Date </b></div>
              <div class="col-xs-1">:</div>
              <div class="col-xs-6"><?php echo date('d-m-Y',strtotime($invoice['date_created'])); ?></div>
            </div>
            <div class="row">
              <div class="col-xs-5"><b>Invoice Due Date </b></div>
              <div class="col-xs-1">:</div>
              <div class="col-xs-6"><?php echo date('d-m-Y',strtotime($invoice['due_date'])); ?></div>
            </div>
            <div class="row">
              <div class="col-xs-5"><b>SA Name </b></div>
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
    <table class="table">
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
</section>


<!-----------------Middle---------------->
<section class="middle">
  <div class="container">
    <table class="table">
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
</section>

<section class="bottom">
  <div class="container">
    <div class="row">
      <div class="col-sm-6">
        <h3>Notes</h3>
        <p><?php echo $invoice['notes']; ?></p>
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
              <td><?php echo $invoice['labour_total']; ?></td>
            </tr>
            <tr>
              <td>Total Parts </td>
              <td><?php echo $invoice['parts_total']; ?></td>
            </tr>
            <tr>
              <td>GST</td>
              <td><?php echo $invoice['gst_total']; ?></td>
            </tr>
            <tr>
              <td>Discount</td>
              <td><?php echo $invoice['discount_amount']; ?></td>
            </tr>
            <tr>
              <td>Grand Total</td>
              <td><?php echo $invoice['total_amount_after_discount']; ?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
