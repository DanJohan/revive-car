   <?php 
      $damage_mark = json_decode($job_card['damage_mark'],true);
    ?>
               <div class="img-wrapper text-center">
                <img src="<?php echo base_url(); ?>public/images/app/car.jpg" style="width:70%;height:500px;">
                  <div class="left-top damage-mark-box"><?php echo $damage_mark[0]; ?></div>
                  <div class="left-center damage-mark-box"><?php echo $damage_mark[1]; ?></div>
                  <div class="left-bottom damage-mark-box"><?php echo $damage_mark[2]; ?></div>
                  <div class="middle-top damage-mark-box"><?php echo $damage_mark[3]; ?></div>
                  <div class="middle-center damage-mark-box"><?php echo $damage_mark[4]; ?></div>
                  <div class="middle-bottom damage-mark-box"><?php echo $damage_mark[5]; ?></div>
                  <div class="right-top damage-mark-box"><?php echo $damage_mark[6]; ?></div>
                  <div class="right-center damage-mark-box"><?php echo $damage_mark[7]; ?></div>
                  <div class="right-bottom damage-mark-box"><?php echo $damage_mark[8]; ?></div>
              </div>
              <div class="text-center" style="margin-top: 20px;">
                <span><b>O = Body damage</b></span>&nbsp;&nbsp;
                <span><b>X = Paint damage</b></span>&nbsp;&nbsp;
                <span><b># = Glass damage</b></span>&nbsp;&nbsp;
                <span><b>Z = Exterior lightsdamage</b></span>&nbsp;&nbsp;
              </div>