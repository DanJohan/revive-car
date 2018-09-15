<style>

div.top-main-head{
    font-size: 18px;
    font-weight: bold;
    text-align: center;
}
div.top-head {
    border: 1px solid #ddd;
    background-color: #ededed;
    vertical-align: middle;
    font-size: 16px;
    font-weight: bold;
    text-align: center;
}

div.top-phr{
  text-align: center;
}

.item-table, th {
    border: 1px solid black;
}

.item-table {
    border-collapse: collapse;
    width: 100%;
}
.text-center{
  text-align: center;
}
.text-bold{
  font-weight: bold;
}



</style>
<div>
      <div class="text-center"><img src="<?php base_url()?>public/images/revive-logo.png" style="width:100px;height: 50px;"></div>
      <div class="top-main-head">Tax Invoice</div>
      <div class="top-head">Revive auto car care</div>
      <div class="top-phr">9/11 Near Atul Kataria Chowk Kila No. , Opp Huda Nursery,
Sector 17A, Gurgaon, Haryana-122001 GSTIN: 06AFVPJ6337B1ZD 
Email:customercare@reviveauto.in</div>
</div>
<!--=======TOP-SEC==========-->
<div>

    <table class="item-table">
      <tr>
        <th class="text-center text-bold">Customer Details</th>
        <th class="text-center text-bold">Vehicle Details</th>
        <th class="text-center text-bold">Invoice Details</th>
      </tr>
      <tr>
        <td>
            <table>
              <tr>
                <td><b>Client name </b>:</td>
                <td><?php echo $invoice['client_name']; ?></td>
              </tr>
              <tr>
                <td><b>Client phone </b>:</td>
                <td><?php echo $invoice['client_phone']; ?></td>
              </tr>
              <tr>
                <td><b>Client email </b>:</td>
                <td><?php echo $invoice['client_email']; ?></td>
              </tr>
              <tr>
                <td><b>Client address </b>:</td>
                <td><?php echo $invoice['client_address']; ?></td>
              </tr>
            </table>
        </td>
        <td>
            <table>
            <tr>
              <td><b>Registration No </b>:</td>
              <td><?php echo $invoice['vehicle_reg_no']; ?></td>
            </tr>
            <tr>
              <td><b>Brand </b>:</td>
              <td><?php echo $invoice['vehicle_brand_name']; ?></td>
            </tr>
            <tr>
              <td><b>Model </b>:</td>
              <td><?php echo $invoice['vehicle_model_name']; ?></td>
            </tr>
            <tr>
              <td><b>VIN </b>:</td>
              <td><?php echo $invoice['vehicle_vin_no']; ?></td>
            </tr>
            <tr>
              <td><b>KMS </b>:</td>
              <td><?php echo $invoice['vehicle_kms']; ?></td>
            </tr>
          </table>
      </td>
        <td>
          <table>
          <tr>
            <td><b>Invoice No </b>:</td>
            <td><?php echo $invoice['invoice_number']; ?></td>
          </tr>
          <tr>
            <td><b>Invoice Date </b>:</td>
            <td><?php echo date('d-m-Y',strtotime($invoice['date_created'])); ?></td>
          </tr>
          <tr>
            <td><b>Invoice Due Date </b>:</td>
            <td><?php echo date('d-m-Y',strtotime($invoice['due_date'])); ?></td>
          </tr>
          <tr>
            <td><b>SA Name </b>:</td>
            <td><?php echo $invoice['sa_name']; ?></td>
          </tr>
        </table>
      </td>
      </tr>
    </table>
</div>

  <div>
    <table class="item-table">
        <tr>
          <th style="width: 5%;" class="text-center text-bold">SR</th>
          <th style="width: 45%;" class="text-center text-bold">Labor</th>
          <th style="width: 10%;" class="text-center text-bold">Hour</th>
          <th style="width: 10%;" class="text-center text-bold">Rate/Day</th>
          <th style="width: 10%;" class="text-center text-bold">Cost</th>
          <th style="width: 10%;" class="text-center text-bold">GST (%)</th>
          <th style="width: 10%;" class="text-center text-bold">Total Amount</th>
        </tr>
        <?php 
          if(!empty($invoice['labour'])) {
              $i=1;
             foreach ($invoice['labour'] as $index => $data) {
        ?>
          <tr>
            <td><?php echo $i.'.'; ?></td>
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
        <tr>
          <th class="text-bold" colspan="6">Total</th>
          <th class="text-bold"><?php echo $invoice['labour_total']; ?></th>
        </tr>
    </table>
</div>


<!-----------------Middle---------------->
<div>
    <table class="item-table">
        <tr>
          <th style="width: 5%;" class="text-center text-bold">SR</th>
          <th style="width: 55%;" class="text-center text-bold">Parts</th>
          <th style="width: 10%;" class="text-center text-bold">Quantity</th>
          <th style="width: 10%;" class="text-center text-bold">Cost</th>
          <th style="width: 10%;" class="text-center text-bold">GST (%)</th>
          <th style="width: 10%;" class="text-center text-bold">Total</th>
        </tr>
        <?php 
          if(!empty($invoice['parts'])){
             $i=1;
             foreach ($invoice['parts'] as $index => $data) {
          ?>
          <tr>
            <td><?php echo $i.'.'; ?></td>
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
        <tr>
          <th class="text-bold" colspan="5">Total</th>
          <th class="text-bold"><?php echo $invoice['parts_total']; ?></th>
        </tr>
    </table>
</div>

<div nobr="true">
  <table class="item-table">
      <tr>
        <th colspan="2" class="text-bold text-center">Summary</th>
      </tr>
      <tr>
        <td class="text-bold">Total labour</td>
        <td><?php echo $invoice['labour_total']; ?></td>
      </tr>
      <tr>
        <td class="text-bold">Total Parts </td>
        <td><?php echo $invoice['parts_total']; ?></td>
      </tr>
      <tr>
        <td class="text-bold">GST</td>
        <td><?php echo $invoice['gst_total']; ?></td>
      </tr>
      <tr>
        <td class="text-bold">Discount</td>
        <td><?php echo $invoice['discount_amount']; ?></td>
      </tr>
      <tr>
        <td class="text-bold" >Grand Total</td>
        <td><?php echo $invoice['total_amount_after_discount']; ?></td>
      </tr>
  </table>
</div>

<div nobr="true">
  <h3>Notes</h3>
<?php echo nl2br($invoice['notes']); ?>
</div>
