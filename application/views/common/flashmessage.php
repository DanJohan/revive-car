<?php
if($this->session->flashdata('success_msg') != '') {
?>
<div class="alert alert-success flash-msg alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	<h4> Success!</h4>
  <?php echo $this->session->flashdata('success_msg'); ?>
</div>
<?php
}
?>

<?php
if($this->session->flashdata('error_msg') != '') {
?>
<div class="alert alert-danger flash-msg alert-dismissible">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	<h4> Alert!</h4>
  	<?php echo $this->session->flashdata('error_msg'); ?>
</div>
<?php
}
?>