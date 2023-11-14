
    <h3 class="display-5">
        Unggah Komentar Konsolidasi
    </h3><hr>
    <div class="card col-sm-12">
        <div class="card-header"><i class="fa fa-upload"></i> Form Unggah </div>
        <div class="card-body">
            <form class="form-horizontal" method="post" action="<?= base_url() . 'backoffice/kelolaevaluasi/savecomment/' ?>" accept-charset="utf-8" enctype="multipart/form-data">
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
                    $rekap = new Rekapitulasi();
                    $rekap->getBy('id_registrasi', $registrasi->getIdRegistrasi());
                    if($rekap->getKeterangan()!=''){?>
                        <div class="form-group">
                                <a class="btn btn-success" href="<?= base_url() . 'backoffice/kelolarekapitulasi/downloadComment/' . $registrasi->getIdRegistrasi() ?>">File Komentar Telah Ada</a>
                        </div>
                            <?php
                    }?>
                    <div class="form-group">
                        <label class="col-lg-3 control-label">File Komentar Konsolidasi</label>
                        <div class="">
                            <input type="file" class="btn btn-file" name="userfile" id="userfile"/> 
                            <input type="hidden" name="idregistrasi" value="<?= $registrasi->getIdRegistrasi() ?>">
                            <input type="hidden" name="jns_evaluasi" value="<?= $proses->getIdJnsEvaluasi() ?>">
                            <input type="hidden" name="type_evaluator" value="<?= $proses->getTypeEvaluator() ?>">
                        </div>
                    </div>
                    <?php
                    
                                   
                } ?>
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        <button class="btn btn-warning btn-sm" name="cancel" value="cancel">Cancel</button>
                        <button type="submit" name="save" value="save" class="btn btn-success btn-sm">Unggah</button>
                    </div>
                </div>

            </form>
        </div>
    </div>