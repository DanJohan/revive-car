
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="../../favicon.ico">

	<title>Job card</title>

	<link rel="stylesheet" href="<?php echo base_url(); ?>public/bootstrap/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Raleway+Dots" rel="stylesheet">
	<!-- Optional theme -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>public/bootstrap/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> -->
	<link rel="stylesheet" href="<?php echo base_url()?>public/dist/css/job_card.css">
</head>


<!--=======TOP-SEC==========-->
<body>
<div class="main-wrapper">
<section>
	<div class="container">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="logo"><img src="<?php echo base_url(); ?>public/images/app/logo.png" alt=""></div>	 
				<h1 class="shew">Shekhawati Electronices Pvt.Ltd</h1>
				<div class="border"><img src="<?php echo base_url(); ?>public/images/app/border.png" alt=""></div>
				<span class="zex">Zedex Nission</span>
				<p class="add">Workshop:39/3, Site-IV Ind Area, Sahibabad, Ghazibad, Phone 0120-435566
					<br>Email: Service@zedexnissan.co.in</p>
					<p class="add">Showroom : 89,FIE , Patparganj Industrial Area, Delhi-110 092, Phone : +91-11-49320000<br>
						Email : Sales@zedexnissan.co.in
						<h2 class="services">SERVICE REQUEST FORM</h2>
					</div>

					<div class="main">
						<div class="col-md-6 col-sm-6 col-xs-12">
							<span class="time">Workshop Timing : 900 a.m to 6.pm</span>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<span class="date">Warranty Start Date</span>
						</div>
					</div>
				</div>
			</div>  
		</section>
		<!--=======TOP-SEC-END==========-->

		<!--=======FORM-SECTION=========-->
		<section>
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-12">
						<h3 class="details">Customer Details</h3>
						<div class="Cusomer-details customer-detail-wrapper">
							<div class="regi">
								<div class="row">
									<div class="col-xs-5"><b>Owner  Name</b></div>
									<div class="col-xs-2">:</div>
									<div class="col-xs-5"><span><?php echo $job_card['name']; ?></span></div>
								</div>
								<div class="row">
									<div class="col-xs-5"><b>Email Id  : </b></div>
									<div class="col-xs-2">:</div>
									<div class="col-xs-5"><span class="filled-data"><?php echo $job_card['email']; ?></span></div>
								</div>
								<div class="row">
									<div class="col-xs-5"><b>Mobile No : </b></div>
									<div class="col-xs-2">:</div>
									<div class="col-xs-5"><span class="filled-data"><?php echo $job_card['phone']; ?></span></div>
								</div>
								<div class="row">
									<div class="col-xs-5"><b> Address : </b></div>
									<div class="col-xs-2">:</div>
									<div class="col-xs-5"><span class="filled-data"><?php echo $job_card['address']; ?></span></div>
								</div>
								<div class="row">
									<div class="col-xs-5"><b>Alternate No :</b></div>
									<div class="col-xs-2">:</div>
									<div class="col-xs-5"><span class="filled-data"><?php echo $job_card['alternate_no']; ?></span></div>
								</div>
								<div class="row">
									<div class="col-xs-5"><b>Loaner Car: </b></div>
									<div class="col-xs-2">:</div>
									<div class="col-xs-5"><span class="filled-data"><?php echo ($job_card['loaner_vehicle'])?"Yes":"No"; ?></span></div>
								</div>
								<div class="row">
									<div class="col-xs-5"><b>Visit: </b></div>
									<div class="col-xs-2">:</div>
									<div class="col-xs-5"><span class="filled-data">Walk in</span></div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<h3 class="details">Vehicle Details</h3>
						<div class="Cusomer-details">
							<div class="regi">
								<div class="row">
									<div class="col-xs-5"><b>Registertion No</b></div>
									<div class="col-xs-2">:</div>
									<div class="col-xs-5"><span class="filled-data"><?php echo $job_card['registration_no']; ?></span></div>
								</div>
								<div class="row">
									<div class="col-xs-5"><b>Brand Name</b></div>
									<div class="col-xs-2">:</div>
									<div class="col-xs-5"><span class="filled-data"><?php echo $job_card['brand_name']; ?></span></div>
								</div>
								<div class="row">
									<div class="col-xs-5"><b>Model Name</b></div>
									<div class="col-xs-2">:</div>
									<div class="col-xs-5"><span class="filled-data"><?php echo $job_card['model_name']; ?></span></div>
								</div>
								<div class="row">
									<div class="col-xs-5"><b>VIN No</b></div>
									<div class="col-xs-2">:</div>
									<div class="col-xs-5"><span class="filled-data"><?php echo $job_card['vin_no']; ?></span></div>
								</div>
								<div class="row">
									<div class="col-xs-5"><b>S A Name & No </b></div>
									<div class="col-xs-2">:</div>
									<div class="col-xs-5"><span class="filled-data"><?php echo $job_card['sa_name_no']; ?></span></div>
								</div>
								<div class="row">
									<div class="col-xs-5"><b>Delivery Date And Time </b></div>
									<div class="col-xs-2">:</div>
									<div class="col-xs-5"><span class="filled-data"><?php echo $job_card['delivery_datetime']; ?></span></div>
								</div>
								<div class="row">
									<div class="col-xs-5"><b>Reporting Date and Time </b></div>
									<div class="col-xs-2">:</div>
									<div class="col-xs-5"><span class="filled-data"><?php echo $job_card['reporting_datetime']; ?></span></div>
								</div>
								<div class="row">
									<div class="col-xs-5"><b>KM </b></div>
									<div class="col-xs-2">:</div>
									<div class="col-xs-5"><span class="filled-data"><?php echo $job_card['ride_kms']; ?></span></div>
								</div>
								<div class="row">
									<div class="col-xs-5"><b>Type Of Services</b></div>
									<div class="col-xs-2">:</div>
									<div class="col-xs-5">
										
											<?php
										$type_of_services=json_decode($job_card['type_of_service']);
										if(!empty($type_of_services)) {
											foreach ($type_of_services as $index => $type_of_service) {
												if(($index+1) < count($type_of_services)){
						                          $suffix=", ";
						                        }else{
						                          $suffix='';
						                        }
										?>
											<span><?php echo $type_of_service.$suffix; ?></span>
										<?php
												}
											}
										?>
										
									</div>
								</div>
							</div>
						</div>  
					</div>
				</section>
				<!--=======FORM-SECTION-END=========-->
					<?php 
					 $damage_mark = json_decode($job_card['damage_mark']);
					?>
					<section class="model-sec">
						<div class="container">
							<div class="img-wrapper text-center">
								<img  src="<?php echo base_url(); ?>public/images/app/car.jpg" style="width:70%;height:500px;">
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
						</div>
					</section>


			<section class="model-sec2">
				<div class="container">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="Cusomer-details">
								<div class="regi">
									<?php
										$car_properties=json_decode($job_card['car_properties'],true);
										//dd($car_properties,false);
										if(!empty($car_properties)){
											foreach ($car_properties as $index => $car_property) {
									?>
									<div class="row">
										<div class="col-xs-3"><b><?php echo $car_property['name']; ?></b></div>
										<div class="col-xs-2">:</div>
										<div class="col-xs-4"><span ><?php echo $car_property['value']; ?></span></div>
									</div>
									<?php
											}
										}
									?>
								</div>
							</div>  
						</div>
					</div>
				</div>
			</section>

			<section class="model-sec2">
				<div class="container">
					<div class="row">
						<div class="col-xs-12">
							<div class="Cusomer-details progress-wrapper">
								<h3 class="details">Fuel</h3>
								<div class="progress">
					                  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $job_card['fuel']; ?>"
					                  aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $job_card['fuel']; ?>%">
					                    <?php echo $job_card['fuel']."%"; ?>
					                  </div>
					              </div>
			              		</div>
		              		</div>
					</div>
				</div>
			</section>

			<section class="model-sec2">
				<div class="container">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<h3 class="details">Vehicle items</h3>
							<div class="Cusomer-details">
								<div class="regi">
									<div class="row">
										<div class="col-xs-3"><b>Item</b></div>
										<div class="col-xs-2"></div>
										<div class="col-xs-4"><b>Quantity</b></div>
									</div>
									<?php
										$vehicle_qtys=json_decode($job_card['vehicle_qty'],true);
										//dd($car_properties,false);
										if(!empty($vehicle_qtys)){
											foreach ($vehicle_qtys as $index => $vehicle_qty) {
									?>
									<div class="row">
										<div class="col-xs-3"><b><?php echo $vehicle_qty['item']; ?></b></div>
										<div class="col-xs-2">:</div>
										<div class="col-xs-4"><span ><?php echo $vehicle_qty['qty']; ?></span></div>
									</div>
									<?php
											}
										}
									?>
								</div>
							</div>  
						</div>
					</div>
				</div>
			</section>

			<section class="model-sec3">
				<div class="container">
					<div class="row">
						<div class="col-sm-12 col-md-12 col-xs-12 qty">
							<span class="qty">Repair order</span>
							<div class="container">
								<div class="row">
									<div class="col-xs-12">
										<div class="table-responsive">
											<table summary="This table shows how to create responsive tables using Bootstrap's default functionality" class="table table-bordered table-hover">
												<thead>
													<tr>
														<th>Customer Request</th>
														<th>S.A  Remarks</th>
														<th>Parts Name</th>
														<th> Qty</th>
														<th>Parts Price</th>
														<th>Labour Price</th>
														<th>Total Price</th>
													</tr>
												</thead>
												<tbody>
													<?php
													$repair_orders = $job_card['repair_orders'];
													if(!empty($repair_orders)) {
														foreach ($repair_orders as $index => $repair_order) {
													?>
													  <tr>
														<td><?php echo $repair_order['customer_request']; ?></td>
														<td><?php echo $repair_order['sa_remarks']; ?></td>
														<td><?php echo $repair_order['parts_name']; ?></td>
														<td><?php echo $repair_order['qty']; ?></td>
														<td><?php echo number_format($repair_order['parts_price'],2,'.',','); ?></td>
                            							<td><?php echo number_format($repair_order['labour_price'],2,'.',','); ?></td>
                            							<td><?php echo number_format($repair_order['total_price'],2,'.',','); ?></td>
													</tr>
													<?php
														}
													}
													?>
													
												</tbody>
												<tfoot>
													<tr>

													</tr>
												</tfoot>
											</table>
										</div><!--end of .table-responsive-->
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>

			<section>
				<div class="container">
					<h3 class="details">Images</h3>
					<div class="row">
						 <?php 
						$job_card_images = $job_card['images_data'];
	                      if(!empty($job_card_images)) {
	                      	$i=1;
	                        foreach ($job_card_images as $index => $job_card_image) {
	                      ?>
	                          <div class="col-md-4 col-sm-4 col-xs-6">
	                            <div class="image-responsive">
	                                <img class="img-thumbnail" src="<?php echo base_url().'uploads/app/'.$job_card_image['image']; ?>" style="height:200px;width:100%;" />
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
				</div>
			</section> 

			<section>
				<div class="container">
					<div class="row">
						<h3 class="details">Signature</h3>
						<div class="col-md-12 col-sm-12 col-xs-12 text-center">
							<div class="image-responsive">
								<img class="img-thumbnail" src="<?php echo base_url(); ?>uploads/app/<?php echo $job_card['signature']; ?>">   
							</div>
						</div> 
					</div>
				</div>
			</section> 
		</div>
	</body>
</html>