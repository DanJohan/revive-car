<script type="text/javascript">
	 alertify.set('notifier','position', 'top-right');
</script>>
<?php
if($this->session->flashdata('success_msg') != '') {
?>
<script type="text/javascript">
	alertify.notify('<?php echo $this->session->flashdata('success_msg'); ?>', 'success', 5, function(){  console.log('dismissed'); });

</script>
<?php
}
?>

<?php
if($this->session->flashdata('error_msg') != '') {
?>
<script type="text/javascript">
	alertify.notify('<?php echo $this->session->flashdata('error_msg'); ?>', 'error', 5, function(){  console.log('dismissed'); });

</script>
<?php
}
?>

<?php
if($this->session->flashdata('info_msg') != '') {
?>
<script type="text/javascript">
	alertify.notify('<?php echo $this->session->flashdata('info_msg'); ?>', 'info', 5, function(){  console.log('dismissed'); });

</script>
<?php
}
?>
