
<li class="header">You have <?php echo count($orders); ?> notifications</li>
<li>
	<ul class="menu">
<?php 
if(!empty($orders)) {
	foreach ($orders as $index => $order) {
		$str = "<b>".$order['brand_name']." - ".$order['model_name']."</b> car service order confirmed of <b>".$order['name']."</b>";
		/*$str="Car service enquiry assigned :<br><b>Car : </b>{$enquiry['brand_name']}-{$enquiry['model_name']}<br><b>Customer : </b>{$enquiry['name']}";*/
?>
<li>
    <a href="<?php echo base_url();?>workshop/order/show/<?php echo $order['hash']; ?>">
         <i class="fa fa-users text-aqua"></i><?php echo wordwrap($str,32,"<br>\n"); ?></a>
</li>
<?php
	}
}
?>
	<li class="footer"><a href="#"></a></li>
	</ul>
</li>
