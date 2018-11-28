            <?php 
            if(!empty($invoice['invoice_items'])) {
              $i=1;
              foreach ($invoice['invoice_items'] as $index => $data) {
                ?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <td><?php echo $data['item_name']; ?></td>
                  <td><?php echo $data['price']; ?></td>
                </tr>
                <?php
                $i++;
              } 
            }
            ?>
