<div class="modal-header admin-header">
				<button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
				<h3 class="modal-title">Please select workshop</h3>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-12">
							<form action="<?php echo base_url();?>admin/order/forworToWorkshop" method="post">
									<input type="hidden" value="<?php echo $order_id; ?>" name="order_id">
									<div class="form-group">
											<label for="manager" class="control-label">Workshop manager</label>
											<select name="manager_id" id="manager" class="form-control">
													<option value="">Please select</option>
													<?php
														foreach ($managers as $index => $manager) {
													?>
															<option value="<?php echo $manager['id']?>"><?php echo $manager['m_name']; ?></option>
													<?php
														}
													?>
											</select>
									</div>
									<div class="form-group">
											<button type="submit" name="submit" class="btn btn-primary">Forward</button>
									</div>
							</form>

						
					</div>
				</div>
			</div>
	</div>
										<!-- /.modal-content -->


