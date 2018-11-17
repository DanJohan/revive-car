<?php $this->widget->beginBlock('stylesheets');?>
 	<link href="<?= base_url() ?>public/plugins/datatables/dataTables.bootstrap.css" type="text/css" rel="stylesheet" rel="stylesheet"> 
 	<link href="<?php echo base_url()?>public/dist/css/codemirror.min.css" type="text/css" >
    	<link href="<?php echo base_url()?>public/dist/css/code_view.min.css" rel="stylesheet" type="text/css" />
    	<link href="<?php echo base_url()?>public/dist/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
    	<link href="<?php echo base_url()?>public/dist/css/froala_style.min.css" rel="stylesheet" type="text/css" />
<?php $this->widget->endBlock(); ?>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Add Blog</h3>
				</div>
				<!-- /.box-header -->
				<!-- form start -->
				<div class="box-body">
					 
					<form id="add-service" class="form-horizontal" method="post" action="<?php echo base_url() . 'admin/blog/create'; ?>" enctype="multipart/form-data"> 
						<div class="form-group">
							<label for="firstname" class="col-sm-3 control-label">Title</label>

							<div class="col-sm-9">
								<input type="text" class="form-control" name="title" />
							</div>
						</div>
						<div class="form-group">
							<label for="firstname" class="col-sm-3 control-label">Description</label>

							<div class="col-sm-9">
								<textarea name="description" id="" class="floara-editor" cols="30" rows="10">sdfsdf</textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="firstname" class="col-sm-3 control-label">Image</label>

							<div class="col-sm-9">
								<div class="upload-btn-wrapper">
									<button class="upload-btn">Upload image</button><span class="upload-file-name"></span>
									<input type="file" class="upload-input" name="blog_image"/>
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
<script type="text/javascript" src="<?php echo base_url(); ?>public/dist/js/codemirror.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/dist/js/xml.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/dist/js/code_view.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/dist/js/froala_editor.pkgd.min.js"></script>
<script type="text/javascript">

	 $(document).ready(function(){
		 $('.price-field').number(true,2);
		 $(".floara-editor").froalaEditor({
		 	height:200,
		 	toolbarInline: false
		 }); 
/*
		$("#add-service").validate({
			errorClass: "error",
			rules: {
				expire_at:{
					required:true
				},
				coupan_code: {
					required: true,
				},
				coupan_price: {
					required: true,
					number: true
				},
				service:{
					required:true
				}
		}
	 	});*/
	});// end of ready function
</script>
<?php $this->widget->endBlock('scripts');?>
 

