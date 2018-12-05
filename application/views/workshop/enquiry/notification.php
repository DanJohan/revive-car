<li class="header">You have <?php echo count($enquiries); ?> notifications</li>
<li>
	<ul class="menu">
<?php 
if(!empty($enquiries)) {
	foreach ($enquiries as $index => $enquiry) {
		$str = "<b>".$enquiry['brand_name']." - ".$enquiry['model_name']."</b> car service enquiry confirmed of <b>".$enquiry['name']."</b>";
		/*$str="Car service enquiry assigned :<br><b>Car : </b>{$enquiry['brand_name']}-{$enquiry['model_name']}<br><b>Customer : </b>{$enquiry['name']}";*/
?>
<li>
    <a href="<?php echo base_url();?>workshop/enquiry/index/<?php echo $enquiry['id']; ?>">
         <i class="fa fa-users text-aqua"></i><?php echo wordwrap($str,32,"<br>\n"); ?></a>
</li>
<?php
	}
}
?>
	<li class="footer"><a href="#"></a></li>
	</ul>
</li>
