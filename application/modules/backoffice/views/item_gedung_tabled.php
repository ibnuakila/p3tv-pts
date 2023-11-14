<?php
if (isset($item_gedung)) {
    //echo $item_gedung->num_rows();
    if ($item_gedung->num_rows() > 0) {
        ?>

        <?php
        $i = 1;
        $arr_group = array('1', '4', '7', '10', '13', '16', '19', '22', '25', '28', '31');
        foreach ($item_gedung->result() as $item) {
            /*if (in_array($i, $arr_group)) {
                echo '<div class="row mt-2">';
                echo '<div class="card-deck">';
            }*/
            ?>
            <div class="row mt-2">
            <div class="card" style="width:auto;">
                <div class="row no-gutters">
                    <div class="col-md-3">
                        <img src="<?= base_url() ?>assets/images/no-image.jpg" class="card-img-top" alt="...">
                    </div>
                    <div class="col-md-9">
                        <div class="card-body">
                            <h5 class="card-title"><?= $item->kd_gedung ?></h5>
                            <h6><?= $item->nm_gedung ?></h6>
                            
                            <button href="" class="btn btn-outline-dark detail-barang" data-toggle="modal" 
                                    data-target="#modal-gedung" id="<?= $item->kd_gedung ?>">Detail</button>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <?php
            /*$arr_close_tag = array('3', '6', '9', '12', '15', '18', '21', '24', '27', '30');
            if (in_array($i, $arr_close_tag)) {
                echo '</div>';
                echo '</div>';
            } elseif ($i == $item_barang->num_rows()) {
                echo '</div>';
                echo '</div>';
            }*/
            $i++;
        }
        ?>

    <?php }
    ?>
    <div class="row mt-5">
        <?php
        if ($paging == 'true') {
            echo $this->pagination->create_links();
        }
        ?>
    </p>
    <?php
}
?>



<!-- Modal -->
<div class="modal fade" id="modal-gedung" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Gedung</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <img src="<?= base_url() ?>assets/images/no-image.jpg" class="card-img" alt="..." id="img-barang">
                </div>
                <div class="col-md-12">
                    <div class="card-body">
                        <h4 class="card-title" id="title-barang">Card title</h4><hr>
                                                
                            <div class="form-group text-right">
                                <label class="text-right"><b>Jumlah Kelas/Gedung:</b></label>
                                <input type="text" class="form-control-sm" name="txt-qty" id="txt-qty" style="width:50px;" value="0">
                                
                            </div>
                            <div class="form-group text-right">
                                <label class="text-right"><b>Besaran Biaya:</b></label>
                                <input type="text" class="form-control-sm" name="txt-biaya" id="txt-biaya" style="width:150px;" value="0">
                                <input type="hidden" id="id-item" value="">
                            </div>
                        
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline-primary" id="btn-save-gedung">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$("document").ready(function () {
    $(document.body).on("click", ".detail-barang", function ()
        {
            var idItem = $(this).attr('id');
            //alert("id item" + idItem);
            $.ajax({
                url: '<?php echo base_url() . 'backoffice/kelolabarang/getgedung/'; ?>',
                dataType: 'json',
                type: 'POST',
                data: {id_item: idItem},
                success: function (response) {
                    
                    $("#title-barang").text(response[0].kd_gedung + " (" + response[0].nm_gedung + ")");
                    $("#img-barang").attr("src", response[0].image);
                    //$("#lbl-harga").text("Rp. " + response[0].harga);
                    //$("#text-spesifikasi").text(response[0].spesifikasi);
                    $("#id-item").val(response[0].kd_gedung);
                }
            });
        });
});
</script>