<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">View Blog</h3>
				</div>
				<!-- /.box-header -->
				<!-- form start -->
				<div class="box-body">
					<div class="panel panel-default">
					  <div class="panel-body">
					  		<h3 class="text-center"><?php echo $blog['title']; ?></h3>
					  		<div class="col-xs-12">
					  			<img src="<?php echo base_url(); ?>uploads/site/<?php echo $blog['image']; ?>" class= = "img-responsive img-thumbnail">
					  		</div>
					  		<div class="col-xs-12 mt-10">
					  			<?php echo $blog['description']?>
					  		</div>
					  </div>
					</div>
					<a href="<?php echo base_url(); ?>admin/blog/list" class="btn btn-primary">Go back</a>
				</div>
				<!-- /.box-body -->
			</div>
		</div>
	</div>  
</section>

 

