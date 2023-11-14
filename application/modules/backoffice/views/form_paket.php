
<script type="text/javascript">
    

</script>
<div class="col-sm-12">
<div class="card">
    <div class="card-header">
        <h5>Tambah Paket Barang</h5>
        
    </div>

    <ul class="nav nav-tabs" role="tablist" id="myTab">

        <li class="nav-item">
            <a href="#paket" class="nav-link active" aria-controls="paket" role="tab" data-toggle="tab">Data Paket</a>
        </li>

        <li class="nav-item">
            <a href="#detail_paket" class="nav-link" aria-controls="detail_paket" role="tab" data-toggle="tab">Detail Paket</a>
        </li>        

    </ul>

    <div class="tab-content">
        <div id="paket" role="tabpanel" class="tab-pane active">

            <div class="card-body" >
                <?php if (validation_errors() != '') { ?>                    
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <strong><?php echo validation_errors(); ?></strong>
                    </div>
                <?php } ?>                    
                <div class="">
                    <form class="form-horizontal" id="form_paket" method="post" action="<?= base_url() . 'backoffice/kelolapaket/save/' ?>">
                        <div class="form-group">
                            <label class="col-lg-3 control-label lbl-color" >ID Paket:</label>

                            <div class="col-lg-8">
                                <input type="text" id="id_paket" name="id_paket" class="form-control input-sm" value="<?php if(isset($paket)){echo $paket->getId();} ?>" disabled="disabled">
                                
                            </div>
                        </div>
						
						<div class="form-group">
                            <label class="col-lg-3 control-label lbl-color" >Nama Paket:</label>

                            <div class="col-lg-8">
                                <input type="text" id="nama_paket" name="nama_paket" class="form-control input-sm" value="<?php if(isset($paket)){echo $paket->getNamaPaket();} ?>">
                                <input type="hidden" id="flaginsert" name="flaginsert" value="<?php if(isset($flagInsert)){echo $flagInsert;}else{ echo '0';} ?>">
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label lbl-color" >Supplier:</label>
                            <div class="col-lg-8">
                                <?php if(isset($paket)){$supplier = $paket->getSupplier();}?>
                                <input type="text" id="supplier" name="supplier" class="form-control input-sm" value="<?php if(isset($supplier)){echo $supplier->getNamaSupplier();} ?>">
                                <input type="hidden" id="id_supplier" name="id_supplier" value="<?php if(isset($supplier)){echo $supplier->getId();} ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label lbl-color" >No Kontrak:</label>
                            <div class="col-lg-8">
                                <input type="text" id="no_kontrak" name="no_kontrak" class="form-control input-sm" value="<?php if(isset($paket)){echo $paket->getNoKontrak();} ?>">                      
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label lbl-color" >Tgl Kontrak:</label>
                            <div class="col-lg-8">
                                <input type="text" id="tgl_kontrak" name="tgl_kontrak" class="form-control input-sm" value="<?php if(isset($paket)){echo $paket->getTglKontrak();} ?>">

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label lbl-color" >Tgl Akhir Kontrak:</label>
                            <div class="col-lg-8">
                                <input type="text" id="tgl_akhir_kontrak" name="tgl_akhir_kontrak" class="form-control input-sm" value="<?php if(isset($paket)){echo $paket->getTglAkhirKontrak();} ?>">

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label lbl-color" >Adendum:</label>                    
                            <div class="col-lg-8">
                                <?php
                                $opt_adendum = array('-' => '-Pilih-', 'Yes' => 'Yes', 'No' => 'No');
                                $sel_adendum = '-';
                                if(isset($paket)){$sel_adendum = $paket->getAdendum();}
                                echo form_dropdown('adendum', $opt_adendum, $sel_adendum, 'class="form-control" id="adendum"');
                                ?>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label lbl-color" >Bukti Kontrak:</label>                    
                            <div class="col-lg-8">
                                <?php   if(isset($paket)){?>
                                
                                <input type="file" id="kontrakfile" name="kontrakfile" class="form-control"  value="<?=$paket->getFileBuktiKontrak() ?>"> 
                                <?php   }else{ ?>
                                <input type="file" id="kontrakfile" name="kontrakfile" class="form-control"  value="">                                       
                                <?php   } ?>
                            </div>
                        </div>
                        <div class="modal-footer">
                        <div class="form-group">
                            <div class="">
                                <a href="#" id="save_paket" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-floppy-disk"></i> Save</a>
                                <button type="submit" id="cancel_paket" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-ok"></i> OK</button>
                            </div>
                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div id="detail_paket" role="tabpanel" class="tab-pane">
            <div class="card-body">
                <form action="<?= base_url() . 'backoffice/kelolapaket/savedetail/' ?>" id="form_detail" enctype="multipart/form-data">
                    
                    <div class="">
                        <div class="form-horizontal" >
                            <div class="form-group">
                                <label class="col-lg-3 control-label lbl-color" >Adendum Ke:</label>
                                <div class="col-lg-8">
                                    <input type="text" id="kontrak_adendum" name="kontrak_adendum" class="form-control input-sm" 
                                           value="">

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label col-md-1" for="instansi">File:</label>
                                
                                    <input type="hidden" id="flag_detail" name="flag_detail" value="<?=$flagInsert ?>">
                                    <input type="hidden" id="id_detail_paket" name="id_detail_paket" value="0">
                                    <input type="hidden" id="id_registrasi" name="id_registrasi" value="">
                                    
                                    <div class="col-lg-8">
                                        <input type="file" id="userfiledetail" name="userfiledetail" class="form-control input-sm">

                                    </div>
                                    
                                
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label" for="instansi"></label>
                                <div class="col-lg-8">
                                    <a href="#" id="upload_detail" class="btn btn-primary btn-sm">
                                        <i class="glyphicon glyphicon-upload"></i> Add</a>                      
                                </div>
                            </div>
                        
                    </div>
                    <div class="modal-footer">
                        
                    </div>
                    </div>
                </form>

                <div class="form-group">

                </div>
                <table class="table table-striped table-responsive" id="tbl_detail">
                    <thead class="tbl-head">
                        <tr class="bg-success" >
                            <th class="text-center">No</th> 
                            <th class="text-center">No Kontrak</th>
                            <th class="text-center">Adendum Ke</th>
                            <th class="text-center">ID Registrasi</th> 
                            <th class="text-center">Nama PT</th> 
                            <th class="text-center">Nama Barang</th>                 
                            <th class="text-center">Merk</th>
                            <th class="text-center">Type</th>                
                            <th class="text-center">Volume</th>
                            <!--<th class="text-center">Biaya Kirim</th>-->
                            <th class="text-center">Harga</th>
                            <th class="text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(isset($detail_paket) && $detail_paket->num_rows()>0){
                                $i=1;
                                foreach ($detail_paket->result() as $row){
                        ?>
                        <tr>
                            <td><?= $i;?></td>
                            <td><?= $row->no_kontrak;?></td>
                            <td><?= $row->adendum_ke;?></td>
                            <td><?= $row->id_registrasi; ?></td>
                            <?php
                                $registrasi = new Registrasi($row->id_registrasi);
                                $pti = $registrasi->getPti();
                                $params = array('id_item' => $row->id_item, 
                                    'periode' => $registrasi->getPeriode());
                                $barang = new ItemBarang($params);
                            ?>
                            <td><?= $pti->getNmPti(); ?></td>
                            <td><?= $barang->getBarang(); ?></td>
                            <td><?= $row->merk; ?></td>
                            <td><?= $row->type; ?></td>
                            <td><?= $row->volume; ?></td>
                            <!--<td><?= $row->biaya_kirim; ?></td>-->
                            <td><?= $row->hps; ?></td>
                            <td><?= $row->total; ?></td>
                            
                        </tr>
                                <?php   $i++;
                                }
                            }
                        ?>
                    </tbody>				
                </table>
            </div>

        </div>
    </div><!-- end tab-content -->
</div>    
</div>
<?php
//include 'form_hibah.php';
?>