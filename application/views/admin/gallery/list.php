<section class="content">
	 <div class="box">
		<div class="box-header">
			<div class="col-xs-6">
				<h3 class="box-title">Gallery Images</h3>
			</div>
			
			<div class="col-xs-6 text-right">
				<a class="btn btn-default" href="<?php echo base_url();?>admin/gallery/create">Upload Images</a>
			</div>
		</div>
		<!-- /.box-header -->
		<div class="box-body table-responsive">
			<div class="row">
			<?php 
				if(!empty($gallery_images)) {
					foreach ($gallery_images as $index => $gallery) {
			?>
				<div class="col-xs-4">
	                    <div class="thumbnail">
	                    	<a href="<?php echo base_url().'uploads/site/'.$gallery['image']; ?>" target="_blank">
		                         <img class="img-responsive" src="<?php echo base_url().'uploads/site/'.$gallery['image']; ?>" style="height:200px;width:100%;" />
		                         <div class="caption">
					          	<a href="<?php echo base_url(); ?>admin/gallery/delete/<?php echo $gallery['id'].'/'.$gallery['image']; ?>" class="btn btn-primary" onclick="return confirm('Are you sure to delete this record?')">Delete</a>
					        	</div>
					     </a>
	                    </div>
	               </div>
			<?php
						if(($index+1)%3==0){
							echo '</div><div class="row mt-10">';
						}
					}
				}else{
					echo "<h3 class='text-center'>No image found!</h3>";
				}
			?>
			</div>
		</div>
		<!-- /.box-body -->
	</div>
	<!-- /.box -->
</section>  

		 
