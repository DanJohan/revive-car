 <section class="content">
  <div class="row">
    <div class="col-xs-6">
      <div class="box">
        <div class="box-header bg-green">
         <h3 class="box-title">Customer detail</h3>
       </div>

       <div class="box-body">
		   <?php $this->load->view('common/jobcard/jobcard_user_detail'); ?>
      </div>
    </div><!-- end of user detail box -->

  </div>
  <div class="col-xs-6">
    <div class="box">
      <div class="box-header bg-green">
       <h3 class="box-title">Vehicle detail</h3>
     </div>

     <div class="box-body">
		<?php $this->load->view('common/jobcard/jobcard_vehicle_detail'); ?>
    </div>
  </div><!-- end of vehicle detail box -->
</div>
</div>
<div class="box">
  <div class="box-header bg-green">
    <h3 class="box-title">Repair orders</h3>
  </div>
  <div class="box-body">
    <div class="table-responsive">
      <table class="table ">
        <thead>
          <tr>
            <th>S.No.</th>
            <th>Customer Request</th>
            <th>S.A  Remarks</th>
            <th>Parts Name</th>
            <th> Qty</th>
            <th>Status</th>
<!--             <th>Parts Price</th>
<th>Labour Price</th>
<th>Total Price</th> -->
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $repair_orders = $job_card['repair_orders'];
          if(!empty($repair_orders)) {
            $i=1;
            foreach ($repair_orders as $index => $repair_order) {
              ?>
              <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $repair_order['customer_request']; ?></td>
                <td><?php echo $repair_order['sa_remarks']; ?></td>
                <td><?php echo $repair_order['parts_name']; ?></td>
                <td><?php echo $repair_order['qty']; ?></td>
                <td>
                  <?php 
                    if($repair_order['status']==0){
                      echo "<span class='label label-danger'>Pending</span>";
                    }elseif($repair_order['status']==1){
                      echo "<span class='label label-warning'>Processing</span>";
                    }elseif($repair_order['status']==2){
                      echo "<span class='label label-success'>completed</span>";
                    }
                  ?>
                  
                </td>
<!--                 <td><?php //echo number_format($repair_order['price_parts'],2,'.',','); ?></td>
<td><?php //echo number_format($repair_order['price_labour'],2,'.',','); ?></td>
<td><?php //echo number_format($repair_order['price_total'],2,'.',','); ?></td> -->
                <td>
                  <div class="dropdown">
                    <button class="btn btn-success dropdown-toggle" type="button" id="menu1" data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></button>
                    <ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="menu1">
                         <li> <a href="javascript:void(0)" class="edit-job" data-job-card-id="<?php echo $job_card['id']; ?>" data-user-id="<?php echo $job_card['user_id']; ?>" data-job-id="<?php echo $repair_order['repair_order_id']; ?>">Edit</a></li>
                         <li> <a href="javascript:void(0)" class="job-status" data-job-card-id="<?php echo $job_card['id']; ?>" data-user-id="<?php echo $job_card['user_id']; ?>" data-job-id="<?php echo $repair_order['repair_order_id']; ?>">Change status</a></li>
                    </ul>
                  </div>
                </td>
              </tr>
              <?php
              $i++;
            }
          }
          ?>

        </tbody>
        <tfoot>
          <tr>

          </tr>
        </tfoot>
      </table>
    </div><!--end of .table-responsive-->
  </div>
</div><!-- end of repair order box -->

<div class="box">
  <div class="box-header bg-green">
    <h3 class="box-title">Add Repair orders</h3>
  </div>
  <div class="box-body">
   <form id="order-form" method="post" class="form-horizontal" action="<?php echo base_url()?>workshop/jobCard/addOrder">
    <input type="hidden" name="job_card_id" value="<?php echo $job_card['id']; ?>">
    <input type="hidden" name="user_id" value="<?php echo $job_card['user_id']; ?>">
    <div class="form-group">
      <label class="control-label col-sm-2" for="customer_request">Customer Request:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="customer_request" id="customer_request">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="sa_remarks">S.A Remarks:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="sa_remarks" id="sa_remarks">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="parts_name">Parts Name:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="parts_name" id="parts_name">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="qty">Quantity:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="quantity" id="qty">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="parts_price">Parts price:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="parts_price" id="parts_price">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="labour_price">Labour price:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="labour_price" id="labour_price">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="total_price">Total price:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="total_price" id="total_price">
      </div>
    </div>
    <div class="col-xs-offset-2">
      <button type="submit" class="btn btn-success">Submit</button>
    </div>
  </form>
</div>
</div><!-- end of repair order box -->

<div class="box">

  <div class="box-body">
    <a href="<?php echo base_url();?>workshop/jobCard/list" class="btn btn-success">Go back</a>
  </div>
</div><!-- end of button box -->

</section>
<?php $this->load->view('common/modal'); ?>
<?php $this->widget->beginBlock('scripts'); ?>
<script src="<?php echo base_url() ?>public/dist/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url() ?>public/dist/js/pages/complete-job.js"></script>
<?php $this->widget->endBlock(); ?>



