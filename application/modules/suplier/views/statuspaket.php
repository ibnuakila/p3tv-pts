


<div class="panel panel-success">
    <div class="panel-heading"><b><?=$title?></b></div>
    <div class="panel-body">

        <table class="table table-striped table-condensed table-hover"  >
           
            <tr class="alt">
                <td >Nama PT </td>
                <td >:</td>
                <td><?php echo $pt->nmpti; ?></td>                        
            </tr>
           
            <tr class="alt">
                <td >Nama Suplier </td>
                <td >:</td>
                <td><?php echo $pt->nama_supplier; ?></td>                                               
            </tr>
            


        </table>
        <br>
        <br>

        <table class="table table-striped table-condensed table-hover"  >
            <tr class="active text-info">                     
                <th width=20% class="text-center">Barang</th> 
                <th width=30% class="text-center">Spesifikasi</th> 
                <th width=6% class="text-center">Volume</th>
                <th width=6% class="text-center">Volume Terkirim</th>
                <th width=20% class="text-center">No Resi</th>
                <th width=8% class="text-center">Tanggal Kirim</th>
                <th width=10% class="text-center">Aksi</th>

            </tr>

            <?php
            // a.type, a.spesifikasi, a.volume, jumlah,  c.no_resi,c.tgl_kirim,c.file_bukti_kirim  
            foreach ($barang as $obj) {
                ?>
                <tr>
                    <td class="text-center"><?= $obj->type ?></td>
                    <td class="text-center"><?= $obj->spesifikasi ?></td>
                    <td class="text-center"><?php if (isset($obj->volume)) {
                echo $obj->volume;
            } ?></td>
                    <td class="text-center"><?php if (isset($obj->jumlah)) {
                echo $obj->jumlah;
            } ?></td>
                    <td class="text-center"> <?php if (isset($obj->no_resi)) {
                echo $obj->no_resi;
            } ?></td> 
                    <td class="text-center"> <?php if (isset($obj->tgl_kirim)) {
                echo $obj->tgl_kirim;
            } ?></td> 
                    <td class="text-center"> <?php if (isset($obj->id)) {
                      ?> <a href="<?= base_url().'suplier/suplier/download1/'.$obj->id ?>">
                 Bukti Kirim </a>
                    <?php } ?> </td> 



                </tr>

    <?php }
?> 






        </table>    



               

    </div>

</div>


