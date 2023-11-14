<div class="modal modal-info fade" id="form_hibah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?=  base_url(). 'backoffice/kelolapaket/savedetail/' ?>" id="form_detail">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="exampleModalLabel">Add Detail Hibah</h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal" >
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="instansi">Perguruan Tinggi:</label>
                        <div class="col-lg-8">
                            <input type="hidden" id="flag_detail" name="flag_detail" value="0">
                            <input type="hidden" id="id_detail_paket" name="id_detail_paket" value="0">
                            <input type="hidden" id="id_registrasi" name="id_registrasi" value="0">
                            <input type="text" id="perguruan_tinggi" name="perguruan_tinggi" class="form-control input-sm" value="">                      
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="instansi">Nama Barang:</label>
                        <div class="col-lg-8">
                            <input type="hidden" id="id_item" name="id_item" value="0">
                            <!--<input type="text" id="nama_barang" name="nama_barang" class="form-control input-sm" value="">-->
                            <?php
                                $opt_barang = array('-' => '-Pilih-');
                                $sel_barang = '-';
                                //if(isset($paket)){$sel_adendum = $paket->getAdendum();}
                                echo form_dropdown('nama_barang', $opt_barang, $sel_barang, 'class="form-control" id="nama_barang"');
                                ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="instansi">Merk:</label>
                        <div class="col-lg-8">
                            <input type="text" id="merk" name="merk" class="form-control input-sm" value="">                      
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="instansi">Type:</label>
                        <div class="col-lg-8">
                            <input type="text" id="type" name="type" class="form-control input-sm" value="">                      
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="instansi">Volume:</label>
                        <div class="col-lg-8">
                            <input type="text" id="volume" name="volume" class="form-control input-sm" value="">                      
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="instansi">Berat:</label>
                        <div class="col-lg-8">
                            <input type="text" id="berat" name="berat" class="form-control input-sm" value="">                      
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="instansi">Pajak:</label>
                        <div class="col-lg-8">
                            <input type="text" id="pajak" name="pajak" class="form-control input-sm" value="">                      
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="instansi">Biaya Kirim:</label>
                        <div class="col-lg-8">
                            <input type="text" id="biaya_kirim" name="biaya_kirim" class="form-control input-sm" value="">                      
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="instansi">Onkir:</label>
                        <div class="col-lg-8">
                            <input type="text" id="onkir" name="onkir" class="form-control input-sm" value="">                      
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label" for="instansi">HPS:</label>
                        <div class="col-lg-8">
                            <input type="text" id="hps" name="hps" class="form-control input-sm" value="">                      
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="form-group">
                    <div class="">                      
                          <a href="#" name="save" id="save_detail" value="save" class="btn btn-success"><i class="glyphicon glyphicon-floppy-disk"></i> Save</a>
                    </div>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>