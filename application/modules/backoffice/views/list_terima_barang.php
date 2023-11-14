
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
<div class="col-sm-12">

    <div class="">
        <h4>
            Daftar Penerimaan Barang
        </h4>
    </div>
    <div class="card">
        <div class="card-header"><h4>Pencarian</h4> </div>
        <div class="card-body">
            <form class="form-horizontal" role="form" method="post" action="<?= base_url() ?>backoffice/kelolapaket/findterima/">    
                <fieldset>

                    <div class="form-group">
                        <!-- <div class="col-sm-2">
                            <label for="tglakhir" class="">Tgl Awal</label>
                            <input type="text" id="tglawal" name="tglawal" class="form-control input-sm" placeholder="yyyy-mm-dd">                
                        </div>
        
                        <div class="col-sm-2">
                            <label for="tglakhir" class="">Tgl Akhir</label>
                            <input type="text" id="tglakhir" name="tglakhir" class="form-control input-sm" placeholder="yyyy-mm-dd">
        
                        </div>-->
                        <!--</div>
            
                        <div class="form-group"> -->
                        <div class="form-group">
                        
                            <label for="filter" class="">Kriteria Pencarian</label>
                            <?php
                            $filter = array('' => '-Pilih-', 'nmpti' => 'Nama PT', 'nama_penyelenggara' => 'Yayasan',
                                'id_registrasi' => 'No Registrasi', 'nama_status' => 'Status', 'all' => 'Semua');
                            $a_filter = '';
                            if (isset($selected_filter)) {
                                $a_filter = $selected_filter;
                            }
                            ?>
                            <?php echo form_dropdown('filter', $filter, $a_filter, 'class="form-control input-sm" id="filter"'); ?>
                            <!--<select id="filter" class="form-control input-sm">
                                <option>One</option>
                                <option>Two</option>
                            </select>-->
                        
                        </div>

                        <div class="form-group">
                        
                            <label for="keyword" class="">Kata Kunci</label>
                            <div class="input-group">                                          
                                <input type="text" id="keyword" name="keyword" class="form-control input-sm">
                                <span class="input-group-btn">
                                    <button type="submit" name="find" class="btn btn-primary" value="find"><i class="glyphicon glyphicon-search glyphicon-white"></i> Find</button>
                                    <button type="submit" name="export" id="export" class="btn btn-success" value="export"><i class="glyphicon glyphicon-share glyphicon-white"></i> Export</button>
                                </span>
                            </div>
                        
                        </div><!-- /.col-lg-6 -->
                    </div>
                    <h4>Total Record: <span class="label label-info"><?= $total_row ?></span></h4>

                </fieldset>
            </form>    
        </div>
    </div>



    <div class="card">
        <div class="card-body">
        <div class="table-responsive">
            <table class="table table-condensed table-striped table-bordered">
                <thead class="tbl-head">
                    <tr class="bg-success" >
                        <th>#</th>
                        <th class="text-center">Id Registrasi</th> 
                        <th class="text-center">Yayasan</th> 
                        <th class="text-center">Perguruan Tinggi</th>                 
                        <th class="text-center">Tgl Registrasi</th>
                        <th class="text-center">No Kontrak</th>                
                        <th class="text-center">Terkirim</th> 
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>          
                    <?php //print_r($registrasi)?>                
                    <?php
                    if (isset($registrasi) && $registrasi != null) {
                        $segment = $this->uri->segment(4, 0);
                        $user = $this->session->userdata('userid');
                        $i = $segment + 1;
                        if ($i == '') {
                            $i = 1;
                        }
                        foreach ($registrasi->result() as $obj) {
                            $reg = new Registrasi($obj->id_registrasi);
                            //$account = $reg->getAccount();
                            //$yayasan = $account->getYayasan();
                            $pt = $reg->getPti();
                            $yayasan = $reg->getPenyelenggara();
                            $status = $reg->getStatusRegistrasi();
                            $nmyayasan = '-';
                            if (is_object($yayasan)) {
                                $nmyayasan = $yayasan->getNamaPenyelenggara();
                            }
                            $detail_paket_hibah = new DetailPaketHibah();
                            $detail_paket_hibah->setKdPti($reg->getKdPti());
                            $detail_paket_hibah->getBy('id_registrasi', $reg->getIdRegistrasi());
                            $kirim = new Kirim();
                            $kirim->getBy('id_registrasi', $reg->getIdRegistrasi());
                            //var_dump($kirim);
                            //$detail_kirim = new DetailKirim();
                            //$detail_kirim->getBy('id_detail_paket', $detail_paket_hibah->getId());
                            //var_dump($detail_kirim);
                            ?>
                            <tr class="tbl-row">

                                <td><?= $i ?></td>
                                <td><?= $obj->id_registrasi ?></td>
                                <td><?= $nmyayasan ?></td>
                                <td><?= $pt->getNmPti(); ?></td>
                                <td><?= $reg->getTglRegistrasi(); ?></td>
                                <td><?= $detail_paket_hibah->getNoKontrak() ?></td>
                                <td>                                    
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="<?= number_format($detail_paket_hibah->getPercentCompleted(), 2); ?>" aria-valuemin="0" aria-valuemax="100" 
                                                 style="width: <?= number_format($detail_paket_hibah->getPercentCompleted(), 2); ?>%;">

                                            </div>
                                        </div>
                                        <?= number_format($detail_paket_hibah->getPercentCompleted(), 2) . '%'; ?>                                    
                                </td>

                                <td>
                                    <!--<a href="<?= base_url() . 'backoffice/kelolapaket/getForm/' . $reg->getKdPti() ?>" title="Berita Acara">
                                        <i class="fa fa-list"></i> </a>
                                    <a href="<?= base_url() . 'backoffice/kelolapaket/getBuktiTerima/' . $reg->getKdPti() ?>" title="Bukti Terima">
                                        <i class="fa fa-download"></i> </a>-->
                                    <a href="<?= base_url() . 'backoffice/kelolapaket/listterima/' . $reg->getIdRegistrasi() ?>" title="Detail">
                                        <i class="fa fa-eye"></i> </a>
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
            echo $this->pagination->create_links();
            //echo $articles->count();
            ?>
        </div>
        </div>
    </div>
</div>
