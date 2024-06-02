
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
    <?=$title?>
</h2>

<div class="card mb-2 mt-auto">
    <div class="card-header"><i class="fa fa-search fa-white"></i> Pencarian</div>
    <div class="card-body ">
        
        <div class="row-fluid">
            <div class="table-responsive">
                <table class="table table-condensed table-striped table-bordered">
                    <thead class="">
                        <tr class="" >
                            <th>#</th>
                            <th class="text-center">No Registrasi</th>
                            <!--<th class="text-center">No Evaluasi</th>-->
                            <th class="text-center">Yayasan</th> 
                            <th class="text-center">Perguruan Tinggi</th>                 
                            <th class="text-center">Evaluator</th>
                            <th class="text-center">Tgl Evaluasi</th>
                            <th class="text-center">Status Proses</th>
                            <th class="text-center">Skor</th>                                
                            <th class="text-center">Action</th>
                        </tr>
                        <tr>
                            <form method="post" action="<?= $base_url ?>">
                                <th>#</th>
                                <th><input type="text" id="id_registrasi" name="id_registrasi" class="form-control form-control-sm"></th>
                                <th><input type="text" id="yayasan" name="yayasan" class="form-control form-control-sm"></th>
                                <th><input type="text" id="pti" name="pti" class="form-control form-control-sm"></th>
                                <th><input type="text" id="evaluator" name="evaluator" class="form-control form-control-sm"></th>                               
                                <th>#</th>
                                <th>
                                    <?php
                                    echo form_dropdown('status_proses', $status_proses, '', 'class="form-control form-control-sm" id="status_proses"');
                                    ?>
                                </th>
                                <th>#</th>                                
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
                        if (isset($evaluasi) && $evaluasi != null) {
                            //print_r($evaluasi->num_rows());
                            $segment = $this->uri->segment(4, 0);
                            $user = $this->session->userdata('userid');
                            $i = $segment + 1;
                            if ($i == '') {
                                $i = 1;
                            }
                            foreach ($evaluasi->result() as $obj) {
                                $eva = new Evaluasi($obj->id_evaluasi);
                                $pro = $eva->getProses();
                                $reg = $pro->getRegistrasi();
                                $pt = $reg->getPti();
                                //print_r($reg);
                                //$account = $reg->getAccount();
                                $yayasan = $reg->getPenyelenggara();
                                //$_evaluasi = $pro->getEvaluasi();
                                $nmyayasan = '-';
                                if (is_object($yayasan)) {
                                    $nmyayasan = $yayasan->getNamaPenyelenggara();
                                }
                                $nmpti = '-';
                                if(is_object($pt)){
                                    $nmpti = $pt->getNmPti();
                                }
                                $status = $pro->getStatusProses();
                                //$status_eval = new StatusRegistrasi($obj->id_status_registrasi);
                                $stat_eval = '';
                                $skor = '';
                                if (is_object($eva)) {
                                    $stat = $eva->getStatusRegistrasi();
                                    if ($stat != null) {
                                        $stat_eval = $stat->getNamaStatus();
                                    }
                                    $skor = $eva->getSkor();
                                }
                                $evaluator = new Evaluator($pro->getIdEvaluator());
                                ?>
                                <tr class="<?php
                                if ($status->getIdStatusProses() == '4') {
                                    echo 'table-danger';
                                } 
                                ?>">

                                    <td><?= $i ?></td>
                                    <td><?= $reg->getIdRegistrasi() ?></td>
                                    
                                    <td><?= $nmyayasan; ?></td>
                                    <td><?= $nmpti; ?></td>
                                    <td><?= $evaluator->getNmEvaluator(); ?></td>
                                    <td><?= $obj->tgl_evaluasi; ?></td>
                                    
                                    <td>
                                            <?php 
                                            if ($status->getIdStatusProses() == '4') {
                                                echo '<span class="badge badge-danger">'.$status->getNamaStatus().'</span>';                                            
                                            } else {
                                                echo '<span class="badge badge-info">'.$status->getNamaStatus().'</span>';
                                            }?>
                                    </td>
                                    <td>
                                            <?php 
                                            if($eva->getRange() == 'green'){
                                                echo '<span class="badge badge-success">'.$skor.'</span>'; 
                                            }else{
                                                echo '<span class="badge badge-danger">'.$skor.'</span>'; 
                                            }
                                            ?>
                                    </td>
                                    
                                    <td>

                                        <a href="<?= base_url() . 'backoffice/kelolaevaluasi/view/' . $reg->getIdRegistrasi() ?>" title="View">
                                            <i class="fa fa-file"></i> </a>

                                        <a href="<?= base_url() . 'backoffice/kelolaevaluasi/edit/' . $reg->getIdRegistrasi() . '/' . $pro->getIdProses(); ?>" title="Upload Hasil">
                                            <i class="fa fa-upload"></i> </a>
                                        <a href="<?= base_url() . 'backoffice/kelolaproses/detaildocument/' . $reg->getIdRegistrasi() ?>" title="Daftar Dokumen">
                                            <i class="fa fa-list-alt"></i> </a>
                                    <?php
                                    if($pro->getTypeEvaluator() == 1){
                                    ?>
                                        <a href="<?= base_url() . 'backoffice/kelolaevaluasi/addcomment/' . $reg->getIdRegistrasi() . '/' . $pro->getIdProses();?>" title="Komentar Terkonsolidasi">
                                            <i class="fa fa-comment"></i> </a>
                                        <a href="<?= base_url() . 'backoffice/kelolabarang/index/' . $reg->getIdRegistrasi() ?>" 
                                                       title="Data Barang" target="_new">                        
                                                        <i class="fa fa-shopping-cart"></i> </a>
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
            <h4>Total Record: <span class="label label-info"><?= $total_row ?></span></h4>
            <div>
                <?php
                echo $this->pagination->create_links();

                ?>
            </div>
        </div>

    </div>
</div>




