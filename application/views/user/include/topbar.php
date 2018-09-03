<!--========TOP-BAR=========-->
<section class="top_bar">
  <div class="container">
     <div class="row">
	   <div class="col-md-6 col-sm-6 col-xs-12">
	   <span class="email"><a href="#">Email: contact@reviveauto.in</a> <a href="#">Phone: +971 52 606 0881 </a></span>
	   </div>
  <div class="col-md-6 col-sm-6 col-xs-12">
     <div class="right_side">
      <div class="dropdown">
       <?php if($this->session->userdata('profile_image')!='') {?>
        <span class="lo_gin dropdown-toggle" data-toggle="dropdown"><img src="<?php echo base_url();?>public/userlogin/img/download.jpg">&nbsp;&nbsp;<?php echo $this->session->userdata('name'); ?></span> 
        <?php } else {?>
        <span class="lo_gin dropdown-toggle" data-toggle="dropdown"><img src="<?php echo base_url();?>public/userlogin/img/no_image.jpg">&nbsp;&nbsp;<?php echo $this->session->userdata('name'); ?></span> 
        <?php } ?>

        <ul class="dropdown-menu">
           <li><a tabindex="-1" href="<?php echo base_url('user/logout'); ?>">Logout</a></li>
       </ul>
      </div>
    </div>
      </div>
    </div>
	 </div>
  </div>
</section>
<!--========TOP-BAR-/=========-->