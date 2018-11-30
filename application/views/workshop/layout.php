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
	       <!-- Custom CSS -->
		  <link rel="stylesheet" href="<?= base_url() ?>public/dist/css/style.css">
		  <!-- AdminLTE Skins. Choose a skin from the css/skins. -->
		  <link rel="stylesheet" href="<?= base_url() ?>public/dist/css/skins/skin-green.min.css">
		  <!-- jQuery 2.2.3 -->
		  <script src="<?= base_url() ?>public/plugins/jQuery/jquery-2.2.3.min.js"></script>
		  <!-- jQuery UI 1.11.4 -->
		  <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>

  		   <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		  <script>
				var config = {
					'baseUrl':"<?php echo base_url(); ?>",
					'siteUrl' : "<?php echo site_url(); ?>"
				}
		  </script>
		
	</head>
	<body class="hold-transition skin-green sidebar-mini">
		<div class="wrapper" style="height: auto;">
			<?php $this->load->view('common/flashmessage'); ?>
			
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
						<?php $this->load->view($view);?>
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
    
	
	<!-- Bootstrap 3.3.6 -->
	<script src="<?= base_url() ?>public/bootstrap/js/bootstrap.min.js"></script>
	<!-- AdminLTE App -->
	<script src="<?= base_url() ?>public/dist/js/app.min.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="<?= base_url() ?>public/dist/js/demo.js"></script>
	<!-- DataTables -->
	<script src="<?= base_url() ?>public/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="<?= base_url() ?>public/plugins/datatables/dataTables.bootstrap.min.js"></script>
	
	<!-- page script -->
	<script type="text/javascript">
	  $(".flash-msg").fadeTo(2000, 500).slideUp(500, function(){
	    $(".flash-msg").slideUp(500);
	});
	</script>
	</script>
	<script type="text/javascript">
		$.ajax({
			'url':"<?php echo base_url(); ?>workshop/order/get_notifications",
			'method':"POST",
			'async':false,
			success:function(response){
				if(response.status){
					$('#notification-list').html(response.template);
					$('#notification-count').text(response.total);
				}
			}
		});
	</script>
	</body>
</html>
