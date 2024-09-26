

    <!-- Right Content -->
    
    
    <div class="col-sm-12">
        <h2 class=" display-3 mt-4">Administrasi PPPTV-PTS</h1>
      
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
                Ini adalah halaman admin Sistem informasi PPPTV-PTS Direktorat Kelembagaan Dan Sumber Daya Pendidikan Tinggi Vokasi.
              </p>
              <a href="<?=base_url()?>assets/document/tutorial_sistem_silemkerma.pdf" class="btn btn-outline-primary">
                Panduan
              </a>  <?php 
              $user1 = $user->getUserId();
             
              
              
              if ($user1=='ADH' || $user1=='RMT' || $user1=='HRY' ) {
                   $data = $this->db->query("SELECT count(*) jml FROM user_pengusul where status=0")->row();
              if ($data->jml > 0) {
                  $jml = $data->jml;
                                } else {
                                    $jml=0;
                                }
                  ?>
               <a href="<?=base_url()?>monitoring/monitoring" class="btn btn-outline-danger">
              <?php echo $jml; ?> Pengajuan Akun Baru
              </a>   <?php } ?>
            </div>
        </div>
    </div>
    