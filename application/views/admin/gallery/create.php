<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Add Gallery image</h3>
				</div>
				<!-- /.box-header -->
				<!-- form start -->
				<div class="box-body">
					 
					<form id="gallery-form" class="form-horizontal" method="post" action="<?php echo base_url() . 'admin/gallery/create'; ?>" enctype="multipart/form-data"> 
						<div class="form-group">
							<label for="firstname" class="col-sm-3 control-label">Title</label>

							<div class="col-sm-9">
								<input type="text" class="form-control" name="title" />
								<div class="form-error"></div>
							</div>
						</div>
						<div class="form-group">
							<label for="firstname" class="col-sm-3 control-label">Image</label>

							<div class="col-sm-9">
								<div class="upload-btn-wrapper">
									<button class="upload-btn">Upload image</button><span class="upload-file-name"></span>
									<input type="file" class="upload-input" name="gallery_image"/>
									<div class="form-error"></div>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-6">
								<input type="submit" name="submit" value="Submit" class="btn btn-info">
							</div>
						</div>
				</form>
			</div>
					<!-- /.box-body -->
		</div>
	</div>
</div>  

</section>
<?php $this->widget->beginBlock('scripts');?>
<script src="<?php echo base_url(); ?>public/dist/js/jquery.validate.min.js"></script>
<script type="text/javascript">

	 $(document).ready(function(){

		$("#gallery-form").validate({
			errorClass: "error",
			errorPlacement: function(error, element) {
				error.appendTo(element.parents('.form-group').find('.form-error'));
			},
			rules: {
				gallery_image: {
					required: true,
				}
			}
	 	});
	});// end of ready function
</script>
<?php $this->widget->endBlock('scripts');?>
 

