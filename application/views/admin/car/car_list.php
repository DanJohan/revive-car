<section class="content">
   <div class="box">
    <div class="box-header">
      <h3 class="box-title">Registered Users</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
      <table id="example1" class="table table-bordered table-striped ">
        <thead>
        <tr>
          <th>Car id</th>
          <th>User id</th>
          <th>Username</th>
          <th>Mobile No.</th>
           <th>Car</th>
           <th>Year</th>
           <th>Registration no</th>
          <th>Created At</th>
          <th style="width: 150px;" class="text-right">Option</th>
        </tr>
        </thead>
        <tbody>
          <?php foreach($cars as $car){ ?>
          <tr>
            <td><?php echo $car['id']; ?></td>
            <td><?php echo $car['user_id']; ?></td>
            <td><?php echo $car['name']; ?></td>
            <td><?php echo $car['phone']; ?></td>
            <td><?php echo $car['brand_name']."-".$car['model_name']; ?></td>
            <td><?php echo $car['year']; ?></td>
            <td><?php echo $car['registration_no']; ?></td>
            <td><?php echo date('d M Y h:i A',strtotime($car['created_at'])); ?></td>
           <td class="text-right">
              <a data-toggle="modal" id="view-detail" class="btn btn-success" data-toggle="tooltip" data-link="<?php echo base_url('admin/car/show/'.$car['id']); ?>" data-original-title="View"><i class="fa fa-eye"></i></a>
            <a class="btn btn-primary" data-toggle="tooltip" href="<?php echo base_url('admin/users/edit/'.$car['id']); ?>" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
            <a class="btn btn-danger" onclick="return confirm('Are you sure to delete this record?')" data-toggle="tooltip" href="<?= base_url('admin/users/del/'.$car['id']); ?>" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>
            
            </td>
          </tr>
          <?php } ?>
        </tbody>
       
      </table>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
</section>  
<?php $this->load->view('common/modal'); ?>
<script>
  $(function () {
    $("#example1").DataTable({
      'order':[[0,'desc']],
      "columnDefs": [
            {
                "targets": [0],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [1],
                "visible": false,
                "searchable": true
            }
        ]
    });
  });
</script> 
<script>
$("#view_users").addClass('active');

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
