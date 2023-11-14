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
                        if($result->num_rows()>0){
                            $no = 1;
                            
                            foreach ($result->result() as $row) {
                                $params = ['id_item' => $row->id_item, 'periode' => $periode[0]];
                                $item_barang = new ItemBarang($params);
                            
                    ?>
                    <tr>
                        <td><?= $no?></td>
                        <td><?= $item_barang->getBarang()?></td>
                        <td><?= $row->no_kontrak?></td>
                        <td><?= $row->volume?></td>
                        <td><?= $row->volume_terkirim?></td>
                        <td><?= $row->receive_date?></td>
                        <td>
                            <?php if($row->receive_date != ''){ ?>
                            <a href="<?= base_url() . 'backoffice/kelolapaket/detailterima/' . $row->id_terima ?>" title="Detail">
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