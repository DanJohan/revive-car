<?php $this->widget->beginBlock('stylesheets');?>
 	<link rel="stylesheet" href="<?= base_url() ?>public/plugins/datatables/dataTables.bootstrap.css"> 
<?php $this->widget->endBlock(); ?>
 <section class="content">
   <div class="box">
    <div class="box-header">
      <h3 class="box-title">Registered Customers</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
      <table id="example1" class="table table-bordered table-striped ">
        <thead>
        <tr>
          <th>User id</th>
          <th>Username</th>
          <th>Email</th>
          <th>Mobile No.</th>
         <!--  <th>Device</th> -->
          <th>Created At</th>
          <th>Option</th>
        </tr>
        </thead>

       
      </table>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
</section>
<?php $this->load->view('common/modal'); ?>
<?php $this->widget->beginBlock('scripts')?>
<script type="text/javascript" src="<?php echo base_url(); ?>public/plugins/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/dist/js/moment.js"></script>
<script>
  $(function () {
    $("#example1").DataTable({
      	'order':[[0,'desc']],
      	'stateSave' : true,
      	'serverSide' : true,
		'ajax' : {
			url : config.baseUrl+'admin/users/ajax_users_list',
			type : "POST"
		},
		'columns':[
			{data:'id'},
			{data : 'name'},
			{data : 'email'},
			{data : 'phone'},
			{
				data : 'created_at',
				render: function(data, type, row){
           			return moment(data).format("Do MMM YYYY, h:mm A");
       			}
       		},
			{
				mRender : function(data, type, row) {
					var html = '<div class="dropdown">'+
		                '<button class="btn btn-primary dropdown-toggle" type="button" id="menu1" data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></button>'+
		                '<ul class="dropdown-menu" role="menu" aria-labelledby="menu1">'+
		                    '<li><a href="'+config.baseUrl+'admin/users/show/'+row.id+'">View</a></li>'+
		                    '<li><a href="'+config.baseUrl+'admin/users/edit/'+row.id+'">Edit</a></li>'+
		                    '<li><a href="'+config.baseUrl+'admin/users/del/'+row.id+'" onclick="return confirm(\'Are you sure to delete this record?\')">Delete</a></li>'+
		                '</ul>'+
	            		'</div>';
	            		return html;
				}
			}
		]
    });
  });
</script> 
<?php $this->widget->endBlock(); ?>
     
