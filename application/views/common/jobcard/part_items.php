            <?php 
            if(!empty($invoice['parts'])){
             $i=1;
             $parts_sum=0;
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
              $parts_sum +=$data['invoice_parts_total']; 
              $i++;
            }
          } 
          ?>
          <tr>
            <th colspan="5">Total</th>
            <th>&#x20b9;&nbsp;<?php echo number_format($parts_sum,'2','.',''); ?></th>
          </tr>