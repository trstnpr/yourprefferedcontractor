<form class="search-form" method="get" action="<?php echo base_url('search'); ?>">
	<input type="hidden" name="industry" value="1" />

	<div class="row">
			
		<div class="col-md-9">
			<div class="form-group">
				<input type="text" class="form-control input-lg keyword" name="location" placeholder="City, State or Zip Code" data-suggest="<?php echo base_url('search/suggest'); ?>" required />
			</div>
		</div>

		<!-- <div class="col-md-3">
			<div class="form-group">
				<select class="form-control input-lg" name="industry" required>
					<option value="" selected disabled>Choose Type</option>
					<?php
					//if(industry() != 0) {
					//	foreach(industry() as $indstry) {
					?>
					<option value="<?php //echo $indstry->id; ?>"><?php //echo $indstry->industry; ?></option>
					<?php // } } ?>
				</select>
			</div>
		</div> -->

		<div class="col-md-3">
			<button type="submit" class="btn btn-lg btn-block btn-default">Submit</button>
		</div>

	</div>

</form>