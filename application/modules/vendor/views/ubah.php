<br>
<br>
<div class="panel panel-success">
      <div class="panel-heading">
          <b> <?php echo $baru;?> Ganti password </b>
                </div>
<div class="row">
  
	<div class="col-md-12">
		<div class="col-md-3"></div>
		<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-body">

				<!-- login form -->  
				<form class="form-horizontal" name="login" method="post" action="<?php echo base_url('vendor/vendor/simpan') ?>" >
					<fieldset>
						
						<div > <p style="color:red"><?php echo $this->session->flashdata('message');?> </p>
						
						</div>
						<div class="form-group" s>
							<label for="inputEmail" class="col-lg-4 control-label">Password Lama</label>
							
							<div class="col-lg-8">
								<input type="password" class="form-control" name="passwordLama" placeholder="Password Lama" required>
								<p class="help-block"></p>
							</div>
						</div>
						<div class="form-group" s>
							<label for="inputEmail" class="col-lg-4 control-label">Password Baru (Minimal 6 karakter)</label>
							
							<div class="col-lg-8">
								<input type="password" class="form-control" name="passwordBaru" placeholder="Password Baru" required>
								<p class="help-block"></p>
							</div>
						</div>
						<div class="form-group" s>
							<label for="inputEmail" class="col-lg-4 control-label">Ketik Ulang Password Baru</label>
							
							<div class="col-lg-8">
								<input type="password" class="form-control" name="ulangi_passwordBaru" placeholder="Password Baru" required>
								<p class="help-block"></p>
								<div class="pass alert-success" style='display:none' align='center'>password benar</div>
								<div style='display:none' class="unpass alert-danger" align='center'>password salah</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-11" align="right">
								<button type="submit" class="btn btn-warning"> Ubah Password </button>
							</div>
						</div>
						<div class="form-group" style='display:none'>
							<label for="inputEmail" class="col-lg-3 control-label">User &nbsp ID </label>
							
							<div class="col-lg-8">
								<input type="text" class="form-control" name="userid" placeholder="User ID"
								value='<?=$user->getUserId();?>' required readonly
								>
								<p class="help-block"></p>
							</div>
						</div>

					</fieldset>
					
				</form>
			</div>
		</div>
		</div>
			<div class="col-md-3"></div>
                
	</div>
</div>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script type='text/javascript'>
    $(document).ready(function () {
		$("input[name='ulangi_passwordBaru']").keyup(function(){
			if($("input[name='ulangi_passwordBaru']").val()==$("input[name='passwordBaru']").val()){
				$("input[type='submit']").removeAttr('disabled');
				$(".unpass").hide();
				$(".pass").show();
			}else{
				$("input[type='submit']").prop('disabled','disabled');
				$(".pass").hide();
				$(".unpass").show();
			}
			if($("input[name='ulangi_passwordBaru']").val()==''){
				$(".unpass").hide();
				$(".pass").hide();
			}
		});
    });
</script>