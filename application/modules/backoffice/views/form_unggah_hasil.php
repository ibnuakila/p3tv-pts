<div class="md-card"><i class="glyphicon glyphicon-tag"></i>
    <h2>Unggah Hasil Penilaian</h2>
    <div class="panel panel-default">
        <div class="panel-heading">Form Unggah</div>
        <div class="panel-body">
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
                <?php ?>
                <div class="form-group">
                    <label class="col-lg-3 control-label">File Excell Penilaian</label>
                    <div class="">
                        <input type="file" class="btn btn-file" name="userfile" id="userfile"/> 
                        <input type="hidden" name="idregistrasi" value="<?= $registrasi->getIdRegistrasi() ?>">
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
</div>