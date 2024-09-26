
    <h3 class="display-5">
        Unggah Hasil Evaluasi
    </h3><hr>
    <div class="card col-sm-12">
        <div class="card-header"><i class="fa fa-upload"></i> Form Unggah </div>
        <div class="card-body">
            <form class="form-horizontal" method="post" action="<?= base_url() . 'backoffice/kelolaevaluasi/save/' . $flagInsert ?>" accept-charset="utf-8" enctype="multipart/form-data">
                <?php
                //$account = $registrasi->getAccount();
                //$yayasan = $account->getYayasan();
                $pt = $registrasi->getPti();
                $nmyayasan = '-';
                $penyelenggara = $pt->getPenyelenggara();
                if (is_object($penyelenggara)) {
                    $nmyayasan = $penyelenggara->getNamaPenyelenggara();
                }
                $status = $registrasi->getStatusRegistrasi();
                $proses = new Proses($id_proses);
                ?>                


                <?php if (isset($message)) { ?>                    
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <strong><?= $message ?></strong>
                    </div>
                <?php } ?> 

                <h3><?= $nmyayasan ?></h3>
                <h4><?= $pt->getNmPti() ?></h4>
                <hr>

                <?php
                if ($proses->getIdJnsEvaluasi() == '1') {
                    ?>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">File Excell Penilaian</label>
                        <div class="">
                            <input type="file" class="btn btn-file" name="userfile" id="userfile"/> 
                            <input type="hidden" name="idregistrasi" value="<?= $registrasi->getIdRegistrasi() ?>">
                            <input type="hidden" name="jns_evaluasi" value="<?= $proses->getIdJnsEvaluasi() ?>">
                            <input type="hidden" name="type_evaluator" value="<?= $proses->getTypeEvaluator() ?>">
                            <input type="hidden" name="jns_file" value="<?=0 ?>">
                        </div>
                    </div>
                    <?php
                    $rekap = new Rekapitulasi();
                    $rekap->getBy('id_registrasi', $registrasi->getIdRegistrasi());
                    
                    
                } else {
                    
                        ?>

                        <div class="form-group">
                            <label class="col-lg-3 control-label">Dokumen</label>
                            <div class="col-lg-3">
                                <?php
                                if (isset($opt_dokumen)) {
                                    echo form_dropdown('jns_file', $opt_dokumen, '0', 'class="form-control form-control-sm" id="jns_file"');
                                }
                                ?>
                                
                                <input type="hidden" name="id_proses" value="<?= $proses->getIdProses() ?>">
                                <input type="hidden" name="jns_evaluasi" value="<?= $proses->getIdJnsEvaluasi() ?>">
                                <input type="hidden" name="type_evaluator" value="<?= $proses->getTypeEvaluator() ?>">
                                <input type="hidden" name="idregistrasi" value="<?= $registrasi->getIdRegistrasi() ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label">File</label>
                            <div class="col-lg-3">
                            <input type="file" class="btn btn-file" name="userfile" id="userfile"/> 
                            </div>
                        </div>
                    <?php if ($proses->getTypeEvaluator() == '2') { ?>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="final" value="1">
                            <label class="form-check-label" for="defaultCheck1">
                                File Final
                            </label>
                        </div>
                        
                        
                    <?php } ?>

                <?php } ?>
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        <button class="btn btn-warning btn-sm" name="cancel" value="cancel">Cancel</button>
                        <button type="submit" name="save" value="save" class="btn btn-success btn-sm">Unggah</button>
                    </div>
                </div>

            </form>
        </div>
    </div>