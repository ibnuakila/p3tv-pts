<div class="mt-auto mb-1">
    <?php
    $registrasi = new Registrasi($id_registrasi);
    $pt = $registrasi->getPti();
    ?>
    <h3 class="display-5">
        Data Barang <?= $pt->getNmPti() ?>
    </h3><hr>
    <div class="card">
        <div class="card card-header">Filter</div>
        <div class="card-body">
            <div class="col-lg-12 col-sm-12">
                <form id="filter" class="form-inline">
                    <div><input type="hidden" id="url" value="<?= base_url()?>"></div>
                    <div class="form-group">
                        <label class="p-2">Kategori:</label>
                        <?= form_dropdown('kategori', $opt_kategori, '', 'id="kategori" class="form-control-sm"') ?>
                    </div>
                    <div class="form-group">
                        <label class="p-2">Sub Kategori:</label>
                        <?= form_dropdown('sub_kategori', array('-' => '~Pilih Kategori Dahulu~'), '', 'id="sub-kategori" class="form-control-sm"') ?>
                    </div>
                    <div class="form-group">
                        <label class="p-2">Cari:</label>
                        <input type="text" class="form-control-sm" id="txt-keyword">
                    </div>
                </form>
            </div>
            <div class="col-lg-12 col-sm-12">
                <h5 class="p-2" id="lbl-total">
                    <?php
                    if (isset($grand_total)) {
                        echo 'Total: Rp. ' . number_format($grand_total, 2);
                    } else {
                        echo 'Total: 0';
                    }
                    ?>
                </h5>
                <input type="hidden" id="id-registrasi" value="<?= $id_registrasi ?>">
                <input type="hidden" id="flag" value="true">
                <a class="btn btn-outline-danger ml-2" id="cart" href="<?= base_url() . 'backoffice/kelolabarang/cart/' . $id_registrasi ?>">
                    <i class="fa fa-shopping-cart"></i> Barang <?php if (isset($count)) {
                        echo '(' . $count . ')';
                    } ?></a>
            </div>
        </div>
    </div>
    <div class="container mt-5" id="item-barang">
        <?php
        $this->load->view('item_barang_rows');
        ?>
    </div>
</div>

