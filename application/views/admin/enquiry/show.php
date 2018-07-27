 <!-- Datatable style -->
<link rel="stylesheet" href="<?= base_url() ?>public/plugins/datatables/dataTables.bootstrap.css">  

 <section class="content">
   <div class="box">
    <div class="box-header">
      <h3 class="box-title">Customer enquiry</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table class="table">
            <tr>
                <td><b>User Name</b></td>
                <td><?php echo $enquiry['name']; ?></td>
            </tr>
             <tr>
                <td><b>Car</b></td>
                <td><?php echo $enquiry['brand_name']; ?></td>
            </tr>
             <tr>
                <td><b>Model</b></td>
                <td><?php echo $enquiry['model_name']; ?></td>
            </tr>
             <tr>
                <td><b>Address</b></td>
                <td><?php echo $enquiry['address']; ?></td>
            </tr>
             <tr>
                <td><b>Loaner vehicle</b></td>
                <td><?php echo ($enquiry['loaner_vehicle'])?'Required':'Not required'; ?></td>
            </tr>
             <tr>
                <td><b>Enquiry</b></td>
                <td><?php echo $enquiry['enquiry']; ?></td>
            </tr>
             <tr>
                <td><b>Images</b></td>
                <td>
                    <?php 
                      if(!empty($enquiry['image_id'])) {
                        $image_id = explode('|', $enquiry['image_id']);
                        $images = explode('|', $enquiry['images']);
                        foreach ($image_id as $index => $id) {
                      ?>
                          <div>
                              <img src="<?php echo base_url().'uploads/app/'.$images[$index]; ?>" height="400" />
                          </div>
                      <?php
                        }
                      }
                    ?>
                   
                 </td>
            </tr>
        </table>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
</section>  

      
