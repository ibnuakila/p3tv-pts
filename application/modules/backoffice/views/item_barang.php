<?php
if (isset($item_barang)) {
    if ($item_barang->num_rows() > 0) {
        ?>

        <?php
        $i = 1;
        $arr_group = array('1', '4', '7', '10', '13', '16', '19', '22', '25', '28', '31');
        foreach ($item_barang->result() as $item) {
            if (in_array($i, $arr_group)) {
                echo '<div class="row mt-2">';
                echo '<div class="card-deck">';
            }
            ?>
            <div class="card">
                <img src="<?= base_url() ?>assets/images/no-image-2.png" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?= $item->barang . ' (' . $item->no_barang . ')' ?></h5>
                    <h6>Rp. <?= number_format($item->harga, 2) ?></h6>
                    <p class="card-text text-muted text-monospace text-justify"><?= substr($item->spesifikasi, 0, 100) ?>...</p>
                    <button href="" class="btn btn-outline-dark detail-barang" data-toggle="modal" 
                            data-target="#modal-detail" id="<?= $item->id_item ?>">Detail</button>
                </div>
            </div>
            <?php
            $arr_close_tag = array('3', '6', '9', '12', '15', '18', '21', '24', '27', '30');
            if (in_array($i, $arr_close_tag)) {
                echo '</div>';
                echo '</div>';
            } elseif ($i == $item_barang->num_rows()) {
                echo '</div>';
                echo '</div>';
            }
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
                                    <input type="hidden" id="id-item" value="">
                                </div>
                           
                        <h5>Spesifikasi:</h5>
                        <p class="card-text text-monospace text-muted text-justify" id="text-spesifikasi">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline-primary" id="btn-save">Save changes</button>
            </div>
        </div>
    </div>
</div>

