
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
<div class="">

    <div class="card"><i class="fa fa-tag"></i>
        <h2 class="">
            Detail Paket Barang
        </h2>



        <div class="row-fluid">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-responsive" id="tbl_detail">
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
                            <th class="text-center">Harga Total</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($detail_paket) && $detail_paket->num_rows() > 0) {
                            $no_kontrak = $paket->getNoKontrak();
                            $i = 1;
                            foreach ($detail_paket->result() as $row) {
                                ?>
                                <tr class="<?php
                                if ($no_kontrak == $row->no_kontrak) {
                                    echo 'active';
                                }
                                ?>">
                                    <td><?= $i; ?></td>
                                    <td><?= $row->no_kontrak; ?></td>
                                    <td><?= $row->adendum_ke; ?></td>
                                    <td><?= $row->id_registrasi; ?></td>
                                    <?php
                                    $registrasi = new Registrasi($row->id_registrasi);
                                    $pti = $registrasi->getPti();
                                    $barang = new Barang($row->id_item);
                                    ?>
                                    <td><?= $pti->getNmPti(); ?></td>
                                    <td><?= $barang->getNmBarang(); ?></td>
                                    <td><?= $row->merk; ?></td>
                                    <td><?= $row->type; ?></td>
                                    <td><?= $row->volume; ?></td>
                                    <!--<td><?= $row->biaya_kirim; ?></td>-->
                                    <td><?= $row->hps; ?></td>
                                    <td><?php if ($row->status == 0 || $row->status == '') { ?>
                                            <a href=""><label class="badge badge-default">Packing</label></a>
                                        <?php } elseif ($row->status == 1) { ?>
                                            <a href=""><label class="badge badge-info">Terkirim Sebagian</label></a>
                                        <?php } elseif ($row->status == 2) { ?>
                                            <a href=""><label class="badge badge-primary">Terkirim</label></a>
                                        <?php } elseif ($row->status == 3) { ?>
                                            <a href=""><label class="badge badge-warning">Diterima Sebagian</label></a>
                                        <?php } elseif ($row->status == 4) { ?>
                                            <a href=""><label class="badge badge-success">Diterima</label></a>
                                        <?php } else { ?>
                                            <a href=""><label class="badge badge-dark">Selesai</label></a>
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
                //echo $this->pagination->create_links(); 
                //echo $articles->count();
                ?>
            </div>

        </div>
    </div>
</div>