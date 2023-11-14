

    <!-- Right Content -->
    
    <h1 class=" display-3 mt-4">Administrasi PPPTS</h1>
    <hr>
        <div class="card">
          <div class="card-header">
            Beranda
          </div>
            <div class="card-body">
              <a class="pull-left" href="#">
                <img width="150" height="150" class="media-object img-polaroid" src="<?=base_url()?>assets/images/user1.png">
              </a>
            
                <h3 class="media-heading">Welcome <?php $user = new ModUsers($this->session->userdata('userid'));echo $user->getUserName();?></h3>
              <p class="muted">
                Ini adalah halaman admin Vendor, Sistem informasi PPPTS Direktorat Pembinaan Kelembagaan Kemenristek Dikti.
              </p>
              <a href="<?=base_url()?>assets/document/tutorial_sistem_silemkerma.pdf" class="btn btn-outline-primary">
                Panduan
              </a>
            </div>
        </div>
	
    