<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Edit Testimonial</h3>
				</div>
				<!-- /.box-header -->
				<!-- form start -->
				<div class="box-body">
					 
					<form id="blog-form" class="form-horizontal" method="post" action="<?php echo base_url() . 'admin/testimonial/edit/'.$testimonial['id']; ?>" enctype="multipart/form-data"> 
						<div class="form-group">
							<label for="firstname" class="col-sm-3 control-label">Author Name</label>

							<div class="col-sm-9">
								<input type="text" class="form-control" name="author_name" value="<?php echo ($testimonial['author_name']) ? $testimonial['author_name'] : ''; ?>" />
								<div class="form-error"></div>
							</div>
						</div>
						<div class="form-group">
							<label for="firstname" class="col-sm-3 control-label">Author Designation</label>

							<div class="col-sm-9">
								<input type="text" class="form-control" name="author_designation" value="<?php echo $testimonial['author_designation'] ? $testimonial['author_designation'] : ''; ?>"/>
								<div class="form-error"></div>
							</div>
						</div>
						<div class="form-group">
							<label for="firstname" class="col-sm-3 control-label">Author text</label>

							<div class="col-sm-9">
								<textarea name="author_text" id="editor" class="form-control"  cols="30" rows="5"><?php echo $testimonial['description'] ? $testimonial['description'] : ''; ?></textarea>
								<div class="form-error"></div>

							</div>
						</div>
						<div class="form-group">
							<label for="firstname" class="col-sm-3 control-label">Author Image</label>

							<div class="col-sm-9">
								<div class="row">
									<div class="upload-btn-wrapper col-xs-6">
										<button class="upload-btn">Upload image</button><span class="upload-file-name"></span>
										<input type="file" class="upload-input" name="author_image"/>
										<div class="form-error"></div>
									</div>
									<div class="col-xs-6">
										<img src="<?php echo base_url(); ?>uploads/site/<?php echo $testimonial['author_image']; ?>" class= "img-responsive img-thumbnail" height="200" width="300">
									</div>
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

		$("#blog-form").validate({
			errorClass: "error",
			errorPlacement: function(error, element) {
				error.appendTo(element.parents('.form-group').find('.form-error'));
			},
			rules: {
				author_name:{
					required:true
				},
				author_designation: {
					required: true,
				},
				author_text: {
					required: true,
				}
			}
	 	});
	});// end of ready function
</script>
<?php $this->widget->endBlock('scripts');?>
 

