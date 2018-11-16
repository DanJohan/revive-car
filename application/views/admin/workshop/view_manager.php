 <section class="content">
   <div class="box">
    <div class="box-header">
      <h3 class="box-title">Registered Manager</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
      <table id="example1" class="table table-bordered table-striped ">
        <thead>
        <tr>
          <th>Id</th>
          <th>Image</th>
          <th>Manager Name</th>
          <th>Email</th>
          <th>Mobile No.</th>
          
          <th>Created At</th>
          <th style="width: 150px;" class="text-right">Option</th>
        </tr>
        </thead>
        <tbody>
          
          <?php 
          if(!empty($all_manager)) {
            foreach($all_manager as $row) {
          ?>
      
          <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php if($row['m_photo']){?>
              <img class="photo_img_round" height="50" width="50" src="<?= base_url() ?>uploads/admin/<?= $row['m_photo']; ?>">
              <?php }else {?>
             <img class="photo_img_round" height="50" width="50" src="<?= base_url() ?>public/images/admin/no_image.jpeg">
             <?php } ?>
           </td>
            
            <td><?php echo $row['m_name']; ?></td>
            <td><?php echo $row['m_email']; ?></td>
            <td><?php echo $row['m_phone']; ?></td>
            <td><?php echo date('d M Y h:i A',strtotime($row['created_at'])); ?></td>

         
            <td class="text-right">
            	<div class="dropdown">
	                <button class="btn btn-primary dropdown-toggle" type="button" id="menu1" data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></button>
	                <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
	                    <li><a data-toggle="modal" id="view-detail" data-link="<?php echo  base_url('admin/workshop/view_record_by_id/'.$row['id']); ?>">View</a></li>
	                    <li><a href="<?php echo base_url('admin/workshop/edit_manager/'.$row['id']); ?>">Edit</a></li>
	                    <li><a href="<?php echo base_url('admin/workshop/del_manager/'.$row['id']); ?>" onclick="return confirm('Are you sure to delete this record?')">Delete</a></li>
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
<?php $this->load->view('common/modal');?>
<?php $this->widget->beginBlock('scripts'); ?>
<script type="text/javascript">
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
<script type="text/javascript">

$(document).on('click','#view-detail',function(){

  $.ajax({
    url:$(this).data('link'),
    method:"POST",
    success:function(response){
        if(response) {
          $('.modal-content').html(response);
          $('#basicModal').modal();
        }
    }
  });
});
</script>
<?php $this->widget->endBlock(); ?>    
