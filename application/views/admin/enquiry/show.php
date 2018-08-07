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
                    <div class="row">
                    <?php 
                      if(!empty($enquiry['image_id'])) {
                        $image_id = explode('|', $enquiry['image_id']);
                        $images = explode('|', $enquiry['images']);
                        foreach ($image_id as $index => $id) {
                      ?>
                          <div class="col-md-4">
                            <div class="image-responsive">
                                <img class="img-thumbnail" src="<?php echo base_url().'uploads/app/'.$images[$index]; ?>" width="200" />
                            </div>
                          </div>
                      <?php
                          if(($index+1) % 3 == 0) {
                            echo "</div><div class='row'>";
                          }
                        }
                      }
                    ?>
                   
                 </td>
            </tr>
            <tr><td><a href="<?php echo base_url(); ?>admin/enquiry/confirm/<?php echo $enquiry['id']; ?>" class="btn btn-primary">Confirm</a></td></tr>
        </table>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
</section>  

      
