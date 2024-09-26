

<!-- [ auth-signin ] start -->
<div class="auth-wrapper">
	<div class="auth-content text-center">
            <span>
                
                
            </span>
            
		<div class="card borderless">
			<div class="row align-items-center ">
				<div class="col-md-12">
					<div class="card-body">
                                            <form method="POST" action="<?php echo base_url()?>backoffice/login">
                                                <img src="<?= base_url()?>assets/images/logo_tutwuri_transparent.png" alt="" class="img-rounded mb-4" style="width: 50px; height: 50px">
						<h4 class="mb-3 f-w-400">PPPTV-PTS</h4>
						<hr>
						<div class="form-group mb-3">
                                                    <input type="text" class="form-control" id="userid" name="userid" placeholder="Email address">
						</div>
						<div class="form-group mb-4">
                                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
						</div>
						<div class="custom-control custom-checkbox text-left mb-4 mt-2">
							<input type="checkbox" class="custom-control-input" id="customCheck1">
							<label class="custom-control-label" for="customCheck1">Save credentials.</label>
						</div>
                                                <button class="btn btn-block btn-primary mb-4" type="submit">Signin</button>
						<hr>
						<p class="mb-2 text-muted">Forgot password? <a href="auth-reset-password.html" class="f-w-400">Reset</a></p>
						<p class="mb-0 text-muted">Don’t have an account? <a href="auth-signup.html" class="f-w-400">Signup</a></p>
                                            </form>
                                        </div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- [ auth-signin ] end -->

<!-- Required Js -->



