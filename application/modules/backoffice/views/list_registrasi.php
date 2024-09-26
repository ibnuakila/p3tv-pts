
<script type="text/javascript" >
    
</script>
<script language=javascript>
    function activation()
    {
        var answer = confirm("Registrasi usulan ini ?")
        if (answer) {
            document.messages.submit();
        }

        return false;

    }
</script>  
<h2 class="page-header">Daftar Usulan Teregistrasi</h2>
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
                            <th>No</th>
                            <th class="text-center">Id Registrasi</th> 
                            <th class="text-center">Yayasan</th> 
                            <th class="text-center">Perguruan Tinggi</th>                 
                            <th class="text-center">Tgl Registrasi</th>
                            <th class="text-center">Periode</th>
                            <th class="text-center">Schema</th>
                            <th class="text-center">Status</th>                
                            <th class="text-center">Publish</th>
                            <th class="text-center">Action</th>
                        </tr>
                        <tr class="bg-light">
                    <form method="post" action="<?= base_url() ?>backoffice/kelolaregistrasi/index/">
                        <th>Filter:</th>
                        <th><input type="text" id="keyword" name="id_registrasi" class="form-control form-control-sm"></th>
                        <th><input type="text" id="keyword" name="yayasan" class="form-control form-control-sm"></th>
                        <th><input type="text" id="keyword" name="pti" class="form-control form-control-sm"></th>
                        <th><input type="text" id="keyword" name="tgl_registrasi" class="form-control form-control-sm"></th>
                        <th>
                            <?php
                            echo form_dropdown('periode', $periode, '', 'class="form-control form-control-sm" id="periode"');
                            ?>
                        </th>
                        <th>
                            <?php
                            echo form_dropdown('schema', $skema, '', 'class="form-control form-control-sm" id="schema"');
                            ?>
                        </th>
                        <th>
                            <?php
                            echo form_dropdown('status_registrasi', $status_registrasi, '', 'class="form-control form-control-sm" id="status_registrasi"');
                            ?>
                        </th>
                        <th>
                            <?php
                            echo form_dropdown('publish_verifikasi', $publish_verifikasi, '', 'class="form-control form-control-sm" id="publish_verifikasi"');
                            ?>
                        </th>
                        <th>
                            <button type="submit" name="find" class="btn btn-primary btn-sm" value="find">
                                <i class="fa fa-search"></i>
                            </button>
                        </th>
                    </form>
                    </tr>
                    </thead>
                    <tbody>          
                        <?php //print_r($registrasi)?>                
                        <?php
                        if (isset($registrasi) && is_object($registrasi)) {
                            $segment = $this->uri->segment(4, 0);
                            $user = $this->session->userdata('userid');
                            $i = $segment + 1;
                            if ($i == '') {
                                $i = 1;
                            }
                            foreach ($registrasi->result() as $obj) {
                                $reg = new Registrasi($obj->id_registrasi);
                                //$account = $reg->getAccount();
                                //$yayasan = $account->getYayasan();
                                $pt = $reg->getPti();
                                $nm_pti = '';
                                if (is_object($pt)) {
                                    $nm_pti = $pt->getNmPti();
                                }
                                $yayasan = $reg->getPenyelenggara();
                                $status = $reg->getStatusRegistrasi();
                                $nama_status = '';
                                if (is_object($status)) {
                                    $nama_status = $status->getNamaStatus();
                                }
                                $nmyayasan = '-';
                                if (is_object($yayasan)) {
                                    $nmyayasan = $yayasan->getNamaPenyelenggara();
                                }
                                $publish = 'no';
                                $verifikasi = $reg->getVerifikasi();
                                $isVerified = '';
                                $statusVerifikasi = '';
                                //print_r($verifikasi);
                                if (is_object($verifikasi)) {
                                    $publish = $verifikasi->getPublish();
                                    $statusVerifikasi = $verifikasi->getIdStatusRegistrasi();
                                    if ($verifikasi->getIdRegistrasi() != '') {
                                        $isVerified = 'Verified';
                                    } else {
                                        
                                    }
                                }
                                $status_badge = [
                                    0 => 'badge badge-light',
                                    1 => 'badge badge-secondary',
                                    2 => 'badge badge-primary',
                                    3 => 'badge badge-warning',
                                    4 => 'badge badge-info',
                                    5 => 'badge badge-success',
                                    6 => 'badge badge-danger',
                                    7 => 'badge badge-info',
                                    8 => 'badge badge-info',
                                    9 => 'badge badge-dark',
                                    10 => 'badge badge-warning',
                                    11 => 'badge badge-warning',
                                    12 => 'badge badge-warning'
                                ];
                                
                                $class_badge = $status_badge[$reg->getIdStatusRegistrasi()];
                                ?>
                                <tr class="tbl-row">

                                    <td><?= $i ?></td>
                                    <td><?= $obj->id_registrasi ?></td>
                                    <td><?= $nmyayasan ?></td>
                                    <td><?= $nm_pti; ?></td>
                                    <td><?= $reg->getTglRegistrasi(); ?></td>
                                    <td><?= $obj->periode; ?></td>
                                    <td><?= $obj->skema; ?></td>
                                    <td>
                                        <span class="<?=$class_badge?>">
                                            <?= $nama_status; ?>
                                        </span>
                                    
                                    </td>
                                    <td>
                                        <?php
                                        if ($publish == 'yes') {
                                            if ($isVerified != '') {
                                                ?>
                                                <input type="checkbox" id="<?= $obj->id_registrasi ?>" class="pleno" checked="checked"> 
                                                <?php
                                                if ($verifikasi->getIdStatusRegistrasi() == '2') {
                                                    echo "Approved";
                                                } else {
                                                    echo "Disapproved";
                                                }
                                                ?>
                                                </input>
                                            <?php } else { ?>
                                                <input type="checkbox" id="<?= $obj->id_registrasi ?>" class="pleno" checked="checked"></input>
                                            <?php } ?>
                                            <?php
                                        } else {
                                            if ($isVerified != '') {
                                                ?>
                                                <input type="checkbox" id="<?= $obj->id_registrasi ?>" class="pleno"> 
                                                <?php
                                                if ($statusVerifikasi == '2') {
                                                    echo "Approved";
                                                } else {
                                                    echo "Disapproved";
                                                }
                                                ?>
                                                </input>
                                            <?php } else { ?>
                                                <input type="checkbox" id="<?= $obj->id_registrasi ?>" class="pleno"></input>
                                            <?php } ?>

                                        <?php } ?>
                                    </td>

                                    <td>
                                        <a href="<?= base_url() . 'backoffice/kelolaregistrasi/detail/' . $reg->getIdRegistrasi() ?>" title="Detail Usulan">
                                            <i class="fa fa-eye"></i> </a>
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
