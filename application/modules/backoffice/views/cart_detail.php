<div class="card mb-3">
    <div class="card-header"><i class="fa fa-shopping-cart"></i> Data Barang</div>
    <div class="card-body">
    <?php
    $registrasi = new Registrasi($id_registrasi);
    $pt = $registrasi->getPti();
    //print_r($item_hibah->num_rows());
    ?>
    <h3 class="display-5">
        Usulan Barang <?= $pt->getNmPti() ?>
    </h3><hr>
    <input type="hidden" id="base_url" value="<?= base_url() ?>">
    <input type="hidden" id="id_registrasi" value="<?=$id_registrasi?>">
    <div class="table-responsive">
        <table class="mytable table-striped table-condensed">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Spesifikasi</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Sub Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if($item_hibah->num_rows()>0){
                    $i=1; $grand_total=0; $nama = ''; $spesifikasi = ''; $ppn = 0; $harga=0;
                    foreach ($item_hibah->result() as $row){
                        $params['id_item'] = $row->id_item;
                        $params['periode'] = $periode;
                        if($registrasi->getJnsUsulan()=='01'){//barang                            
                            $item_barang = new ItemBarang($params);
                            $nama = $item_barang->getBarang();
                            $spesifikasi = $item_barang->getSpesifikasi();
                            //$ppn = ($row->subtotal*10)/100;
                            $harga = $item_barang->getHarga();
                        }elseif ($registrasi->getJnsUsulan()=='02') {                            
                            $item_barang = new ItemGedung($row->id_item);
                            $nama = $item_barang->getNmGedung();
                            $spesifikasi = $item_barang->getNmGedung();
                            //$ppn = 0;
                        }else{
                            if(strlen($row->id_item)==9 ){
                                $item_barang = new ItemBarang($params);
                                $nama = $item_barang->getBarang();
                                $spesifikasi = $item_barang->getSpesifikasi();
                                //$ppn = ($row->subtotal*10)/100;
                            }else{
                                $item_barang = new ItemGedung($row->id_item);
                                $nama = $item_barang->getNmGedung();
                                $spesifikasi = $item_barang->getNmGedung();
                                //$ppn = 0;
                            }
                        }
                        
                        $subtotal_ppn = $row->subtotal ;//+ $ppn;
                        $grand_total = $grand_total + $subtotal_ppn;
                ?>
                <tr>
                    <td><?=$i ?></td>
                    <td><?=$nama ?></td>
                    <td><?=$spesifikasi ?></td>
                    <td><?=number_format($harga,2)?></td>
                    <td><?=$row->jml_item ?></td>
                    <td><?=number_format($subtotal_ppn,2) ?></td>
                    <td>
                        <a href="#" title="Edit" class="edit" data-toggle="modal" 
                            data-target="#modal-detail" id="<?= $row->id ?>"><i class="fa fa-edit"></i></a>
                        <a href="#" title="Remove" class="remove" id="<?=$row->id ?>"><i class="fa fa-times"></i></a>
                    </td>
                </tr>
                <?php $i++;
                    }?>
                <tr>
                    <td colspan="4"><b>Grand Total (Sudah Termasuk Pajak):</b></td>
                    <td colspan="2"><b><?='Rp. '.number_format($grand_total,2) ?></b></td>
                    
                </tr>
                <?php
                }else{
                    echo '<tr><td colspan="6">Tidak ada Item Barang!</td></tr>';
                }
                ?>
            </tbody>
        </table>
        <?php
        $rekapitulasi = new Rekapitulasi();
        $rekapitulasi->getBy('id_registrasi', $id_registrasi);
        $proses = new Proses();
        $proses->getByRelated('registrasi', 'id_registrasi', $id_registrasi);
        //if($proses->getIdJnsEvaluasi() == '2'){
            if($rekapitulasi->getIdStatusRegistrasi()!='7'){
        ?>
            <!--<button id="btn-selesai" class="btn btn-outline-primary">Selesai</button>-->
            <?php } 
        //}?>
        <a href="<?= base_url().'backoffice/kelolabarang/printdatabarang/'.$id_registrasi ?>" class="btn btn-outline-success">Cetak</a>
    </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <img src="<?= base_url() ?>assets/images/no-image-2.png" class="card-img" alt="..." id="img-barang">
                </div>
                <div class="col-md-12">
                    <div class="card-body">
                        <h4 class="card-title" id="title-barang">Card title</h4><hr>
                        <h5 id="lbl-harga" class="text-right">Rp.</h5>
                        
                                <div class="form-group text-right">
                                    <label class="text-right"><b>Qty:</b></label>
                                    <input type="text" class="form-control-sm" name="txt-qty" id="txt-qty" style="width:50px;" value="0">
                                    <input type="hidden" id="id" value="">
                                    <input type="hidden" id="id-item" value="">
                                    <input type="hidden" id="id-registrasi" value="">
                                </div>
                                <h5 id="lbl-sub-total" class="text-right">Rp.</h5>
                        <h5>Spesifikasi:</h5>
                        <p class="card-text text-monospace text-muted text-justify" id="text-spesifikasi">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="flag" value="false">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal" id="btn-close">Close</button>
                <button type="button" class="btn btn-outline-primary" id="btn-save">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" >
    
</script>
