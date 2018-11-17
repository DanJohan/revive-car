<?php $this->widget->beginBlock('stylesheets');?>
 	<link rel="stylesheet" href="<?= base_url() ?>public/plugins/datatables/dataTables.bootstrap.css"> 
<?php $this->widget->endBlock(); ?>
 <section class="content">
	 <div class="box">
		<div class="box-header">
			<h3 class="box-title">Orders</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body table-responsive">
			<table id="example1" class="table table-bordered table-striped dataTable">
				<thead>
				<tr>
					<th>Order no</th>
					<th>Pick up date</th>
					<th>Pick up time</th>
					<th>Amount</th>
					<th>Paid</th>
					<th>Status</th>
					<th>Created at</th>
					<th>Option</th>
				</tr>
				</thead>

			 
			</table>
		</div>
	</div>
</section>  
<?php $this->load->view('common/modal'); ?>
<?php $this->widget->beginBlock('scripts'); ?>
<script type="text/javascript" src="<?php echo base_url(); ?>public/plugins/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/dist/js/moment.js"></script>
<script type="text/javascript">
	$(function () {
		$("#example1").DataTable({
			'order':[[0,'desc']],
			'serverSide' : true,
			'ajax' : {
				url : config.baseUrl+'admin/order/ajax_orders_list',
				type : "POST"
			},
			'columns':[
				{data:'order_no'},
				{
					data : 'pick_up_date',
					render : function(data,type,row){
						return moment(data).format("Do MMM YYYY");
					}
				},
				{
					data : 'pick_up_time',
				},
				{data : 'net_pay_amount'},
				{
					data : 'paid',
					render : function(data,type,row){
						if(data ==1){
							return '<label class="label label-success">Paid</label>';
						}else{
							return '<label class="label label-danger">Not paid</label>';
						}
					}
				},
				{
					data : 'status',
					render : function(data,type,row){
						if(data == 1){
							return '<label class="label label-warning">Pending</label>';
						}else if(data==2){
							return '<label class="label label-danger">Cancel</label>';
						}else if(data == 3){
							return '<label class="label label-success">Confirmed</label>';
						}
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
			                    '<li><a href="'+config.baseUrl+'admin/order/show/'+row.id+'">View</a></li>'+
			                    '<li><a href="javascript:void(0)" class="forword-to-workshop" data-order-id="'+row.id+'">Forward to workshop</a></li>'+
			                '</ul>'+
		            		'</div>';
		            		return html;
					}
				}
			]
		});
	});

	$(document).on('click','.forword-to-workshop',function(){
		var order_id = $(this).data('order-id');
		$.ajax({
			url:config.baseUrl+'admin/order/getManagarListForm',
			method:"POST",
			data:{'order_id':order_id},
			success:function(response){
				if(response.status){
					$('.modal-content').html(response.template);
					$('#basicModal').modal();
				}
			}
		});
	});
</script> 
<?php $this->widget->endBlock(); ?>
		 
