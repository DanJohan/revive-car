<html>
	<head>
		
	</head>
	<body>
		<div>
			<p>
				****************************************************************************<br>
					To upload service enquirey<br>
				*****************************************************************************<br>
			</p>
			<form action="<?php echo base_url(); ?>api/car/serviceEnquiry" method="post" enctype="multipart/form-data">
				<table>
					<tr>
						<td>Car id</td>
						<td><input type="text" name="car_id"></td>
					</tr>
					<tr>
						<td>Address</td>
						<td><input type="text" name="address"></td>
					</tr>
					<tr>
						<td>Loaner vechicle</td>
						<td><input type="text" name="loaner_vehicle"></td>
					</tr>
					<tr>
						<td>Enquiry</td>
						<td><input type="text" name="enquiry"></td>
					</tr>
					<tr>
						<td>Enquiry Images</td>
						<td><input type="file" name="service_images[]" multiple></td>
					</tr>
					<tr>
						<td></td>
						<td><button type="submit">Submit</button></td>
					</tr>
				</table>
			</form>

		</div>
	</body>
</html>