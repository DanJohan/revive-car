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
      <div class="top-head">Revive Auto Care</div>
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
          <th  class="text-center text-bold">SR</th>
          <th  class="text-center text-bold">Service name</th>
          <th  class="text-center text-bold">Price</th>
        </tr>
        <?php 
          if(!empty($invoice['invoice_items'])) {
              $i=1;
              $labour_sum=0;
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
    </table>
</div>




<div nobr="true">
  <table class="item-table">
      <tr>
        <th colspan="2" class="text-bold text-center">Summary</th>
      </tr>
      <tr>
        <td class="text-bold">Sub total</td>
        <td><?php echo $invoice['sub_total']; ?></td>
      </tr>
      <tr>
        <td class="text-bold">Discount Amount  </td>
        <td><?php echo $invoice['discount_amount']; ?></td>
      </tr>
      <tr>
        <td class="text-bold">Total amount</td>
        <td><?php echo $invoice['total_amount']; ?></td>
      </tr>
      <tr>
        <td class="text-bold">GST</td>
        <td><?php echo $invoice['gst_amount']; ?></td>
      </tr>
      <tr>
        <td class="text-bold" >Grand Total</td>
        <td><?php echo $invoice['total_pay_amount']; ?></td>
      </tr>
  </table>
</div>

<div nobr="true">
  <h3>Notes</h3>
<?php echo nl2br($invoice['notes']); ?>
</div>
