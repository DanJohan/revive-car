<?php
if($this->session->flashdata('success_msg') != '') {
?>
<div class="alert alert-success">
  <?php echo $this->session->flashdata('success_msg'); ?>
</div>
<?php
}
?>

<?php
if($this->session->flashdata('error_msg') != '') {
?>
<div class="alert alert-danger">
  <?php echo $this->session->flashdata('error_msg'); ?>
</div>
<?php
}
?>