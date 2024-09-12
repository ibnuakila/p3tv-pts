<style type="text/css">
    .sendmail {
        display: none;
    }
</style>
<div class="card-body">
    <div class="row-fluid">
        <div class="span12">

            <div class="panel panel-primary">
                <div class="panel-heading"><strong>Form Jawaban Admin</strong></div>
                <div class="panel-body">
                    <center id="step_message"></center>
                    <?php
                    echo $this->session->flashdata('msg');
                    
                    $nama = $this->security->xss_clean($row->nama);
                    $email = $this->security->xss_clean($row->email);
                    $tanya = $this->security->xss_clean($row->pesan);
                    $subject = "Jawab : ".$this->security->xss_clean($row->judul);                   
                    ?>
                    <form method="post" action="<?php echo site_url('monitoring/kontak/savejawab'); ?>" class="form-horizontal" role="form">

                        <div class="form-group" >
                            <label class="col-lg-4 control-label">ID</label>
                            <div class="col-lg-2">
                                <input name="id" id="id" class="form-control" value="<?php echo $row->id; ?>" type="text" readonly>
                                <input name="ajax" id="ajax" class="form-control" value="1" type="hidden">
                            </div>
                        </div>

                        <div class="form-group" >
                            <label class="col-lg-4 control-label">Nama </label>
                            <div class="col-lg-6">
                                <input name="nama" id="nmpti" class="form-control" value="<?php echo $nama; ?>" type="text" readonly>
                            </div>
                        </div>

                        <div class="form-group" >
                            <label class="col-lg-4 control-label">Email</label>
                            <div class="col-lg-6">
                                <input name="email" id="email" class="form-control" value="<?php echo $email; ?>" type="text">
                            </div>
                        </div>




                        <div class="form-group" >
                            <label class="col-lg-4 control-label">Judul</label>
                            <div class="col-lg-6">
                                <input name="subjek" id="subjek" class="form-control" value="<?php echo $subject; ?>" type="text">
                            </div>
                        </div>


                        <div class="form-group" >
                            <label class="col-lg-4 control-label">Pertanyaan</label>
                            <div class="col-lg-6">

                                <textarea rows="8" name="tanya" id="tanya" class="form-control">

                                    <?php echo $tanya; ?>


               
                                </textarea>
                            </div>


                            <div class="form-group" >
                                <label class="col-lg-4 control-label">Jawab</label>
                                <div class="col-lg-6">

                                    <textarea rows="10" name="isi" id="isi" class="form-control">


               
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




                </div>
            </div>

        </div>
    </div>   
</div> 
