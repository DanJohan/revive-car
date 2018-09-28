<table class="table">
  <tr>
    <th>Item</th>
    <th>Quantity</th>
  </tr>
  <?php
  $vehicle_qtys=json_decode($job_card['vehicle_qty'],true);
//dd($car_properties,false);
  if(!empty($vehicle_qtys)){
    foreach ($vehicle_qtys as $index => $vehicle_qty) {
      ?>
      <tr><td><?php echo $vehicle_qty['item']; ?></td><td><?php echo $vehicle_qty['qty']; ?></td></tr>
      <?php
    }
  }
  ?>
</table>