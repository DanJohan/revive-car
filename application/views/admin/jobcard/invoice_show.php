   <section class="content">
    <div class="box">
      <div class="box-header">
         <h3 class="box-title">Invoice detail</h3>
     </div>

     <div class="box-body">
        <?php $this->load->view('common/jobcard/invoice_detail',array('invoice'=>$invoice)); ?>
      <div class="table-responsive">
        <h2>Labour items</h2>
        <table class="table table-bordered table-sm">
          <thead class="border">
            <tr>
              <th>SR</th>
              <th>Labor</th>
              <th>Hour</th>
              <th>Rate/Day</th>
              <th>Cost</th>
              <th>GST (%)</th>
              <th>Total Amount</th>
            </tr>
          </thead>
          <tbody>
            <?php $this->load->view('common/jobcard/labour_items',array('invoice'=>$invoice)); ?>
          </tbody>
        </table>
      </div>


      <div class="table-responsive">
        <h2>Parts items</h2>
        <table class="table table-bordered ">
          <thead class="border">
            <tr>
              <th>SR</th>
              <th>Parts</th>
              <th>Quantity</th>
              <th>Cost</th>
              <th>GST (%)</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            <?php $this->load->view('common/jobcard/part_items',array('invoice'=>$invoice)); ?>
        </tbody>
      </table>
    </div>

      <div class="row">
        <div class="col-sm-6">
          <h3>Notes</h3>
          <p style="white-space: pre-line;"><?php echo $invoice['notes']; ?></p>
        </div>
        <div class="col-sm-6">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Summary</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
                <?php $this->load->view('common/jobcard/invoice_summary',array('invoice'=>$invoice)); ?>
            </tbody>
          </table>
        </div>
      </div>
</section>
<section class="content">
  <div class="box">
    <div class="box-body">
      <a href="<?php echo base_url();?>admin/jobCard/invoiceList" class="btn btn-primary">Go back</a>
    </div>
  </div><!-- end of button box -->
</section>



