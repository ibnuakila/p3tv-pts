
<script type="text/javascript">
    $("document").ready(function () {

        
    });
</script>
<div class="col-sm-12">
    <div class="card">
        <div class="card-header"><i class="glyphicon glyphicon-list"></i> Detail Terima Barang</div>
        <div class="card-body">				
            <form action="" class="form-horizontal">
                <?php
                
                $pt = new Pti($kirim->getKdPti());
                                
                ?>
                <div class="form-group">
                    <label for="pt" class="col-lg-3 control-label">Perguruan Tinggi:</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control input-sm" value="<?= $pt->getNmPti(); ?>">                                        
                    </div>
                </div>
                <div class="form-group">
                    <label for="yayasan" class="col-lg-3 control-label">Alamat:</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control input-sm" value="<?= $kirim->getAlamat() ?>">                                        
                    </div>
                </div>
                <div class="form-group">
                    <label for="yayasan" class="col-lg-3 control-label">Kota:</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control input-sm" value="<?= $kirim->getKota() ?>">                                        
                    </div>
                </div>
                <div class="form-group">
                    <label for="pt" class="col-lg-3 control-label">Tgl Terima:</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control input-sm" value="<?= $terima_barang->getReceiveDate(); ?>">                                        
                    </div>
                </div>
                <div class="form-group">
                    <label for="pt" class="col-lg-3 control-label">Kesesuaian:</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control input-sm" name="status" id="status" 
                               value="<?php if($terima_barang->getCekSesuai()==1){ echo 'Sesuai';}else{ echo 'Tidak Sesuai';} ?>">                                                               
                    </div>
                </div>
                <div class="form-group">
                    <label for="pt" class="col-lg-3 control-label">Kondisi:</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control input-sm" name="status" id="status" 
                               value="<?php if($terima_barang->getCekKondisi()==1){ echo 'Baik';}else{ echo 'Tidak Baik';} ?>">                                                               
                    </div>
                </div>
                <div class="form-group">
                    <label for="pt" class="col-lg-3 control-label">Keterangan:</label>
                    <div class="col-lg-6">
                        <textarea class="form-control"><?=$terima_barang->getKetKondisi() ;?></textarea>
                        
                    </div>
                </div>
                <div class="form-group">
                    <label for="pt" class="col-lg-3 control-label">Garansi:</label>
                    <div class="col-lg-6">
                        <input type="text" class="form-control input-sm" name="status" id="status" 
                               value="<?php if($terima_barang->getCekGaransi()==1){ echo 'Ada';}else{ echo 'Tidak Ada';} ?>">                                                               
                    </div>
                </div>
                <div class="form-group">
                    <label for="pt" class="col-lg-3 control-label">Bukti Terima:</label>
                    <div class="col-lg-6">                        
                        <?php 
                            if($terima_barang->getFileTerima() != ''){ ?>
                            <a href="<?=base_url().'/backoffice/kelolapaket/getbuktiterima/'.$terima_barang->getIdTerima() ?>" class="btn btn-primary btn-sm">Unduh<a>
                            <?php }else{ ?>
                            <label class="badge badge-warning">Tidak Tersedia</label>
                            <?php } ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="pt" class="col-lg-3 control-label">Foto Terima:</label>
                    <div class="col-lg-6">
                        <?php 
                            if($terima_barang->getFotoBarang() != ''){ ?>
                                <a href="<?=base_url().'/backoffice/kelolapaket/getfotobarang/'.$terima_barang->getIdTerima() ?>" class="btn btn-primary btn-sm">Unduh<a>
                            
                            <?php }else{ ?>
                            <label class="badge badge-warning">Tidak Tersedia</label>
                            <?php } ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
		
