
<div class="col-sm-12">
    <h3 class="display-5">
        Input Data Luaran
    </h3>
    <hr>
    <div class="card">
        <div class="card-header">
            <button type="button" class="btn  btn-primary" data-toggle="modal" data-target="#form-luaran">Add New</button>
        </div>
        <div class="card-body" >
            <input type="hidden" id="base_url" value="<?= base_url() ?>">
            <input type="hidden" id="id_registrasi" value="<?= $registrasi->getIdRegistrasi() ?>">
            <input type="hidden" id="id_luaran" value="<?= '' ?>">
                <?php
                //$account = $registrasi->getAccount();
                $yayasan = $registrasi->getPenyelenggara();
                $nm_yayasan = '';
                if (is_object($yayasan)) {
                    $nm_yayasan = $yayasan->getNamaPenyelenggara();
                }
                $pt = $registrasi->getPti();
                $nm_pti = '';
                if (is_object($pt)) {
                    $nm_pti = $pt->getNmPti();
                }
                $status = $registrasi->getStatusRegistrasi();                         
                
                ?>
            <div class="row-fluid">
                <div class="table-responsive">
                    <table class="table table-condensed table-striped table-bordered" id="tbl-luaran">
                        <thead class="">
                            <tr class="" >
                                <th>#</th>
                                <th class="text-center">Nama Prodi</th> 
                                <th class="text-center">Ruang Lingkup</th>
                                <th class="text-center">Program Pengembangan</th>
                                <th class="text-center">Bentuk Luaran</th>
                                <th class="text-center">Jumlah Luaran</th>
                                <th class="text-center">Tahun</th>
                                <th class="text-center">Waktu Pelaksanaan</th>
                                <th class="text-center">Biaya</th>
                                <th class="text-center">Target IKU</th>
                                <th class="text-center">Keterangan</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if(isset($result) && $result->num_rows()>0){
                                $i=1;
                                foreach ($result->result() as $row) {?>
                            <tr>
                                <td><?=$i?></td>
                                <td><?=$row->nama_prodi?></td>
                                <td><?=$row->ruang_lingkup?></td>
                                <td><?=$row->program_pengembangan?></td>
                                <td><?=$row->bentuk_luaran?></td>
                                <td><?=$row->jumlah_luaran?></td>
                                <td><?=$row->tahun?></td>
                                <td><?=$row->waktu_pelaksanaan?></td>
                                <td><?=$row->biaya?></td>
                                <td><?=$row->target_iku?></td>
                                <td><?=$row->keterangan?></td>
                                <td>
                                    <a href="#" class="edit" id="<?=$row->id?>"><i class="fa fa-edit"></i></a>
                                    <a href="#" class="delete" id="<?=$row->id?>"><i class="fa fa-minus-circle"></i></a>
                                </td>
                            </tr>
                            <?php $i++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
               


            <!-- modal -->
            <div id="form-luaran" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form id="my-form" method="post">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="gridModalLabel">Form Luaran</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="id" value="" name="id">
                            <div class="container-fluid">
                                <div class="form-group">
                                    <label class="control-label lbl-color" >Nama Prodi:</label>                                    
                                    <input type="text" id="nama-prodi" name="nama_prodi" class="form-control input-sm" value="<?= '' ?>">                      
                                </div>
                                <div class="form-group">
                                    <label class="control-label lbl-color" >Ruang Lingkup:</label>                                    
                                        <!--<input type="text" id="ruang-lingkup" name="ruang_lingkup" class="form-control input-sm" value="<?= '' ?>">-->
                                    <?php
                                    $opt_ruang_lingkup = ['-Pilih-' => '', 'Pemenuhan CPL' => 'Pemenuhan CPL', 'Peningkatan Kerjasama' => 'Peningkatan Kerjasama'];
                                    echo form_dropdown('ruang_lingkup', $opt_ruang_lingkup, '', 'id="ruang-lingkup" class="form-control input-sm"');
                                    ?>
                                </div>
                                <div class="form-group">
                                    <label class="control-label lbl-color" >Program Pengembangan:</label>                                    
                                        <input type="text" id="program" name="program" class="form-control input-sm" value="<?= '' ?>">
                                </div>
                                <div class="form-group">
                                    <label class="control-label lbl-color" >Bentuk Luaran:</label>                                    
                                        <input type="text" id="bentuk-luaran" name="bentuk_luaran" class="form-control input-sm" value="<?= '' ?>"> 
                                </div>
                                <div class="form-group">
                                    <label class="control-label lbl-color" >Jumlah Luaran:</label>                                    
                                        <input type="text" id="jumlah-luaran" name="jumlah_luaran" class="form-control input-sm" value="<?= '' ?>">
                                </div>
                                <div class="form-group">
                                    <label class="control-label lbl-color" >Tahun:</label>                                    
                                        <input type="text" id="tahun" name="tahun" class="form-control input-sm" value="<?= '' ?>">
                                </div>
                                <div class="form-group">
                                    <label class="control-label lbl-color" >Waktu Pelaksanaan:</label>                                    
                                        <input type="text" id="waktu-laksana" name="waktu_laksana" class="form-control input-sm" value="<?= '' ?>">
                                </div>
                                <div class="form-group">
                                    <label class="control-label lbl-color" >Biaya:</label>                                    
                                        <input type="text" id="biaya" name="biaya" class="form-control input-sm" value="<?= '' ?>">
                                </div>
                                <div class="form-group">
                                    <label class="control-label lbl-color" >Target IKU:</label>                                    
                                        <input type="text" id="target-iku" name="target_iku" class="form-control input-sm" value="<?= '' ?>">
                                </div>
                                <div class="form-group">
                                    <label class="control-label lbl-color" >Keterangan:</label>
                                    <textarea id="keterangan" name="keterangan" class="form-control input-sm"></textarea>                                        
                                </div>
                            </div>
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn  btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn  btn-primary" id="btn-save">Save changes</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>    

