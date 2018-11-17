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
					<th>Service id</th>
					<!-- <th>Image</th> -->
					<th>Service Name</th>
					<th>Service Category</th>
					<th style="width: 10%;">Manufacturer Name</th>
					<th style="width: 10%;">Model Name</th>
					<th style="width: 10%;">Price</th>
					<th>Created At</th>
					<th class="text-right">Option</th>
				</tr>
				</thead>

			 
			</table>
		</div>
		<!-- /.box-body -->
	</div>
	<!-- /.box -->
</section>  
<?php $this->load->view('common/modal'); ?>
<?php $this->widget->beginBlock('scripts'); ?>
<script type="text/javascript" src="<?php echo base_url(); ?>public/plugins/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/dist/js/moment.js"></script>
<script>
	$(function () {
		$("#example1").DataTable({
			'order':[[0,'desc']],
			'serverSide' : true,
			'ajax' : {
				url : config.baseUrl+'admin/service/services_list',
				type : "POST"
			},
			//'orderMulti':true,
			'columns':[
				{data:'id'},
				{data : 'name'},
				{data : 'category_name'},
				{data : 'brand_name'},
				{data : 'model_name'},
				{data : 'price'},
				{
					data : 'created_at',
					render: function(data, type, row){
						console.log(data,type,row);
                			return moment(data).format("MMMM Do YYYY, h:mm:ss a");
            			}
            		},
				{
					mRender : function(data, type, row) {
						var html = '<div class="dropdown">'+
			                '<button class="btn btn-primary dropdown-toggle" type="button" id="menu1" data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></button>'+
			                '<ul class="dropdown-menu" role="menu" aria-labelledby="menu1">'+
			                    '<li><a href="'+config.baseUrl+'admin/service/change_price/'+row.id+'">Change Price</a></li>'+
			                    '<li><a href="'+config.baseUrl+'admin/service/add_coupan/'+row.id+'">Add Coupan</a></li>'+
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
		 
