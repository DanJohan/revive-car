<div class="row">
 <?php 
$job_card_images = $job_card['images_data'];
						if(!empty($job_card_images)) {
							$i=1;
							foreach ($job_card_images as $index => $job_card_image) {
						?>
								<div class="col-md-4 col-sm-4 col-xs-6">
									<div class="image-responsive">
											<a target="_blank" href="<?php echo base_url().'uploads/app/'.$job_card_image['image']; ?>"><img class="img-thumbnail" src="<?php echo base_url().'uploads/app/'.$job_card_image['image']; ?>" style="height:200px;width:100%;" /></a>
									</div>
								</div>
						<?php
								if($i % 3 == 0) {

									echo "</div><div class='row'>";
								}
								$i++;
							}
						}else{
							 echo "No image uploaded";
						}
	?>
</div>
