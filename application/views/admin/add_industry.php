<div class="pages-section">

	<section class="section-header">
		
		<div class="container-fluid">
			
			<div class="page-title">
				<h1>Add New Industry</button></h1>
			</div>

			<div class="breadcrumb-wrap">
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url('admin'); ?>">Admin</a></li>
					<li><a href="<?php echo base_url('admin/industry'); ?>">Industry</a></li>
					<li class="active">New</li>
				</ol>
			</div>

		</div>

	</section>

	<section class="section-content">
		
		<div class="container-fluid">

			<form class="addindustry-form" method="post" action="<?php echo base_url('admin/industry/add'); ?>">

				<div class="row">

					<div class="col-md-9">

						<div class="well">
							
							<div class="form-group">
								
								<label>Industry</label>

								<input type="text" class="form-control" name="industry" placeholder="Industry name" required />

							</div>

							<div class="form-group">
								
								<label>Prefix</label>

								<input type="text" class="form-control" name="slug" placeholder="Industry prefix" />

							</div>

							<div class="form-group">
								
								<label>Label</label>

								<textarea class="form-control" name="label" rows="2" required></textarea>

							</div>

						</div>

					</div>

					<div class="col-md-3">

						<div class="panel-group" id="accordion1" role="tablist" aria-multiselectable="true">
						    <div class="panel panel-default">
						        <div class="panel-heading" role="tab" id="headingOne">
						            <h4 class="panel-title">
								        <a role="button" data-toggle="collapse" data-parent="#accordion1" href="#publish" aria-expanded="true" aria-controls="collapseOne">
								         	Action
								        </a>
								    </h4>
						        </div>
						        <div id="publish" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
						            <div class="panel-body">
						                <button type="submit" class="btn btn-success btn-block btn-save">Save</button>
						            </div>
						        </div>
						    </div>
						</div>

					</div>

				</div>

			</form>

		</div>

	</section>

</div>