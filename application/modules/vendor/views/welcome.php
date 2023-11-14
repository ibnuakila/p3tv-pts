

    <!-- Right Content -->
    <div class="md-card">
    <h1 class="">Administrasi PPPTS</h1>
    <hr>
        <div class="media containtment">
            <a class="pull-left" href="#">
              <img width="150" height="150" class="media-object img-polaroid" src="<?=base_url()?>assets/images/user1.png">
            </a>
            <div class="media-body">
                <h3 class="media-heading">Welcome <?php $user = new ModUsers($this->session->userdata('userid'));echo $user->getUserName();?></h3>
              <p class="muted">
                Ini adalah halaman admin Vendor, Sistem informasi PPPTS Direktorat Pembinaan Kelembagaan Kemenristek Dikti.
              </p>
              
            </div>
            <p>
                <a href="<?=base_url()?>assets/document/tutorial_sistem_silemkerma.pdf" class="btn btn-primary btn-large">
            Panduan
          </a>
        </p>
        </div>
	</div>
    