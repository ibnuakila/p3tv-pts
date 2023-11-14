
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
    Daftar Rekapitulasi Hasil Evaluasi
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
                            
                            <th class="text-center">Tgl Evaluasi</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Skor</th>   
                            <th class="text-center">Publish</th>
                            <th class="text-center">Action</th>
                        </tr>
                        <tr>
                            <form method="post" action="<?= base_url() ?>backoffice/kelolarekapitulasi/index/">
                                <th>#</th>
                                <th><input type="text" id="id_registrasi" name="id_registrasi" class="form-control form-control-sm"></th>
                                <th><input type="text" id="yayasan" name="yayasan" class="form-control form-control-sm"></th>
                                <th><input type="text" id="pti" name="pti" class="form-control form-control-sm"></th>
                                                           
                                <th>#</th>
                                <th>
                                    <?php
                                    echo form_dropdown('status_registrasi', $status_registrasi, '', 'class="form-control form-control-sm" id="status_proses"');
                                    ?>
                                </th>
                                <th>#</th>
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
                                $eva = new Rekapitulasi($obj->id_rekapitulasi);
                                //$pro = $eva->getProses();
                                $reg = $eva->getRegistrasi();
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
                                $status = new StatusRegistrasi($eva->getIdStatusRegistrasi());
                                //$status_eval = new StatusRegistrasi($obj->id_status_registrasi);
                                $stat_eval = '';
                                $skor = '';
                                if (is_object($eva)) {
                                    $stat = $eva->getStatusRegistrasi();
                                    if ($stat != null) {
                                        $stat_eval = $stat->getNamaStatus();
                                    }
                                    $skor = $eva->getNilaiTotal();
                                }
                                //$evaluator = new Evaluator($pro->getIdEvaluator());
                                ?>
                                <tr class="<?php
                                
                                ?>">

                                    <td><?= $i ?></td>
                                    <td><?= $reg->getIdRegistrasi() ?></td>
                                    
                                    <td><?= $nmyayasan; ?></td>
                                    <td><?= $nmpti; ?></td>
                                    
                                    <td><?= $obj->tgl_rekap; ?></td>
                                    
                                    <td>
                                            <?php 
                                            if ($status->getIdStatusRegistrasi() == '6') {
                                                echo '<a class="badge badge-danger update-status" href=""'
                                                . 'data-toggle="modal" data-target="#modal-status" '
                                                        . 'id="'.$obj->id_rekapitulasi.'">'.$status->getNamaStatus().'</a>';                                            
                                            } else {
                                                echo '<a class="badge badge-info update-status" href=""'
                                                . 'data-toggle="modal" data-target="#modal-status" '
                                                        . 'id="'.$obj->id_rekapitulasi.'">'.$status->getNamaStatus().'</a>';
                                            }?>
                                    </td>
                                    <td>
                                            <?php 
                                            if($eva->getNilaiTotal() <= 300){
                                                echo '<span class="badge badge-danger">'.$skor.'</span>'; 
                                            }else{
                                                echo '<span class="badge badge-success">'.$skor.'</span>'; 
                                            }
                                            ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($eva->getPublish() == 'yes') {                                            
                                                ?>
                                                <input type="checkbox" id="<?= $obj->id_registrasi ?>" class="pleno" checked="checked"> 
                                                Publish
                                                </input>                                            
                                        <?php
                                        } else {                                            
                                                ?>
                                                <input type="checkbox" id="<?= $obj->id_registrasi ?>" class="pleno"> 
                                                Publish
                                                </input>
                                            

                                        <?php } ?>
                                    </td>
                                    <td>

                                        <a href="<?= base_url() . 'backoffice/kelolaevaluasi/view/' . $reg->getIdRegistrasi() ?>" title="View">
                                            <i class="fa fa-file"></i> </a>
                                        <?php
                                        if($eva->getKeterangan()!=''){
                                        ?>
                                        <a href="<?= base_url() . 'backoffice/kelolarekapitulasi/downloadComment/' . $reg->getIdRegistrasi() ?>" title="Download Komentar">
                                            <i class="fa fa-comment"></i> </a>
                                        <?php } ?>
                                        <!--<a href="<?= base_url() . 'backoffice/kelolaproses/detaildocument/' . $reg->getIdRegistrasi() ?>" title="Daftar Dokumen">
                                            <i class="fa fa-list-alt"></i> </a>
                                    
                                        <a href="<?= base_url() . 'backoffice/kelolaevaluasi/addcomment/' . $reg->getIdRegistrasi() ;?>" title="Komentar Terkonsolidasi">
                                            <i class="fa fa-comment"></i> </a>-->
                                                                            
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

                ?>
            </div>
        </div>

    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-status" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Status:</label>
                    <?php                    
                    echo form_dropdown('id_status_registrasi', $status_registrasi, '', 'class="form-control form-control-sm" id="id_status_registrasi"');
                    ?>
                    <input type="hidden" id="id_rekapitulasi">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline-primary" id="btn-save">Save changes</button>
            </div>
        </div>
    </div>
</div>


