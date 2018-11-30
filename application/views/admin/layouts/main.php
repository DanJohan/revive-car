<!DOCTYPE html>
<html lang="en">
	<head>
		  <title><?=isset($title)?$title:'Customer Relationship Management' ?></title>
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
		    <link rel="stylesheet" href="<?= base_url() ?>public/vendor/alertifyjs/css/alertify.css"> 
	       <!-- Custom CSS -->
		  <link rel="stylesheet" href="<?= base_url() ?>public/dist/css/style.css">
		  <!-- AdminLTE Skins. Choose a skin from the css/skins. -->
		  <link rel="stylesheet" href="<?= base_url() ?>public/dist/css/skins/skin-blue.min.css">
		  <!-- jQuery 2.2.3 -->
		  <?php $this->widget->beginBlock('stylesheets',true); ?>
		  <?php $this->widget->endBlock(); ?>

		   <script>
				var config = {
					'baseUrl':"<?php echo base_url(); ?>",
					'siteUrl' : "<?php echo site_url(); ?>"
				}
		  </script>
		
	</head>
	<body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper" style="height: auto;">

			
			<section id="container">
				<!--header start-->
				<header class="header white-bg">
					<?php $this->load->view('admin/include/navbar.php'); ?>
				</header>
				<!--header end-->
				<!--sidebar start-->
				<aside>
					<?php $this->load->view('admin/include/sidebar.php'); ?>
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
					<strong>Copyright © 2018 <a href="#">Smart Serve Infotech</a></strong> All rights
					reserved.
				</footer>
				<!--footer end-->
			</section>

	</div>	
    
<script type="text/javascript" src="<?php echo base_url() ?>public/dist/js/jquery3.3.1.min.js"></script>	
<script type="text/javascript" src="<?php echo base_url() ?>public/dist/js/jquery-ui.min.js"></script>	
<script type="text/javascript" src="<?php echo base_url(); ?>public/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/dist/js/app.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/vendor/alertifyjs/alertify.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/dist/js/main.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>public/dist/js/pusher.min.js"></script>
<script type="text/javascript">
	var current_url = window.location.href;
	$('.treeview-menu a').each(function(){
		if($(this).attr('href')== current_url){
			$(this).parent('li').addClass('active');
			//$(this).parents('li.treeview').addClass('active');
		}
	});
</script>
  <script>

    // Enable pusher logging - don't include this in production
/*    Pusher.logToConsole = true;

    var pusher = new Pusher('<?php //echo PUSHER_KEY; ?>', {
      cluster: '<?php //echo PUSHER_CLUSTER; ?>',
      forceTLS: true
    });

    var channel = pusher.subscribe('order');
    channel.bind('receive-order', function(data) {
     alertify.notify(data.message, 'success', 5, function(){  console.log('dismissed'); });
    });*/

     $.ajax({
		'url':"<?php echo base_url(); ?>admin/order/get_notifications",
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
<?php $this->widget->beginBlock('scripts', true); ?>
<?php $this->widget->endBlock(); ?>
<?php $this->load->view('common/flashmessage'); ?>
	</body>
</html>
