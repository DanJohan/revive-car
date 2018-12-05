            <?php 
            if(!empty($invoice['labour'])) {
              $i=1;
              $labour_sum=0;
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
                $labour_sum += $data['invoice_labour_total'];
                $i++;
              } 
            }
            ?>

            <tr>
              <th colspan="6">Total</th>
              <th>&#x20b9;&nbsp;<?php echo number_format($labour_sum,'2','.',''); ?></th>
            </tr>