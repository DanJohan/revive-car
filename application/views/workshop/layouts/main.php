<!DOCTYPE html>
<html lang="en">
	<head>
		  <title><?=isset($title)?$title:'Workshop Management System' ?></title>
		  <!-- Tell the browser to be responsive to screen width -->
		  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		  <!-- Bootstrap 3.3.6 -->
		  <link rel="stylesheet" href="<?= base_url() ?>public/bootstrap/css/bootstrap.min.css">
		  <!-- Font Awesome -->
		  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
		  <!-- Ionicons -->
		  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
		  <!-- Theme style -->
	      <link rel="stylesheet" href="<?= base_url() ?>public/dist/css/AdminLTE.min.css">
	           <!-- Datatable style -->
		  <link rel="stylesheet" href="<?= base_url() ?>public/plugins/datatables/dataTables.bootstrap.css"> 
		  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		     <link rel="stylesheet" href="<?= base_url() ?>public/vendor/alertifyjs/css/alertify.css"> 
	       <!-- Custom CSS -->
		  <link rel="stylesheet" href="<?= base_url() ?>public/dist/css/style.css">
		  <!-- AdminLTE Skins. Choose a skin from the css/skins. -->
		  <link rel="stylesheet" href="<?= base_url() ?>public/dist/css/skins/skin-green.min.css">


		  <?php $this->widget->beginBlock('stylesheets',true); ?>
		  <?php $this->widget->endBlock(); ?>

		   <script>
				var config = {
					'baseUrl':"<?php echo base_url(); ?>",
					'siteUrl' : "<?php echo site_url(); ?>"
				}
		  </script>
		
	</head>
	<body class="hold-transition skin-green sidebar-mini">
		<div class="wrapper" style="height: auto;">
			
			<section id="container">
				<!--header start-->
				<header class="header white-bg">
					<?php $this->load->view('workshop/include/navbar.php'); ?>
				</header>
				<!--header end-->
				<!--sidebar start-->
				<aside>
					<?php $this->load->view('workshop/include/sidebar.php'); ?>
				</aside>
				<!--sidebar end-->
				<!--main content start-->
				<section id="main-content">
					<div class="content-wrapper" style="min-height: 394px; padding:15px;">
						<!-- page start-->
						<?php echo $content;?>
						<!-- page end-->
					</div>
				</section>
				<!--main content end-->
				<!--footer start-->
				<footer class="main-footer">
					<strong>Copyright © 2018 <a href="javascript:void(0);">Smart Serve Infotech</a></strong> All rights
					reserved.
				</footer>
				<!--footer end-->
			</section>

			<!-- /.control-sidebar -->
			<?php $this->load->view('workshop/include/control_sidebar.php'); ?>

	</div>	
    <script type="text/javascript" src="<?php echo base_url() ?>public/dist/js/jquery3.3.1.min.js"></script>	
	<script type="text/javascript" src="<?php echo base_url() ?>public/dist/js/jquery-ui.min.js"></script>	
	<script type="text/javascript" src="<?php echo base_url(); ?>public/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>public/dist/js/app.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>public/dist/js/demo.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>public/plugins/datatables/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>public/plugins/datatables/dataTables.bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>public/dist/js/jquery.validate.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/dist/js/jquery.number.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>public/vendor/alertifyjs/alertify.min.js"></script>
<script type="text/javascript">
	var current_url = window.location.href;
	$('.treeview-menu a').each(function(){
		if($(this).attr('href')== current_url){
			$(this).parent('li').addClass('active');
			//$(this).parents('li.treeview').addClass('active');
		}
	});
</script>
<?php $this->widget->beginBlock('scripts', true); ?>
<?php $this->widget->endBlock(); ?>
<?php $this->load->view('common/flashmessage'); ?>
	</body>
</html>
