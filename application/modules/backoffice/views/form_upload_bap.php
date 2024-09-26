
    <h3 class="display-5">
        Unggah Komentar Konsolidasi
    </h3><hr>
    <div class="card col-sm-12">
        <div class="card-header"><i class="fa fa-upload"></i> Form Unggah </div>
        <div class="card-body">
            <form class="form-horizontal" method="post" action="<?= base_url() . 'backoffice/kelolaevaluasi/uploadbapmonev/' ?>" accept-charset="utf-8" enctype="multipart/form-data">
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
                
                    <div class="form-group">
                        <label class="col-lg-3 control-label">File BAP Monev</label>
                        <div class="">
                            <input type="file" class="btn btn-file" name="userfile" id="userfile"/>     
                            <input type="hidden" name="id_registrasi" value="<?= $registrasi->getIdRegistrasi() ?>">
                            <input type="hidden" name="id_proses" value="<?= $id_proses ?>">
                        </div>
                    </div>                         
                
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        <button class="btn btn-warning btn-sm" name="cancel" value="cancel">Cancel</button>
                        <button type="submit" name="save" value="save" class="btn btn-success btn-sm">Unggah</button>
                    </div>
                </div>

            </form>
        </div>
    </div>