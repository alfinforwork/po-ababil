<?php
	include_once('header.php');
?>

<div class="page-holder w-100 d-flex flex-wrap">
	<div class="container-fluid px-xl-5">
		<section class="py-5">
			<div class="row">
				<!-- Form Elements -->
				<div class="col-lg-12 mb-5">
					<div class="card">
						<div class="card-header">
							<h3 class="h6 text-uppercase mb-0">All form elements</h3>
						</div>
						<div class="card-body">
							<form class="form-horizontal">
								<div class="form-group row">
									<label class="col-md-3 form-control-label">Normal</label>
									<div class="col-md-6">
										<input type="text" class="form-control">
									</div>
								</div>
								<div class="line"></div>
								<div class="form-group row">
									<label class="col-md-3 form-control-label">Help text</label>
									<div class="col-md-9">
										<input type="text" class="form-control">
										<small class="form-text text-muted ml-3">A block
											of help text that breaks onto a new line and may extend beyond one line.</small>
									</div>
								</div>
								<div class="line"></div>
								<div class="form-group row">
									<label class="col-md-3 form-control-label">Password</label>
									<div class="col-md-9">
										<input type="password" name="password" class="form-control">
									</div>
								</div>
								<div class="line"></div>
								<div class="form-group row">
									<label class="col-md-3 form-control-label">Checkboxes &amp; radios <br><small
											class="text-primary">Bootstrap4 custom controls</small></label>
									<div class="col-md-9">
										<div class="custom-control custom-checkbox">
											<input id="customCheck1" type="checkbox" class="custom-control-input">
											<label for="customCheck1" class="custom-control-label">Check this custom
												checkbox</label>
										</div>
										<div class="custom-control custom-radio custom-control-inline">
											<input id="customRadioInline1" type="radio" name="customRadioInline1"
												class="custom-control-input">
											<label for="customRadioInline1" class="custom-control-label">Toggle this custom
												radio</label>
										</div>
										<div class="custom-control custom-radio custom-control-inline">
											<input id="customRadioInline2" type="radio" name="customRadioInline1"
												class="custom-control-input">
											<label for="customRadioInline2" class="custom-control-label">Or toggle this other
												custom radio</label>
										</div>
									</div>
								</div>
								<div class="line"></div>
								<div class="form-group row">
									<label class="col-md-3 form-control-label">Select</label>
									<div class="col-md-9 select mb-3">
										<select name="account" class="form-control">
											<option>option 1</option>
											<option>option 2</option>
											<option>option 3</option>
											<option>option 4</option>
										</select>
									</div>
								</div>			
								<div class="line"></div>
								<div class="form-group row">
									<div class="col-md-9 ml-auto">
										<button type="submit" class="btn btn-secondary">Cancel</button>
										<button type="submit" class="btn btn-primary">Save changes</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>

<?php
	include_once('footer.php');
?>