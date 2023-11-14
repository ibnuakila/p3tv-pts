
<script type="text/javascript" >
    
</script>


<h2 class="page-header"><?=$title?></h2>
<p><?php $this->uri->segment(3)?></p>
<div class="card">
    <div class="card-header text-justify">

        <i class="fa fa-list"></i>
    </div>
    <div class="card-body">
        <div class="row-fluid">
            <div class="table-responsive">
                <table class="table table-condensed table-striped table-bordered">
                    <thead class="">
                        <tr class="" >
                            <th>#</th>
                            <th class="text-center">Id Registrasi</th>
                            <th class="text-center">Yayasan</th> 
                            <th class="text-center">Perguruan Tinggi</th>
                            <th class="text-center">Jns Evaluasi</th>
                            <th class="text-center">Evaluator</th>
                            <th class="text-center">Tgl Penugasan</th>
                            <th class="text-center">Tgl Kadaluarsa</th>
                            <th class="text-center">Type Evaluator</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                        <tr class="bg-light">
                    <form method="post" action="<?= $base_url ?>">
                        <th>#</th>
                        <th><input type="text" id="id_registrasi" name="id_registrasi" class="form-control form-control-sm"></th>
                        <th><input type="text" id="yayasan" name="yayasan" class="form-control form-control-sm"></th>
                        <th><input type="text" id="pti" name="pti" class="form-control form-control-sm"></th>                        
                        <th></th>
                        <th><input type="text" id="evaluator" name="evaluator" class="form-control form-control-sm"></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>

                        <th>
                            <button type="submit" name="find" class="btn btn-primary btn-sm" value="find">
                                <i class="fa fa-search"></i>
                            </button>
                        </th>
                    </form>
                    </tr>
                    </thead>
                    <tbody>          

                        <?php
                        if (isset($proses) && $proses != null) {
                            $segment = $this->uri->segment(4, 0);
                            if (!is_numeric($segment)) {
                                $segment = $this->uri->segment(6, 0);
                            }
                            $user = $this->session->userdata('userid');
                            $i = $segment + 1;
                            if ($i == '') {
                                $i = 1;
                            }
                            //print_r($proses->result());
                            foreach ($proses->result() as $obj) {
                                $pro = new Proses($obj->id_proses);
                                $reg = $pro->getRegistrasi();
                                $jenis_usulan = new JenisUsulan($reg->getJnsUsulan());
                                $evaluasi = $pro->getEvaluasi();
                                $pt = $reg->getPti();
                                $nmyayasan = '-';
                                $nmpti = '';
                                $penyelenggara = $reg->getPenyelenggara();
                                if (is_object($penyelenggara)) {
                                    $nmyayasan = $penyelenggara->getNamaPenyelenggara();
                                }
                                $status = $pro->getStatusProses();
                                $stat_eval = '';
                                $skor = '';
                                //print_r($evaluasi);
                                if (is_object($evaluasi)) {
                                    $status_reg = $evaluasi->getStatusRegistrasi();
                                    if (!is_null($status_reg)) {
                                        $stat_eval = $status_reg->getNamaStatus();
                                        $skor = $evaluasi->getSkor();
                                    }
                                }
                                if (!is_null($pt)) {
                                    $nmpti = $pt->getNmPti();
                                }
                                $evaluator = new Evaluator($pro->getIdEvaluator());
                                ?>
                                <tr class="<?php
                                if ($status->getIdStatusProses() == '4') {
                                    echo 'table-warning';
                                }
                                $jenis_evaluasi = new JenisEvaluasi($obj->id_jns_evaluasi);
                                ?>">

                                    <td><?= $i ?></td>
                                    <td><?= $reg->getIdRegistrasi(); ?></td>
                                    <td><?= $nmyayasan; ?></td>
                                    <td><?= $nmpti; ?></td>
                                    <td><?= $jenis_evaluasi->getNamaEvaluasi() ?></td>
                                    <td><?= $evaluator->getNmEvaluator(); ?></td>
                                    <td><?= $pro->getTglKirim(); ?></td>
                                    <td><?= $pro->getTglExpire(); ?></td>
                                    <td><?= $pro->getTypeEvaluator(); ?></td>
                                    <td>
                                        <?php if ($pro->getIdStatusProses() == 4) { ?>
                                            <span class="badge badge-warning"><?= $status->getNamaStatus(); ?></span>
                                        <?php } elseif ($pro->getIdStatusProses() == 3) { ?>
                                            <span class="badge badge-success"><?= $status->getNamaStatus(); ?></span>
                                        <?php } else { ?>
                                            <span class="badge badge-light-info"><?= $status->getNamaStatus(); ?></span>
                                        <?php } ?>
                                    </td>          
                                    <td>
                                        <?php
                                        if ($this->sessionutility->isAdministrator()) {
                                            ?>
                                                          <!--<a href="<?= base_url() . 'backoffice/kelolaevaluasi/view/' . $reg->getIdRegistrasi() ?>" title="View">
                                                            <i class="fa fa-file"></i> </a>-->

                                            <?php
                                            //if($jml_segment)
                                            if ($this->uri->segment(3) == 'indexevaluator') {
                                                if ($obj->type_evaluator == '1') {//reviewer
                                                    ?>
                            
                                                    <a href="<?= base_url() . 'backoffice/kelolaproses/getberitaacarafinal/' . $reg->getIdRegistrasi() ?>" 
                                                       title="Berita Acara Final" target="_new">
                                                        <i class="fa fa-file-text-o"></i>
                                                    </a>

                                                    <a href="<?= base_url() . 'backoffice/kelolaproses/detaildocument/' . $reg->getIdRegistrasi() ?>" title="Daftar Dokumen">
                                                        <i class="fa fa-list-alt"></i> </a>
                                                    <a href="<?= base_url() . 'backoffice/kelolaevaluasi/add/' . $reg->getIdRegistrasi() . '/' . $obj->id_proses; ?>" title="Unggah File">
                                                        <i class="fa fa-upload"></i> </a>
                                                    <?php
                                                } else {//tim teknis
                                                    ?>
                                                    <a href="<?= base_url() . 'backoffice/kelolabarang/index/' . $reg->getIdRegistrasi() ?>" 
                                                       title="Data Barang" target="_new">                        
                                                        <i class="fa fa-shopping-cart"></i> </a>
                                                    <a href="<?= base_url() . 'backoffice/kelolaproses/getpernyataanpersetujuan/' . $reg->getIdRegistrasi() ?>" 
                                                       title="Format Kesediaan Penerimaan Bantuan" target="_new">
                                                        <i class="fa fa-file-word"></i>
                                                    </a>
                                                    <a href="<?= base_url() . 'backoffice/kelolaproses/getpaktakesepakatan/' . $reg->getIdRegistrasi()  ?>" 
                                                       title="Format Pakta Kesepakatan" target="_new">
                                                        <i class="fa fa-file-word"></i>
                                                    </a>
                                                    <a href="<?= base_url() . 'backoffice/kelolaproses/getsurattugas/' . $reg->getIdRegistrasi() ?>" 
                                                       title="Format Surat Tugas Penerimaan Barang" target="_new">
                                                        <i class="fa fa-file-word"></i>
                                                    </a>
                                                    <a href="<?= base_url() . 'backoffice/kelolaproses/detaildocument/' . $reg->getIdRegistrasi() ?>" title="Daftar Dokumen">
                                                        <i class="fa fa-list-alt"></i> </a>
                                                    <a href="<?= base_url() . 'backoffice/kelolaevaluasi/add/' . $reg->getIdRegistrasi() . '/' . $obj->id_proses; ?>" title="Unggah File">
                                                        <i class="fa fa-upload"></i> </a>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <a href="<?= base_url() . 'backoffice/kelolapenugasan/edit/' . $pro->getIdProses() ?>" title="Edit">
                                                    <i class="fa fa-edit"></i> </a>
                                            <?php
                                            }
                                        } else {
                                            if ($obj->id_jns_evaluasi == '1') {
                                                //echo 'status: '.$status;
                                                //if ($obj->id_status_proses == '1') {
                                                ?>
                                                    <!--<a href="<?= base_url() . 'backoffice/kelolaproses/accept/' . $obj->id_proses ?>" title="Terima">
                                                        <i class="fa fa-check"></i> </a>
                                                    <a href="<?= base_url() . 'backoffice/kelolaproses/reject/' . $obj->id_proses ?>" title="Tolak">
                                                        <i class="fa fa-remove"></i> </a>-->
                <?php //} else {
                ?>
                                                <a href="<?= base_url() . 'backoffice/kelolaproses/downloadinstrument/' . $obj->id_proses ?>" title="Download Instrument">
                                                    <i class="fa fa-download"></i> </a>
                                                <a href="<?= base_url() . 'backoffice/kelolaproses/detaildocument/' . $reg->getIdRegistrasi() ?>" title="Daftar Dokumen">
                                                    <i class="fa fa-list-alt"></i> </a>
                                                <a href="<?= base_url() . 'backoffice/kelolaevaluasi/add/' . $reg->getIdRegistrasi() . '/' . $obj->id_proses; ?>" title="Unggah Hasil">
                                                    <i class="fa fa-upload"></i> </a>
                                                <?php
                                                //}
                                                ?>

                                                <?php
                                            } elseif($obj->id_jns_evaluasi == '2') {
                                                if ($obj->type_evaluator == '1') {//reviewer ---------
                                                    ?>
                                                                        <!--<a href="<?= base_url() . 'backoffice/kelolabarang/index/' . $reg->getIdRegistrasi() ?>" 
                                                                           title="Data Barang" target="_new">                        
                                                                            <i class="fa fa-share"></i> </a>
                                                                        <a href="<?= base_url() . 'backoffice/kelolaproses/getdraftberitaacara/' . $reg->getIdRegistrasi() ?>" 
                                                                           title="Draft Berita Acara" target="_new">
                                                                            <i class="fa fa-file-text"></i>
                                                                        </a>-->
                                                    <a href="<?= base_url() . 'backoffice/kelolaproses/getberitaacarafinal/' . $reg->getIdRegistrasi() ?>" 
                                                       title="Berita Acara Final" target="_new">
                                                        <i class="fa fa-file-word"></i>
                                                    </a>


                                                    <a href="<?= base_url() . 'backoffice/kelolaproses/detaildocument/' . $reg->getIdRegistrasi() ?>" title="Daftar Dokumen">
                                                        <i class="fa fa-list-alt"></i> </a>
                                                    <a href="<?= base_url() . 'backoffice/kelolaevaluasi/add/' . $reg->getIdRegistrasi() . '/' . $obj->id_proses; ?>" title="Unggah File">
                                                        <i class="fa fa-upload"></i> </a>
                                                    <?php
                                                } else {//tim teknis ------------------------------
                                                    ?>
                                                    <a href="<?= base_url() . 'backoffice/kelolabarang/index/' . $reg->getIdRegistrasi() ?>" 
                                                       title="Data Barang" target="_new">                        
                                                        <i class="fa fa-shopping-cart"></i> </a>
                                                    <a href="<?= base_url() . 'backoffice/kelolaproses/getpernyataanpersetujuan/' . $reg->getIdRegistrasi() ?>" 
                                                       title="Format Kesediaan Penerimaan Bantuan" target="_new">
                                                        <i class="fa fa-file-word"></i>
                                                    </a>
                                                    <a href="<?= base_url() . 'backoffice/kelolaproses/getpaktakesepakatan/' . $reg->getIdRegistrasi()  ?>" 
                                                       title="Format Pakta Kesepakatan" target="_new">
                                                        <i class="fa fa-file-word"></i>
                                                    </a>
                                                    <a href="<?= base_url() . 'backoffice/kelolaproses/getsurattugas/' . $reg->getIdRegistrasi() ?>" 
                                                       title="Format Surat Tugas Penerimaan Barang" target="_new">
                                                        <i class="fa fa-file-word"></i>
                                                    </a>
                                                    <a href="<?= base_url() . 'backoffice/kelolaproses/detaildocument/' . $reg->getIdRegistrasi() ?>" title="Daftar Dokumen">
                                                        <i class="fa fa-list-alt"></i> </a>
                                                    <a href="<?= base_url() . 'backoffice/kelolaevaluasi/add/' . $reg->getIdRegistrasi() . '/' . $obj->id_proses; ?>" title="Unggah File">
                                                        <i class="fa fa-upload"></i> </a>
                                                    <?php
                                                }
                                            }elseif($obj->id_jns_evaluasi == '3'){?>
                                                <a href="<?= base_url() . 'backoffice/kelolaregistrasi/detail/' . $reg->getIdRegistrasi() ?>" title="Detail Usulan">
                                                    <i class="fa fa-eye"></i> </a>
                                                <a href="<?= base_url() . 'backoffice/kelolapaket/getform/' . $reg->getIdRegistrasi() ?>" title="Lampiran BAP">
                                                        <i class="fa fa-list-alt"></i> </a>
                                                <a href="<?= base_url() . 'backoffice/kelolaproses/getbapmonev/' . $reg->getIdRegistrasi() ?>" title="Template BAP">
                                                        <i class="fa fa-list"></i> </a>
                                                <a href="<?= base_url() . 'backoffice/kelolaevaluasi/addbapmonev/' . $reg->getIdRegistrasi() . '/' . $obj->id_proses; ?>" title="Upload BAP">
                                                        <i class="fa fa-upload"></i> </a>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                                $i++;
                            }
                        }
                        ?>        

                    </tbody>
                </table>
            </div>
            <h4>Total Record: <span class="label label-info"><?= $total_row ?></span></h4>
            <div>
                <?php
                echo $this->pagination->create_links();
//echo $articles->count();
                ?>
            </div>

        </div>

    </div>
</div>