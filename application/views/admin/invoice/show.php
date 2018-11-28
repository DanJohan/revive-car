   <section class="content">
    <div class="box">
      <div class="box-header">
         <h3 class="box-title">Invoice detail</h3>
     </div>

     <div class="box-body">
      <?php $this->load->view('common/invoice/invoice_detail',array('invoice'=>$invoice)); ?>
      <div class="table-responsive">
        <h2>Order items</h2>
        <table class="table table-bordered table-sm">
          <thead class="border">
            <tr>
              <th>SR</th>
              <th>Service name</th>
              <th>Price</th>
            </tr>
          </thead>
          <tbody>
              <?php $this->load->view('common/invoice/invoice_items',array('invoice'=>$invoice)); ?>
          </tbody>
        </table>
      </div>




      <div class="row">
        <div class="col-sm-6">
          <h3>Notes</h3>
          <p style="white-space: pre-line;"><?php echo $invoice['notes']; ?></p>
        </div>
        <div class="col-sm-6">
          <table class="table table-striped table-condensed">
            <thead>
              <tr>
                <th >Summary</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
             <?php $this->load->view('common/invoice/invoice_summary',array('invoice'=>$invoice)); ?>
            </tbody>
          </table>
        </div>
      </div>
</section>
<section class="content">
  <div class="box">
    <div class="box-body">
      <a href="<?php echo base_url();?>admin/invoice/list" class="btn btn-primary">Go back</a>
    </div>
  </div><!-- end of button box -->
</section>



