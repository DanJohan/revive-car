<?php $this->widget->beginBlock('stylesheets');?>
 	<link rel="stylesheet" href="<?= base_url() ?>public/plugins/datatables/dataTables.bootstrap.css"> 
<?php $this->widget->endBlock(); ?>
 <section class="content">
	 <div class="box">
		<div class="box-header">
			<div class="col-xs-6">
				<h3 class="box-title">Testimonials</h3>
			</div>
			
			<div class="col-xs-6 text-right">
				<a class="btn btn-default" href="<?php echo base_url();?>admin/testimonial/create">Add Testimonial</a>
			</div>
		</div>
		<!-- /.box-header -->
		<div class="box-body table-responsive">
			<table id="example1" class="table table-bordered table-striped ">
				<thead>
				<tr>
					<th>ID</th>
					<th>Author Name</th>
					<th>Author Designation</th>
					<th>Author Text</th>
					<th>Created at</th>
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
				url : config.baseUrl+'admin/testimonial/ajax_testimonial_list',
				type : "POST"
			},
			//'orderMulti':true,
			'columns':[
				{data:'id'},
				{data : 'author_name'},
				{data : 'author_designation'},
				{
					data : 'description',
					render :function (data,type,tow){
						return data.substring(0,50);
					}
				},
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
			                   /* '<li><a href="'+config.baseUrl+'admin/testimonial/show/'+row.id+'">View</a></li>'+*/
			                    '<li><a href="'+config.baseUrl+'admin/testimonial/edit/'+row.id+'">Edit</a></li>'+
			                    '<li><a href="'+config.baseUrl+'admin/testimonial/delete/'+row.id+'" onclick="return confirm(\'Are you sure to delete this record?\')">Delete</a></li>'+
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
		 
