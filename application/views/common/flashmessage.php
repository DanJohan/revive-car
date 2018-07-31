<?php
if($this->session->flashdata('success_msg') != '') {
?>
<div class="alert alert-success">
  <?php echo $this->session->flashdata('success_msg'); ?>
</div>
<?php
}
?>