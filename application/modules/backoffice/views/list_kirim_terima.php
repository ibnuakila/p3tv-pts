<div class="col-md-12">
<div class="card">
    <div class="card-header"><h3>Data Pengiriman dan Penerimaan</h3></div>
    <div class="card-body">
        <?php
            $pt = $registrasi->getPti();
            $penyelenggara = $registrasi->getPenyelenggara();
        ?>
        <div class="form-group">
            <label for="pt" class="col-lg-3 control-label">Badan Penyelenggara:</label>
            <div class="col-md-6">
                <input type="text" class="form-control input-sm" disabled name="pt" value="<?= $penyelenggara->getNamaPenyelenggara(); ?>">                                        
            </div>
        </div>
        <div class="form-group">
            <label for="pt" class="col-lg-3 control-label">Perguruan Tinggi:</label>
            <div class="col-md-6">
                <input type="text" class="form-control input-sm" disabled name="pt" value="<?= $pt->getNmPti(); ?>">                                        
            </div>
        </div>
        <div class="form-group">
            <label for="pt" class="col-lg-3 control-label">Alamat PT:</label>
            <div class="col-md-6">
                <input type="text" class="form-control input-sm" disabled name="pt" value="<?= $pt->getAlamat(); ?>">                                        
            </div>
        </div>
        <div class="form-group">
            <label for="pt" class="col-lg-3 control-label">Kota:</label>
            <div class="col-md-6">
                <input type="text" class="form-control input-sm" disabled name="pt" value="<?= $pt->getKota(); ?>">                                        
            </div>
        </div>
        <div class="form-group">
            <label for="pt" class="col-lg-3 control-label">Laporan BAP Monev:</label>
            <div class="col-md-6">
                <a href="<?= base_url().'backoffice/kelolapaket/getbapmonev/'.$registrasi->getIdRegistrasi()?>" class="btn btn-primary btn-sm">Unduh</a>                                       
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-condensed table-striped table-bordered">
                <thead>
                <th>No</th>
                <th>Nama Barang</th>
                <th>No Kontrak</th>
                <th>Volume</th>
                <th>Terkirim</th>
                <th>Diterima</th>
                <th>Action</th>
                </thead>
                <tbody>
                    <?php
                        if($terima_barang->num_rows()>0){
                            $no = 1;
                            //print_r($result);
                            foreach ($terima_barang->result() as $row_item) {
                                $params = ['id_item' => $row_item->id_item, 'periode' => $registrasi->getPeriode()];
                                $item_barang = new ItemBarang($params);
                            
                    ?>
                    <tr>
                        <td><?= $no?></td>
                        <td><?= $item_barang->getBarang()?></td>
                        <td><?= $row_item->no_kontrak?></td>
                        <td><?= $row_item->volume?></td>
                        <td><?= $row_item->volume_terkirim?></td>
                        <td><?= $row_item->receive_date?></td>
                        <td>
                            <?php if($row_item->receive_date != ''){ ?>
                            <a href="<?= base_url() . 'backoffice/kelolapaket/detailterima/' . $row_item->id_terima ?>" title="Detail">
                                <i class="fa fa-list"></i>
                            <a/>
                            <?php } ?>
                        </td>
                    </tr>
                        <?php 
                        $no++;
                            }
                        }?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>