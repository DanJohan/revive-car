<table class="table">
<?php
    $car_properties=json_decode($job_card['car_properties'],true);
    //dd($car_properties,false);
    if(!empty($car_properties)){
      foreach ($car_properties as $index => $car_property) {
  ?>
  <tr><td><b><?php echo $car_property['name']; ?></b>:</td><td><?php echo $car_property['value']; ?></td></tr>
  <?php
      }
    }
?>
</table>