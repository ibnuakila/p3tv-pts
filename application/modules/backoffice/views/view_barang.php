
<div class="md-card"><i class="glyphicon glyphicon-tag"></i>
    <h2>Data Barang 

    </h2>

    <?php
    if (isset($registrasi)) {

        $pt = $registrasi->getPti();
        //print_r($reg);
        //$account = $reg->getAccount();
        $yayasan = $registrasi->getPenyelenggara();
        //$evaluasi = $pro->getEvaluasi();
        $nmyayasan = '-';
        if (is_object($yayasan)) {
            $nmyayasan = $yayasan->getNamaPenyelenggara();
        }
    }
    ?>
    <h4>
        <?php
        $id_reg = '';
        if (isset($registrasi)) {
            echo $nmyayasan . '</br>';
            echo $pt->getNmPti() . '</br>';
            $id_reg = $registrasi->getIdRegistrasi();
        }
        ?>
    </h4>
    
    <div class="card">
        <div class="card-header"><i class="fa fa-tag"></i></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-condensed" >
                    <thead class="tbl-head">

                        <tr>
                            <th>Id Item</th>					
                            <th>Jumlah</th>
                            <th>Nama Barang</th>
                            <th>Spesifikasi</th>
                            <th>Lampiran</th>
                            <th>Harga satuan</th>
                            <th>Ongkir</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $hibah = new ItemHibah();
                        $hibah->setPeriode($registrasi->getPeriode());
                        $item_hibah = $hibah->getByRelated('registrasi', 'id_registrasi', $registrasi->getIdRegistrasi(), '0', '0');
                        if (($item_hibah->num_rows()) > 0) {
                            $grand_total = 0;
                            foreach ($item_hibah->result() as $row) {
                                $barang = new Barang($row->id_item);
                                $nmbarang = $barang->getNmBarang();
                                $spesifikasi = $barang->getSpesifikasi();
                                $gedung = null;
                                if ($barang->getKdBarang() == '') {
                                    $gedung = new Gedung($row->id_item);
                                    $nmbarang = $gedung->getNmGedung();
                                    $spesifikasi = '';
                                }
                                $grand_total = $grand_total + $row->subtotal;
                                ?>
                                <tr>
                                    <td><?php echo $row->id_item ?></td>
                                    <td><?php echo $row->jml_item ?></td>
                                    <td><?php echo $nmbarang ?></td>        		
                                    <td><?php echo $spesifikasi ?></td>

                                    <td><?php if ($gedung != null) { ?>
                                            <a href="<?= base_url() . $row->file_rab ?>" title="View">
                                                <i class="glyphicon glyphicon-file"></i> </a>
                                            <a href="<?= base_url() . $row->file_design ?>" title="View">
                                                <i class="glyphicon glyphicon-picture"></i> </a>
                                            <?php } ?>
                                    </td>
                                    <td><?php echo number_format($row->hrg_satuan, 2) ?></td>
                                    <td><?php echo number_format($row->ongkir_satuan, 2) ?></td>
                                    <td><?php echo number_format($row->subtotal, 2) ?></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="7">Grand Total</td>
                                <td><?= number_format($grand_total, 2) ?></td>
                            </tr>
                            <tr>
                                <td colspan="7">PPN 10%</td>
                                <td><?php
                                    $ppn = ($grand_total * 10) / 100;
                                    echo number_format($ppn, 2)
                                    ?></td>
                            </tr>
                            <tr>
                                <td colspan="7">Total</td>
                                <td><strong><?php
                                        $total = $grand_total + $ppn;
                                        echo number_format($total, 2)
                                        ?></strong></td>
                            </tr>
                            <tr>
                                <td colspan="7">
                                    <a href="<?= base_url() . 'backoffice/kelolaevaluasi/printdatabarang/' . $id_reg ?>" title="Print"
                                       class="btn btn-primary">
                                        <i class="fa fa-print"></i></a>
                                </td>
                                <td></td>
                            </tr>
<?php } ?>                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>