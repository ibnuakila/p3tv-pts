
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


<h2 class="page-header">
    Penugasan Evaluasi
</h2>

<div class="card mb-3">
    <div class="card-header"><i class="fa fa-search"></i> Pencarian</div>
    <div class="card-body">
        
        <div class="row-fluid">
            <div class="table-responsive">
                <table class="table table-condensed table-striped table-bordered">
                    <thead class="bg-light">
                        <tr class="" >
                            <th>No</th>
                            <th class="text-center">Id Registrasi</th>
                            <th class="text-center">Yayasan</th> 
                            <th class="text-center">Perguruan Tinggi</th>                 
                            <th class="text-center">Tgl Registrasi</th>
                            <th class="text-center">Periode</th>
                            <th class="text-center">Penugasan</th>
                            <th class="text-center">Status</th>                
                            <th class="text-center">Action</th>
                        </tr>
                        <tr class="bg-light">
                    <form method="post" action="<?= base_url() ?>backoffice/kelolapenugasan/index/">
                        <th>#</th>
                        <th><input type="text" id="keyword" name="id_registrasi" class="form-control form-control-sm"></th>
                        <th><input type="text" id="keyword" name="yayasan" class="form-control form-control-sm"></th>
                        <th><input type="text" id="keyword" name="pti" class="form-control form-control-sm"></th>
                        <th><input type="text" id="keyword" name="tgl_registrasi" class="form-control form-control-sm"></th>
                        <th>
                            <?php
                            echo form_dropdown('periode', $periode, '', 'class="form-control form-control-sm" id="periode"');
                            ?>
                        </th>
                        <th><input type="text" id="keyword" name="penugasan" class="form-control form-control-sm"></th>
                        <th>
                            <?php
                            echo form_dropdown('status_registrasi', $status_registrasi, '', 'class="form-control form-control-sm" id="status_registrasi"');
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

                        <?php
                        if (isset($registrasi) && $registrasi != null) {
                            $segment = $this->uri->segment(4, 0);
                            $user = $this->session->userdata('userid');
                            $i = $segment + 1;
                            if ($i == '') {
                                $i = 1;
                            }
                            foreach ($registrasi->result() as $obj) {
                                $reg = new Registrasi($obj->id_registrasi);
                                //$account = $reg->getAccount();
                                $yayasan = $reg->getPenyelenggara();
                                $nmyayasan = '-';
                                if (is_object($yayasan)) {
                                    $nmyayasan = $yayasan->getNamaPenyelenggara();
                                }
                                $pt = $reg->getPti();
                                $status = $reg->getStatusRegistrasi();
                                ?>
                                <tr class="tbl-row">

                                    <td><?= $i ?></td>
                                    <td><?= $obj->id_registrasi ?></td>
                                    <td><?= $nmyayasan ?></td>
                                    <td><?= $pt->getNmPti(); ?></td>
                                    <td><?= $reg->getTglRegistrasi(); ?></td>
                                    <td><?= $reg->getPeriode()?></td>
                                    <td><?= $reg->getPenugasan()?></td>
                                    <td><?= $status->getNamaStatus() ?></td>           
                                    <td>
                                        <?php if ($status->getIdStatusRegistrasi() == '11') { ?>
                                            <a href="<?= base_url() . 'backoffice/kelolapenugasan/add/' . $reg->getIdRegistrasi() ?>" title="Tugaskan Substansi 2">
                                                <i class="fa fa-envelope"></i> </a>
                                            <!--<label class="badge badge-secondary" data-toggle="tooltip" data-placement="top" title="Tugaskan"><?= $reg->getPenugasan() ?></label>-->
                                        <?php } else { ?>
                                            <a href="<?= base_url() . 'backoffice/kelolapenugasan/add/' . $reg->getIdRegistrasi() ?>" title="Tugaskan">
                                                <i class="fa fa-envelope"></i> </a>
                                            <!--<label class="badge badge-secondary" data-toggle="tooltip" data-placement="top" title="Tugaskan"><?= $reg->getPenugasan() ?></label>-->
                                        <?php } ?>
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
            <div>
                <?php
                echo $this->pagination->create_links();
                //echo $articles->count();
                ?>
            </div>
        </div>
    </div>
</div>



<div class="row-fluid">


</div>

</div>