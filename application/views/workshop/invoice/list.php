 <section class="content">
   <div class="box">
    <div class="box-header bg-green">
      <h3 class="box-title">Invoices</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
      <table id="example1" class="table table-bordered table-striped ">
        <thead>
        <tr>
          <th>Invoice id</th>
          <th>User id</th>
          <th>Invoice no</th>
          <th>Username</th>
          <th>Phone</th>
          <th>Registration no.</th>
          <th>Forward to customer</th>
          <th>Paid</th>
          <th>Created At</th>
          <th class="text-right">Option</th>
        </tr>
        </thead>
        <tbody>
          
          <?php 
          if(!empty($invoices)) {
            foreach($invoices as $index=>$invoice) {
          ?>
      
          <tr>
            <td><?php echo $invoice['id']; ?></td>
            <td><?php echo $invoice['user_id']; ?></td>
            <td><?php echo $invoice['invoice_number']; ?></td>
            <td><?php echo $invoice['client_name']; ?></td>
            <td><?php echo $invoice['client_phone']; ?></td>
            <td><?php echo $invoice['vehicle_reg_no']; ?></td>
            <td><?php echo ($invoice['fwd_to_customer'])?'<span class="label label-success">Yes</span>':'<span class="label label-danger">No</span>'; ?></td>
            <td><?php echo ($invoice['paid'])?'<span class="label label-success">Yes</span>':'<span class="label label-danger">No</span>'; ?></td>
            <td><?php echo date('d M Y h:i A',strtotime($invoice['created_at'])); ?></td>

         
            <td class="text-right">
              <div class="dropdown">
                <button class="btn btn-success dropdown-toggle" type="button" id="menu1" data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></button>
                <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                    <li><a href="<?php echo  base_url('workshop/invoice/show/'.$invoice['id']); ?>">View</a></li>
                   <!--  <li><a href="<?php //echo base_url('workshop/jobCard/invoiceEdit/'.$invoice['id'])?>">Edit</a></li> -->
                    <li><a href="<?php echo base_url('workshop/invoice/invoiceFwdToCust/'.$invoice['id'].'/'.$invoice['hash'])?>">Forward to customer</a></li>
                </ul>
            </div>
          </tr>
          <?php
               }
            } 
          ?>
        </tbody>
       
      </table>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
</section>  
<?php $this->widget->beginBlock('scripts'); ?>
<script>
  $(function () {
    $("#example1").DataTable({
      'order':[[0,'desc']],
      "columnDefs": [
            {
                "targets": [0],
                "visible": false,
                "searchable": false
            }
        ]
    });
  });
</script> 
<?php $this->widget->endBlock(); ?>

      
