<li class="header">You have <?php echo count($orders); ?> notifications</li>
<li>
	<ul class="menu">
<?php 
if(!empty($orders)) {
	foreach ($orders as $index => $order) {
		$str = "<b>".$order['brand_name']." - ".$order['model_name']."</b> car service order received from customer <b>".$order['name']."</b>";
?>
<li >
    <a href="<?php echo base_url();?>admin/order/show/<?php echo $order['id']; ?>">
         <i class="fa fa-users text-aqua"></i><?php echo wordwrap($str,32,"<br>\n"); ?></a>
</li>
<?php
	}
}
?>
	<li class="footer"><a href="#"></a></li>
	</ul>
</li>
