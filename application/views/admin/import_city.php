<div class="pages-section">

	<section class="section-header">
		
		<div class="container-fluid">
			
			<div class="page-title">
				<h1>Import City <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#import_guide">See Guide</button></h1>
			</div>

			<div class="breadcrumb-wrap">
				<ol class="breadcrumb">
					<li><a href="<?php echo base_url('admin'); ?>">Admin</a></li>
					<li><a href="<?php echo base_url('admin/cities'); ?>">Cities</a></li>
					<li class="active">Import</li>
				</ol>
			</div>

		</div>

	</section>

	<section class="section-content">
		
		<div class="container-fluid">

			<div class="well">

				<form class="cityimport-form" method="post" enctype="multipart/form-data" action="<?php echo base_url('admin/city/import/process'); ?>">

					<div class="form-group">
						<label>File Input</label>
						<input type="file" name="city" accept=".csv" required />
						<p class="help-block">Import state csv</p>
					</div>

					<div class="form-group">
						<button type="submit" class="btn btn-success btn-import">Import</button>
					</div>

				</form>

			</div>

			<div class="well logs" style="display:none;">
				
				<h2>LOGS <button class="btn btn-xs btn-warning clear-logs" title="Clear Import Logs">CLEAR LOGS</button></h2>

				<br/>

				<div class="logs-wrap" style="max-height:300px;overflow-y:scroll;">

				</div>

			</div>

			<div class="modal fade" id="import_guide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			    <div class="modal-dialog modal-lg" role="document">
			        <div class="modal-content">
			            <div class="modal-header">
			                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
			                </button>
			                <h4 class="modal-title" id="myModalLabel">Import Guide</h4>
			            </div>
			            <div class="modal-body">

			            	<div class="alert alert-warning">To determine column E (industry ID) click <a href="<?php echo base_url('admin/industry'); ?>" target="_blank" >Industry</a> menu</div>

			            	<div class="table-responsive">
					
								<table class="table table-bordered">
									<tr>
										<th width="5%"></th>
										<th>A</th>
										<th>B</th>
										<th>C</th>
										<th>D</th>
										<th>E</th>
										<th>F</th>
										<th>G</th>
										<th>H</th>
										<th>I</th>
										<th>J</th>
										<th>I</th>
									</tr>
									<tr>
										<th>1</th>
										<td class="text-warning">Leave as Blank</td>
										<td>Los Angeles</td>
										<td>CA</td>
										<td>Lorem impsum dolor sit amet</td>
										<td>1</td>
										<td>(706) 489-6436</td>
										<td>706</td>
										<td>30707</td>
										<td class="text-danger">34.8712</td>
										<td class="text-danger">-85.2908</td>
										<td>0 (1 if major)</td>
									</tr>
									<tr>
										<th>2</th>
										<td class="text-warning">Leave as Blank</td>
										<td>Miami</td>
										<td>FL</td>
										<td class="text-warning">Can be empty except the FIRST ROW</td>
										<td>2</td>
										<td>(706) 489-6436</td>
										<td>706</td>
										<td>30707</td>
										<td class="text-warning">Can be empty except the FIRST ROW</td>
										<td class="text-warning">Can be empty except the FIRST ROW</td>
										<td>0 (1 if major)</td>
									</tr>
								</table>

							</div>
			            </div>
			            <div class="modal-footer">
			                <button type="button" class="btn btn-success" data-dismiss="modal">Got It</button>
			            </div>
			        </div>
			    </div>
			</div>

		</div>

	</section>

</div>