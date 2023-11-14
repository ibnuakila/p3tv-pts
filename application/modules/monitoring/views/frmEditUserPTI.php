<style type="text/css">
.sendmail {
  display: none;
}
</style>
<div class="card-body">
<div class="row-fluid">
    <div class="span12">
      
            <div class="panel panel-primary">
              <div class="panel-heading"><strong>Form Edit User</strong></div>
              <div class="panel-body">
              <center id="step_message"></center>
               <?php echo $this->session->flashdata('msg'); ?>
               <form method="post" action="<?php echo site_url('monitoring/monitoring/saveuser'); ?>" class="form-horizontal" role="form">

                    <div class="form-group" >
                        <label class="col-lg-4 control-label">ID</label>
                        <div class="col-lg-2">
                        <input name="id" id="id" class="form-control" value="<?php echo $row->id; ?>" type="text" readonly>
                        <input name="ajax" id="ajax" class="form-control" value="1" type="hidden">
                      </div>
                    </div>

                    <div class="form-group" >
                        <label class="col-lg-4 control-label">Nama Pengusul</label>
                        <div class="col-lg-6">
                        <input name="nmpti" id="nmpti" class="form-control" value="<?php echo $row->nmpti; ?>" type="text" readonly>
                      </div>
                    </div>

                    <div class="form-group" >
                        <label class="col-lg-4 control-label">Email</label>
                        <div class="col-lg-6">
                        <input name="email" id="email" class="form-control" value="<?php echo $row->email; ?>" type="text">
                      </div>
                    </div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label">Status</label>
                        <div class="col-lg-2">
                            <?php    
                            $st = array( '0'=>'Non Aktif', '1'=>'Aktif', '2'=>'Tolak' );
                            echo form_dropdown('status', $st, $row->status  ,'class="form-control" id="status"');       
                           //  form_dropdown('nama objek','data array','value aktif','atribut tambahan')
                        ?>
                            
	                        
	                    </div>
                    </div>
<!--
                    <div class="form-group" >
                        <label class="col-lg-4 control-label">Password</label>
                        <div class="col-lg-6">
                        <input name="password" id="password" class="form-control" value="" type="text" placeholder="biarkan password kosong jika tidak ingin mengubah password">
                      </div>
                    </div> 
-->
                    <hr>

                    <div class="form-group">
                      <label class="col-lg-4 control-label">Tandai jika kirim pesan via email</label>
                      <div class="col-lg-6">     
                        <input type="checkbox" name="checkbox" id="checkbox" class="chk" value="1" onchange="valueChanged()" />
                        <input name="password" id="password" class="form-control" value="" type="hidden" >
                      </div>
                    </div>

<div class="sendmail">
                    <div class="form-group" >
                        <label class="col-lg-4 control-label">Subjek</label>
                        <div class="col-lg-6">
                        <input name="subjek" id="subjek" class="form-control" type="text" value="Aktivasi akun login PPPTV-PTS">
                      </div>
                    </div>

                    <div class="form-group" >
                        <label class="col-lg-4 control-label">Isi Pesan</label>
                        <div class="col-lg-6">
                            
                        <textarea name="isi" id="isi" class="form-control">
Registrasi akun telah diaktifkan, silahkan login melalui laman :
http://ppptv-pts.kemdikbud.go.id/login                     
                        </textarea>
                      </div>
                    </div>                    
</div>

                    <div class="form-group">
                        <label class="col-lg-4 control-label"></label>
                        <div class="col-lg-6">
                        <button type="submit" class="btn btn-success btn-sm" id="simpan">
                                SIMPAN</button>
                        </div>
                    </div>                    
                </form>

                <script type="text/javascript">
                  function valueChanged()
                  {
                      if($('.chk').is(":checked"))   
                          $(".sendmail").fadeIn();
                      else
                          $(".sendmail").fadeOut();
                  }
                </script>


              </div>
            </div>
            
    </div>
</div>     
    </div> 
