
<!--<script src="https://cdn.tiny.cloud/1/irkqmaraklj4uhfg6oyu89yqly1g2e4ngjjtuxcuc4an9qru/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>-->
<script language=javascript>
    function deleteDocument()
    {
        var answer = confirm("Yakin dihapus ?");
        if (answer) {
            document.messages.submit();
        }

        return false;

    }
</script>

<div class="col-sm-12">
    <div class="card">
        <div class="card-header"><i class="fa fa-list"></i> Detail Registrasi</div>
        <div class="card-body">

            <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active text-uppercase" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Data Usulan</a>
                <li class="nav-item">
                    <a class="nav-link text-uppercase" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Dokumen</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-uppercase" id="dana-tab" data-toggle="tab" href="#dana" role="tab" aria-controls="profile" aria-selected="false">Pelaporan</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="row">
                        <div class="col-md-3 col-sm-12">
                            <ul class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <li><a class="nav-link text-left active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Data Usulan</a></li>
                                <li><a class="nav-link text-left" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Yayasan</a></li>
                                <li><a class="nav-link text-left" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">PTI</a></li>
                                <li><a class="nav-link text-left" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Prodi Usulan</a></li>
                                <li><a class="nav-link text-left" id="v-pills-pj-tab" data-toggle="pill" href="#v-pills-pj" role="tab" aria-controls="v-pills-pj" aria-selected="false">Penanggung Jawab</a></li>
                                <li><a class="nav-link text-left" id="v-pills-lap-tab" data-toggle="pill" href="#v-pills-lap" role="tab" aria-controls="v-pills-lap" aria-selected="false">Pelaporan</a></li>
                            </ul>
                        </div>
                        <div class="col-md-9 col-sm-12">
                            <div class="tab-content" id="v-pills-tabContent">
                                <!-- Tab Data Usulan -->
                                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                    <div class="container">
                                        <form action="" class="form-horizontal">
                                            <?php
                                            //$account = $registrasi->getAccount();
                                            //$yayasan = $account->getYayasan();
                                            $pt = $registrasi->getPti();
                                            $pdpt = $registrasi->getLaporanPdpt();
                                            $nmyayasan = '-';
                                            $ketua = '';
                                            $alamat = '';
                                            $akte = '';
                                            $notaris = '';
                                            $pengesahan = '';
                                            $email = '';
                                            $penyelenggara = $registrasi->getPenyelenggara();
                                            $penyelenggara_id = '';
                                            $ubah_pt = $registrasi->getUbahPt();
                                            $rencana_ubah_pt = $registrasi->getRencanaUbahPt();
                                            if (is_object($penyelenggara)) {
                                                $nmyayasan = $penyelenggara->getNamaPenyelenggara();
                                                $ketua = $penyelenggara->getKetuaPenyelenggara();
                                                $alamat = $penyelenggara->getAlamat();
                                                $akte = $penyelenggara->getNoAkteNotaris();
                                                $notaris = $penyelenggara->getNamaNotaris();
                                                $pengesahan = $penyelenggara->getNoSuratPengesahan();
                                                $email = $penyelenggara->getEmail();
                                                $penyelenggara_id = $penyelenggara->getPenyelenggaraId();
                                            }
                                            $status = $registrasi->getStatusRegistrasi();
                                            $skema = $registrasi->getSchema();
                                            if ($skema == '') {
                                                $skema = 'A';
                                            }
                                            $verifikasi = new Verifikasi($registrasi->getIdRegistrasi());
                                            $status_verifikasi = $verifikasi->getIdStatusRegistrasi();
                                            $objStatus = new StatusRegistrasi($status_verifikasi);
                                            $prodi = new RegistrasiProdi();
                                            $pj = new PenanggungJawab($registrasi->getIdRegistrasi());
                                            /* if(count($pts)>0){
                                              $data_akre = $pts['akreditasi_list'];
                                              } */
                                            //print_r($pts);
                                            ?>
                                            <input type="hidden" id="idregistrasi" value="<?= $registrasi->getIdRegistrasi() ?>">
                                            <!-- <input type="hidden" id="token" value="<?= $token ?>">-->
                                            <div class="form-group">
                                                <label for="pt" class="col-lg-3 control-label">No Surat:</label>
                                                <div class="col-lg-12">
                                                    <input type="text" class="form-control input-sm" disabled name="tgl_reg" value="<?= $registrasi->getNoSurat(); ?>">                                        
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="pt" class="col-lg-3 control-label">Tgl Surat:</label>
                                                <div class="col-lg-12">
                                                    <input type="text" class="form-control input-sm" disabled name="tgl_reg" value="<?= $registrasi->getTglSurat(); ?>">                                        
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="pt" class="col-lg-3 control-label">Tgl Registrasi:</label>
                                                <div class="col-lg-12">
                                                    <input type="text" class="form-control input-sm" disabled name="tgl_reg" value="<?= $registrasi->getTglRegistrasi(); ?>">                                        
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="pt" class="col-lg-3 control-label">Status Registrasi:</label>
                                                <div class="col-lg-12">
                                                    <input type="text" class="form-control input-sm" disabled name="status" id="status_ver" value="<?= $objStatus->getNamaStatus(); ?>">
                                                    <input type="hidden" id="idstatus">                                        
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="pt" class="col-lg-3 control-label">Ada Perubahan PT:</label>
                                                <div class="col-lg-12">
                                                    <input type="text" class="form-control input-sm" disabled name="tgl_reg" value="<?= $registrasi->getUbahPt(); ?>">                                        
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="pt" class="col-lg-3 control-label">Rencana Perubahan PT:</label>
                                                <div class="col-lg-12">
                                                    <input type="text" class="form-control input-sm" disabled name="tgl_reg" value="<?= $registrasi->getRencanaUbahPt(); ?>">                                        
                                                </div>
                                            </div>
                                            <?php if ($this->sessionutility->isAdministrator()) { ?>

                                                <div class="form-group">
                                                    <label for="pt" class="col-lg-3 control-label">Verifikasi:</label>
                                                    <div class="col-lg-12">
                                                        <textarea class="form-control input-sm" name="status" id="keterangan"><?php echo $verifikasi->getKeterangan() ?></textarea>                                        
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="pt" class="col-lg-3 control-label"></label>
                                                    <div class="col-lg-12">
                                                        <button class="btn btn-sm btn-success" id="approved" <?php
                                                        if ($status_verifikasi == '2') {
                                                            echo 'disabled="disabled"';
                                                        }
                                                        ?>>Approved</button>
                                                        <button class="btn btn-sm btn-warning" id="disapproved" <?php
                                                        if ($status_verifikasi == '6') {
                                                            echo 'disabled="disabled"';
                                                        }
                                                        ?>>Disapproved</button>
                                                        <!--<a href="<?= base_url() . 'backoffice/kelolaregistrasi/exportverifikasi/' . $registrasi->getIdRegistrasi() ?>" target="_new" class="btn btn-sm btn-info">Export</a>-->
                                                    </div>
                                                </div>

                                            <?php } ?>
                                        </form>
                                    </div>
                                </div>
                                
                                <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                    <div class="form-group">
                                        <label for="yayasan" class="col-lg-3 control-label">Yayasan:</label>
                                        <div class="col-lg-12">
                                            <input type="text" class="form-control input-sm" disabled name="yayasan" value="<?= $nmyayasan ?>">                                        
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="yayasan" class="col-lg-3 control-label">Ketua:</label>
                                        <div class="col-lg-12">
                                            <input type="text" class="form-control input-sm" disabled name="ketua" value="<?= $ketua ?>">                                        
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="yayasan" class="col-lg-3 control-label">Alamat:</label>
                                        <div class="col-lg-12">
                                            <input type="text" class="form-control input-sm" disabled name="alamat" value="<?= $alamat ?>">                                        
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="yayasan" class="col-lg-3 control-label">No Akte Notaris:</label>
                                        <div class="col-lg-12">
                                            <input type="text" class="form-control input-sm" disabled name="akte" value="<?= $akte ?>">                                        
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="yayasan" class="col-lg-3 control-label">Nama Notaris:</label>
                                        <div class="col-lg-12">
                                            <input type="text" class="form-control input-sm" disabled name="notaris" value="<?= $notaris ?>">                                        
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="yayasan" class="col-lg-3 control-label">No Surat Pengesahan:</label>
                                        <div class="col-lg-12">
                                            <input type="text" class="form-control input-sm" disabled name="pengesahan" value="<?= $pengesahan ?>">                                        
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="yayasan" class="col-lg-3 control-label">Email:</label>
                                        <div class="col-lg-12">
                                            <input type="text" class="form-control input-sm" disabled name="email" value="<?= $email ?>">                                        
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                                    <div class="form-group">
                                        <label for="pt" class="col-lg-3 control-label">Kode PT:</label>
                                        <div class="col-lg-12">
                                            <input type="text" class="form-control input-sm" disabled name="kdpti" id="kdpti" value="<?= $pt->getKdPti(); ?>">                                        
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="pt" class="col-lg-3 control-label">Perguruan Tinggi:</label>
                                        <div class="col-lg-12">
                                            <input type="text" class="form-control input-sm" disabled name="nmpti" id="nmpti" value="<?= $pt->getNmPti(); ?>">                                        
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="pt" class="col-lg-3 control-label">Alamat:</label>
                                        <div class="col-lg-12">
                                            <input type="text" class="form-control input-sm" disabled name="pt" value="<?= $pt->getAlamat(); ?>">                                        
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="pt" class="col-lg-3 control-label">Kota:</label>
                                        <div class="col-lg-12">
                                            <input type="text" class="form-control input-sm" disabled name="pt" value="<?= $pt->getKota(); ?>">                                        
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="pt" class="col-lg-3 control-label">Akreditasi:</label>
                                        <div class="col-lg-12">
                                            <input type="text" class="form-control input-sm" disabled name="akreditasi" id="akreditasi" value="">                                        
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="pt" class="col-lg-3 control-label">No SK Akreditasi:</label>
                                        <div class="col-lg-12">
                                            <input type="text" class="form-control input-sm" disabled name="no_sk_akre" id="no-sk-akre" value="">                                        
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="pt" class="col-lg-3 control-label">Tgl SK Akreditasi:</label>
                                        <div class="col-lg-12">
                                            <input type="text" class="form-control input-sm" disabled name="tgl_sk_akre" id="tgl-sk-akre" value="">                                        
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                            <th>Nama Prodi</th>
                                            <th>Jenjang</th>
                                            <th>Status Akreditasi</th>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $res_prodi = $prodi->getBy('id_registrasi', $registrasi->getIdRegistrasi());
                                                if ($res_prodi->num_rows() > 0) {
                                                    foreach ($res_prodi->result() as $row) {
                                                        ?>
                                                        <tr>
                                                            <td><?= $row->nama_prodi ?></td>
                                                            <td><?= $row->jenjang ?></td>
                                                            <td></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-pj" role="tabpanel" aria-labelledby="v-pills-pj-tab">
                                    <div class="form-group">
                                        <label for="pt" class="col-lg-3 control-label">Nama PJ:</label>
                                        <div class="col-lg-12">
                                            <input type="text" class="form-control input-sm" disabled name="nama_pj" value="<?= $pj->getNamaPj(); ?>">                                        
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="pt" class="col-lg-3 control-label">Handphone:</label>
                                        <div class="col-lg-12">
                                            <input type="text" class="form-control input-sm" disabled name="handphone" value="<?= $pj->getHadphone(); ?>">                                        
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="pt" class="col-lg-3 control-label">Email:</label>
                                        <div class="col-lg-12">
                                            <input type="text" class="form-control input-sm" disabled name="email_pj" value="<?= $pj->getEmail(); ?>">                                        
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="pt" class="col-lg-3 control-label">Jabatan:</label>
                                        <div class="col-lg-12">
                                            <input type="text" class="form-control input-sm" disabled name="email_pj" value="<?= $pj->getJabatan(); ?>">                                        
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v-pills-lap" role="tabpanel" aria-labelledby="v-pills-lap-tab">
                                    <div class="table-responsive">
                                        <table class="mytable" id="tbl-laporan">
                                            <thead>
                                                <tr>
                                                    <th>Semester</th>
                                                    <th>Aktifitas</th>
                                                    <th>Persentase</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Tab Dokumen -->
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="table-responsive">
                        <table class="mytable">
                            <thead class="">
                                <tr class="">
                                    <th>#</th>
                                    <th class="text-center">Nama Dokumen</th> 			                               
                                    <th class="text-center">Tersedia</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $dokumen_registrasi = new DokumenRegistrasi();
                                $res_dok_reg = $dokumen_registrasi->getByRelated('registrasi', 'id_registrasi', $registrasi->getIdRegistrasi(), '0', '0');
                                $i = 1;
                                if ($res_dok_reg->num_rows() > 0) {

                                    foreach ($res_dok_reg->result() as $row) {
                                        $dokumen = new Dokumen();
                                        $params['id_form'] = $row->id_form;
                                        //$params['skema'] = $registrasi->getSchema();
                                        $params['periode'] = $registrasi->getPeriode();
                                        $dokumen->getByArray($params);
                                        ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td class=""><?= $dokumen->getFormName() ?></td>
                                            <td>
                                                <?php
                                                $ischecked = '';
                                                $label = '-';
                                                if ($dokumen->getIdForm() != '') {
                                                    $label = 'Ya';
                                                } else {
                                                    $label = 'Tidak';
                                                }
                                                if ($row->verifikasi == 'y') {
                                                    $ischecked = 'checked';
                                                    $label = 'Verified';
                                                }
                                                ;
                                                ?>
                                                <input type="checkbox" id="<?= $row->id_upload ?>" class="tersedia" <?= $ischecked; ?> > 
                                                <label id="lbl_<?= $row->id_upload ?>"><?= $label; ?>                                                                       
                                                </label>
                                            </td>
                                            <td>
                                                <?php $item = array('F10', 'F11', 'F12', 'F13'); ?>
                                                <?php if (in_array($row->id_form, $item)) { ?>
                                                    <a href="<?= base_url() . 'backoffice/kelolaevaluasi/downloaddocument/' . $row->id_upload ?>"><i class=" fa fa-download"></i></a>
                                                <?php } else { ?>
                                                    <a href="<?= base_url() . 'backoffice/kelolaevaluasi/downloaddocument/' . $row->id_upload ?>"><i class=" fa fa-download"></i></a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                }
                                $rekapitulasi = new Rekapitulasi();
                                $rekapitulasi->getBy('id_registrasi', $registrasi->getIdRegistrasi());
                                if($rekapitulasi->getKeterangan() != ''){?>
                                    <tr>
                                        <td><?=$i?></td>
                                        <td>Consolidated Comment</td>
                                        <td></td>
                                        <td>
                                            <a class="" href="<?= base_url() . 'backoffice/kelolarekapitulasi/downloadComment/' . $registrasi->getIdRegistrasi() ?>"><i class="fa fa-download"></i></a>
                                        </td>
                                    </tr>
                                
                                <?php $i++; } ?>
                                                                        
                                <?php
                                
                                //$dokumen_perbaikan->setSkema($registrasi->getSchema());
                                //$dokumen_perbaikan->setPeriode($registrasi->getPeriode());
                                //$dokumen_perbaikan->setJnsUsulan($registrasi->getJnsUsulan());
                                //$res_dok_per = $dokumen_perbaikan->get('0', '0');
                                
                                $dokper_upload = new DokumenPerbaikanUpload();
                                $params['paging'] = ['row' => 0, 'segment' => 0];
                                $params['field'][DokumenPerbaikanUpload::table.'.id_registrasi'] = ['=' => $registrasi->getIdRegistrasi()];
                                $res_dok_per = $dokper_upload->getResult($params);
                                if($res_dok_per->num_rows()>0){
                                    foreach ($res_dok_per->result() as $rdp) {
                                        $params['id_form'] = $rdp->id_form;
                                        $params['periode'] = '20241';
                                        $dokumen_perbaikan = new DokumenPerbaikan($params);
                                    ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><?= $dokumen_perbaikan->getFormName() ?></td>
                                        <td><?=$rdp->revisi_proposal?></td>
                                        <td>
                                            <a href="<?= base_url() . 'backoffice/kelolaevaluasi/downloaddocumentperbaikan/' . $registrasi->getIdRegistrasi() . '/' . $rdp->id_upload ?>">
                                                <i class="fa fa-download"></i></a> 
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                    } 
                                }?>
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="">
                                <tr>
                                    <th>Id Registrasi</th>
                                    <th>Referensi</th>
                                    <th>Nama File</th>                    
                                    <th>Tgl Upload</th>
                                    <th>Revisi</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $rekapitulasi_berita = new RekapitulasiBeritaAcara();
                                $rekapitulasi_berita->setIdRegistrasi($registrasi->getIdRegistrasi());
                                $res_rekap = $rekapitulasi_berita->get('0', '0');
                                $this->load->model('Dokumenpresentasi');

                                if ($res_rekap->num_rows() > 0) {
                                    //print_r($res_rekap->result());
                                    foreach ($res_rekap->result() as $row) {
                                        $dok_pres = new DokumenPresentasi($row->id_dp);
                                        //$dok_pres->getBy('id_jns_file', $row->id_jns_file);
                                        ?>
                                        <tr>
                                            <td><?= $row->id_registrasi ?></td>
                                            <td><?= $row->referensi ?></td>
                                            <td><?= $dok_pres->getNamaFile() ?></td>
                                            <td><?= $row->tgl_upload ?></td>
                                            <td><?= $row->revisi ?></td>
                                            <td>
                                                <a href="<?= base_url() . 'backoffice/kelolaevaluasi/downloadfilepresentasi/' . $row->id . '/' . $dok_pres->getId(); ?>" target="new" title="Unduh">
                                                    <i class="fa fa-download"></i><a/>
                                                    <a href="<?= base_url() . 'backoffice/kelolaevaluasi/removedokumen/' . $row->id . '/' . $row->id_registrasi ?>" 
                                                       target="new" title="Delete" onclick="return deleteDocument()">
                                                        <i class="fa fa-times"></i><a/>
                                                        </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }

                                                $laporan_pernyataan = new LaporanPernyataan($registrasi->getIdRegistrasi());
                                                if ($laporan_pernyataan->getId() != '') {
                                                    ?>
                                                    <tr>
                                                        <td><?= $laporan_pernyataan->getIdRegistrasi() ?></td>
                                                        <td>Pengusul</td>
                                                        <td>Laporan Pernyataan</td>
                                                        <td><?= $laporan_pernyataan->getUploadDate() ?></td>
                                                        <td></td>
                                                        <td>
                                                            <a href="<?= base_url() . 'backoffice/kelolaregistrasi/downloadlaporanpernyataan/' . $laporan_pernyataan->getIdRegistrasi(); ?>" target="new" title="Unduh">
                                                                <i class="fa fa-download"></i>
                                                                <a/>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                $laporan_capaian = new LaporanCapaian();
                                                $laporan_capaian->setIdRegistrasi($registrasi->getIdRegistrasi());
                                                $res_capaian = $laporan_capaian->get('0', '0');
                                                if ($res_capaian->num_rows() > 0) {
                                                    ?>
                                                    <tr>
                                                        <td><?= $laporan_capaian->getIdRegistrasi() ?></td>
                                                        <td>Pengusul</td>
                                                        <td>Laporan Capaian</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td>
                                                            <a href="<?= base_url() . 'backoffice/kelolaregistrasi/downloadlaporancapaian/' . $laporan_capaian->getIdRegistrasi() ?>" target="new" title="Unduh">
                                                                <i class="fa fa-download"></i>
                                                                <a/>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                                </tbody>
                        </table>
                    </div>
                </div>
                <!-- Tab dana pendamping -->              
                <div class="tab-pane fade" id="dana" role="tabpanel" aria-labelledby="profile-tab">
                    <h3>Laporan Kemajuan</h3>
                        <table class="table table-striped">
                            <thead>
                            <th>No Registrasi</th>
                            <th>Berkas</th>
                            <th>Tgl Upload</th>                            
                            <th>Action</th>
                            </thead>
                            <tbody>
                                <?php
                                $lap_kemajuan = new Laporankemajuan($registrasi->getIdRegistrasi());
                                if($lap_kemajuan->id != ''){
                                ?>
                                <tr>
                                    <td><?= $lap_kemajuan->idRegistrasi?></td>
                                    <td>Laporan Kemajuan</td>
                                    <td><?= $lap_kemajuan->uploadDate?></td>
                                    <td>
                                        <a href="<?= base_url() . 'backoffice/kelolaregistrasi/downloadlaporankemajuan/' . $lap_kemajuan->idRegistrasi ?>" title="Unduh">
                                                <i class="fa fa-download"></i>
                                                <a/>
                                    </td>
                                    
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php
                    
                    include('detail_pelaporan.php');
                    ?>
                </div>
                
                <!--<div class="tab-pane fade" id="dana" role="tabpanel" aria-labelledby="profile-tab">
                        
                    <div class="table-responsive">
                        <h3>Laporan Akhir</h3>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID Registrasi</th>
                                    <th>Nama Dokumen</th>
                                    <th>Tgl Upload</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $this->db->select('*'); $this->db->from('laporan_akhir');$this->db->where('id_registrasi', $registrasi->getIdRegistrasi());
                                $res_file_dp = $this->db->get();
                                if($res_file_dp->num_rows() > 0){
                                    foreach ($res_file_dp->result() as $res){?>
                                <tr>
                                    <td><?= $res->id_registrasi?></td>
                                    <td>
                                        <?php
                                            if($res->tipe_file == 'pdf'){
                                                echo 'Surat Pernyataan';
                                            }else{
                                                echo 'Laporan Akhir';
                                            }
                                        ?>
                                    </td>
                                    <td><?= $res->upload_date?></td>
                                    <td>
                                        <a href="<?= base_url() . 'backoffice/kelolaregistrasi/downloadlaporanakhir/' . $res->id ?>" title="Unduh">
                                                <i class="fa fa-download"></i>
                                        <a/>
                                        <?php if($res->tipe_file == 'excel'){ 
                                                $lap_akhir_iku = new LaporanAkhirIku($res->id_registrasi);
                                                if(!$lap_akhir_iku->isExist()){
                                            ?>
                                        <a href="" title="Read Laporan Akhir" id="get-laporan" id-laporan="<?=$res->id?>">
                                                <i class="fa fa-eye"></i>
                                        <a/>
                                        <?php   } 
                                        }?>
                                    </td>
                                </tr>
                                <?php } 
                                } ?>
                            </tbody>
                        </table>
                        <div class="container">
                            <ul class="nav nav-tabs mb-3" id="tab-lap-akhir" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active text-uppercase" id="indikator-tab" data-toggle="tab" href="#indikator" role="tab" aria-controls="indikator" aria-selected="true">Indikator</a>
                                <li class="nav-item">
                                    <a class="nav-link text-uppercase" id="peralatan-tab" data-toggle="tab" href="#peralatan" role="tab" aria-controls="peralatan" aria-selected="false">Peralatan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-uppercase" id="dana-pendamping-tab" data-toggle="tab" href="#dana-pendamping" role="tab" aria-controls="dana-pendamping" aria-selected="false">Dana Pendamping</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="content-tab-lap-akhir">
                                <div class="tab-pane fade show active" id="indikator" role="tabpanel" aria-labelledby="indikator-tab">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                            <th>Indikator Kinerja</th>
                                            <th>Base Line</th>
                                            <th>Target</th>
                                            <th>Capaian (%)</th>
                                            <th>Kendala</th>
                                            <th>Solusi</th>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                if(isset($data_lap_iku) && $data_lap_iku->num_rows()>0){
                                                        foreach ($data_lap_iku->result() as $value) {?>
                                                <tr>
                                                    <td><?=$value->indikator_kinerja ?></td>
                                                    <td><?=$value->base_line?></td>
                                                    <td><?=$value->target?></td>
                                                    <td><?=$value->capaian?></td>
                                                    <td><?=$value->kendala?></td>
                                                    <td><?=$value->solusi?></td>
                                                </tr>
                                                <?php
                                                        }
                                                }?>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                </div>
                                <div class="tab-pane fade" id="peralatan" role="tabpanel" aria-labelledby="peralatan-tab">
                                    <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <th>Paket Barang</th>
                                        <th>Nama Peralatan</th>
                                        <th>Jumlah Unit</th>
                                        <th>Status</th>
                                        <th>Peruntukkan</th>                                        
                                        </thead>
                                        <tbody>
                                            <?php 
                                                if(isset($data_lap_pemanfaatan) && $data_lap_pemanfaatan->num_rows()>0){
                                                        foreach ($data_lap_pemanfaatan->result() as $value) {?>
                                                <tr>
                                                    <td><?=$value->paket_barang ?></td>
                                                    <td><?=$value->nama_peralatan?></td>
                                                    <td><?=$value->jumlah_unit?></td>
                                                    <td><?=$value->status?></td>
                                                    <td><?=$value->peruntukkan?></td>                                                    
                                                </tr>
                                                <?php
                                                        }
                                                }?>
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="dana-pendamping" role="tabpanel" aria-labelledby="dana-pendamping-tab">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                        <thead>
                                        <th>Jenis Kegiatan</th>
                                        <th>Nama Kegiatan</th>
                                        <th>Mata Kuliah</th>
                                        <th>Tgl Pelaksanaan</th>
                                        <th>Dana PTS</th>
                                        <th>Realisasi Dana PTS</th>
                                        <th>Luaran</th>                                        
                                        </thead>
                                        <tbody>
                                            <?php 
                                                if(isset($data_lap_dana_pendamping) && $data_lap_dana_pendamping->num_rows()>0){
                                                        foreach ($data_lap_dana_pendamping->result() as $value) {?>
                                                <tr>
                                                    <td><?=$value->jns_kegiatan ?></td>
                                                    <td><?=$value->nama_kegiatan?></td>
                                                    <td><?=$value->mata_kuliah?></td>
                                                    <td><?=$value->tgl_pelaksanaan?></td>
                                                    <td><?=$value->dana_pts?></td>
                                                    <td><?=$value->realisasi_dana_pts?></td>
                                                    <td><?=$value->output_luaran?></td>
                                                </tr>
                                                <?php
                                                        }
                                                }?>
                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h3>Realisasi</h3>
                        <button type="button" class="btn  btn-primary btn-sm mb-2" data-toggle="modal" data-target="#exampleModalLive" fdprocessedid="rh91c">
                            Add
                        </button>                        
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kegiatan</th>
                                    <th>Keuangan</th>
                                    <th>Volume Output</th>                    
                                    <th>Output Kegiatan</th>
                                    <th>Realisasi Keuangan</th>
                                    <th>Realisasi Vol Output</th>
                                    <th>Bukti Luaran</th>
                                    <th>Berkas</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if(isset($danas)){
                                        $no = 1;
                                        foreach($danas->result() as $dana){?>
                                <tr>
                                    <td><?=$no ?></td>
                                    <td><?= $dana->nama_kegiatan ?></td>
                                    <td><?= $dana->keuangan ?></td>
                                    <td><?= $dana->vol_output ?></td>
                                    <td><?= $dana->output_kegiatan ?></td>
                                    <td><?= $dana->real_keuangan ?></td>
                                    <td><?= $dana->real_vol_output ?></td>
                                    <td>
                                        <?php if($dana->bukti_luaran != ''){ ?>
                                            Dokumen Tersedia
                                        <?php }else{ ?>
                                            Tidak Ada Dokumen
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if($dana->bukti_luaran != ''){ ?>
                                        <a href="<?= base_url() . 'backoffice/kelolaregistrasi/downloadbuktiluaran/' . $dana->id ?>" title="Unduh">
                                                <i class="fa fa-download"></i>
                                        <a/>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <a href="#" class="edit-dana" id="<?=$dana->id?>"><i class="fa fa-edit"></i></a>
                                        <a href="#" class="delete-dana" id="<?=$dana->id?>"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr>
                                <?php   $no++;
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                        <h3>Laporan Kemajuan</h3>
                        <table class="table table-striped">
                            <thead>
                            <th>No Registrasi</th>
                            <th>Berkas</th>
                            <th>Tgl Upload</th>                            
                            <th>Action</th>
                            </thead>
                            <tbody>
                                <?php
                                $lap_kemajuan = new Laporankemajuan($registrasi->getIdRegistrasi());
                                if($lap_kemajuan->id != ''){
                                ?>
                                <tr>
                                    <td><?= $lap_kemajuan->idRegistrasi?></td>
                                    <td>Laporan Kemajuan</td>
                                    <td><?= $lap_kemajuan->uploadDate?></td>
                                    <td>
                                        <a href="<?= base_url() . 'backoffice/kelolaregistrasi/downloadlaporankemajuan/' . $lap_kemajuan->idRegistrasi ?>" title="Unduh">
                                                <i class="fa fa-download"></i>
                                                <a/>
                                    </td>
                                    
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>-->
            </div>
        </div>
    </div>
</div>

<?php
include 'form_dana.php';

