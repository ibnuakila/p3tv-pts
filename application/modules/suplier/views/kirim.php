<script type="text/javascript">
    $("document").ready(function() {

        $("#tglkirim").datepicker({
            dateFormat: "yy-mm-dd",
            changeYear: true
        });
        $(document.body).on("keyup", ".ganti", function()
        {
            var vol = $(this).attr('id');
            var volo = $("#" + vol).val();
            var volkirim = $("#" + vol + "a").val();
            //alert(volo);
            if ((volo * 1) > (volkirim * 1)) {
                alert("Jumlah kirim tidak boleh lebih besar dari volume");
            }
        });
    });


</script>

<?php echo form_open_multipart('suplier/suplier/simpankirim/'); ?>	
<div class="panel panel-success">
    <div class="panel-heading"><b><?=$title?></b></div>
    <div class="panel-body">

        <table class="table table-striped table-condensed table-hover"  >
            <tr class="alt">
                <td width="200" >Kode PT </td>
                <td width="10" >:</td>
                <td><?php echo $pt->kdpti; ?></td>                        
            </tr>
            <tr class="alt">
                <td >Nama PT </td>
                <td >:</td>
                <td><?php echo $pt->nmpti; ?></td>                        
            </tr>
            <tr class="alt">
                <td width="200" >Alamat </td>
                <td width="10" >:</td>
                <td> <?php echo $pt->alamat; ?></td>                                               
            </tr>
            <tr class="alt">
                <td >Kota </td>
                <td >:</td>
                <td><?php echo $pt->kota; ?></td>                                               
            </tr>
            <tr class="alt">
                <td >Nama Ekspedisi </td>
                <td >:</td>
                <td><input class="form-control" type="text" id="ekspedisi" name="ekspedisi"  placeholder="Nama Ekspedisi ..." width="20px"/></td>                        
            </tr>
            <tr class="alt">
                <td >Nomer Resi </td>
                <td >:</td>
                <td><input class="form-control" type="text" id="resi" name="resi"  placeholder="Nomer Resi ..." width="20px"/></td>                        
            </tr>
            <tr class="alt">
                <td >Tanggal Kirim </td>
                <td >:</td>
                <td><input class="form-control" type="text" id="tglkirim" name="tglkirim" class="form-control input-sm" value="<?php echo date('Y-m-d'); ?>">  </td>                        
            </tr>
            <tr class="alt">
                <td >Bukti Kirim </td>
                <td >:</td>
                <td>  <input type="file" class="btn btn-file" name="filebukti" id="filebukti"/>  </td>                        
            </tr>  



        </table>
        <td><input  type="hidden" id="kdpti" name="kdpti"  value="<?php echo $pt->kdpti; ?>">  </td>                         

        <table class="table table-striped table-condensed table-hover"  >
            <tr class="active text-info">                     
                <th width=40% class="text-center">Barang</th> 
                <th width=40% class="text-center">Merk</th> 
                <th width=5% class="text-center">Volume</th>
                <th width=5% class="text-center">Jumlah Kirim</th>
                <th width=10% class="text-center">Aksi</th>

            </tr>

            <?php
            foreach ($barang as $obj) {
                ?>
                <tr>
                    <td class="text-center"><?= $obj->barang ?></td>
                    <td class="text-center"><?= $obj->merk ?></td>
                    <td class="text-center"><input type="text"  disabled="disabled" id="<?=$obj->id.'a'?>" name="<?=$obj->id.'a'?>"  style="width: 4em;"  class="form-control input-sm ganti" value="<?php if (isset($obj->volume)) {
                echo $obj->volume;
            } ?>"></td>
                    <td class="text-center"><input type="text"  id="<?=$obj->id?>" name="<?=$obj->id?>"  style="width: 4em;"  class="form-control input-sm ganti" value="<?php if (isset($obj->volume)) {
                echo $obj->volume;
            } ?>"></td>
                    <td class="text-center"><input type="checkbox" name="check_list[]" value="<?=$obj->id?>" />
                    </td>  



                </tr>

    <?php }
?> 






        </table>    



        <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
                <button type="submit" name="save" value="save" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-floppy-disk"></i> Kirim</button>

            </div>
        </div>           

    </div>

</div>

<?php
// echo $prodi;
echo form_close();
?>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
