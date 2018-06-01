<div class="pages-section">

	<section class="section-header">
		
		<div class="container-fluid">
			
			<div class="page-title">
				<h1>Add New State</h1>
			</div>

			<div class="breadcrumb-wrap">
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url('admin'); ?>">Admin</a></li>
					<li><a href="<?php echo base_url('admin/states'); ?>">States</a></li>
					<li class="active">New</li>
				</ol>
			</div>

		</div>

	</section>

	<section class="section-content">
		
		<div class="container-fluid">

			<form class="addstate-form" method="post" action="<?php echo base_url('admin/state/add'); ?>">
			
				<div class="row">
					
					<div class="col-md-9">
						<div class="well">
							<div class="row">

								<div class="col-md-12">

									<div class="form-group">
										<label>State</label>
										<input type="text" class="form-control" name="state" placeholder="State name ..." required />
									</div>

								</div>

								<div class="col-md-6">

									<div class="form-group">
										<label>Abbreviation</label>
										<input type="text" class="form-control slugme to-upper" name="abbrev" placeholder="State abbreviation ..." maxlength="2" required />
									</div>

								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label>Slug</label>
										<input type="text" class="form-control slug" name="slug" data-slug="<?php echo base_url('admin/validateslug'); ?>" data-posttype="state" placeholder="State slug ..." maxlength="2" readonly required />
									</div>
								</div>

								<div class="col-md-12">
									<div class="form-group">
										<label>Description</label>
										<textarea class="wysiwyg form-control" name="description" ></textarea>
									</div>
								</div>

								<div class="col-md-12">
									<div class="form-group">
										<label>Meta Keywords</label>
										<input type="text" class="form-control" name="meta_keyword" placeholder="SEO Keywords ..." required />
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label>Meta Description</label>
										<textarea class="form-control" name="meta_description" rows="2" placeholder="SEO Description ..." required></textarea>
									</div>
								</div>

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