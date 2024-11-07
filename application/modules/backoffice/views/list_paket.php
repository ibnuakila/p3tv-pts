
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
    ;

    function deletechecked()
    {
        var answer = confirm("Hapus data terpilih ?")
        if (answer) {
            document.messages.submit();
        }

        return false;
    }
    ;
</script>

<div class="col-sm-12">
    <div class="card">
        <div class="card-header"><h4>Pencarian</h4></div>
        <div class="card-body">
            <form class="form-horizontal" role="form" method="post" action="<?= base_url() ?>backoffice/kelolapaket/find/">    
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
            
                        <div class="form-group"> 
                        <!--<div class="form-group">-->
                        <div class="">
                            <label for="filter" class="">Kriteria Pencarian</label>
                            <?php
                            $filter = array('' => '-Pilih-',
                                'nama_supplier' => 'Nama Supplier',
                                'nmpti' => 'Nama PT',
                                'id_registrasi' => 'No Registrasi',
                                //'nama_status'=>'Status',
                                'no_kontrak' => 'No Kontrak');
                            $a_filter = '';
                            if (isset($selected_filter)) {
                                $a_filter = $selected_filter;
                            }
                            ?>
                            <?php echo form_dropdown('filter', $filter, $a_filter, 'class="form-control form-control-sm" id="filter"'); ?>
                            <!--<select id="filter" class="form-control input-sm">
                                <option>One</option>
                                <option>Two</option>
                            </select>-->
                        </div>
                        <!--</div>-->

                        <!--<div class="form-group">-->
                        <div class="">
                            <label for="keyword" class="">Kata Kunci</label>
                            <div class="input-group">                                          
                                <input type="text" id="keyword" name="keyword" class="form-control form-control-sm">
                                <span class="input-group-btn">
                                    <button type="submit" name="find" class="btn btn-primary btn-sm" value="find"><i class="glyphicon glyphicon-search glyphicon-white"></i> Find</button>
                                    <button type="submit" name="export" id="export" class="btn btn-success btn-sm" value="export"><i class="glyphicon glyphicon-share glyphicon-white"></i> Export</button>
                                </span>
                            </div>
                        </div><!-- /input-group -->
                        <!--</div><!-- /.col-lg-6 -->
                    </div>
                    <h4>Total Record: <span class="label label-info"><?= $total_row ?></span></h4>

                </fieldset>
            </form>
            <div class="form-group">
                <a href="<?= base_url(); ?>backoffice/kelolapaket/add/" target="_new" name="add" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-plus glyphicon-white"></i> Add</a>
            </div>
        </div>
    </div>


    <div class="card">
        <div class="card-header"></div>
        <div class="card-body">
            <div class="row-fluid">
                <div class="table-responsive">
                    <table class="mytable">
                        <thead class="thead-dark">
                            <tr class="" >
                                <th>#</th>
                                <th class="text-center">Nama Paket</th> 
                                <th class="text-center">Supplier</th> 
                                <th class="text-center">No Kontrak</th>                 
                                <th class="text-center">Tgl Kontrak</th>
                                <th class="text-center">Adendum</th>                
                                <th class="text-center">Terkirim</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>          
                            <?php //print_r($registrasi)?>                
                            <?php
                            if (isset($paket) && $paket != null) {
                                $segment = $this->uri->segment(4, 0);
                                $user = $this->session->userdata('userid');
                                $i = $segment + 1;
                                if ($i == '') {
                                    $i = 1;
                                }
                                foreach ($paket->result() as $obj) {
                                    $pack = new Paket($obj->id);
                                    //$account = $reg->getAccount();
                                    //$yayasan = $account->getYayasan();
                                    $supplier = new Supplier($obj->id_supplier); //$pack->getSupplier();
                                    ?>
                                    <tr class="tbl-row">

                                        <td><?= $i ?></td>
                                        <td><?= $obj->nama_paket; ?></td>
                                        <td><?= $supplier->getNamaSupplier(); ?></td>
                                        <td><?= $obj->no_kontrak; ?></td>
                                        <td><?= $obj->tgl_kontrak; ?></td>
                                        <td><?= $obj->adendum; ?></td>
                                        <td>
                                            <a href="<?= base_url() . 'backoffice/kelolapaket/detail/' . $obj->id ?>" title="Detail Paket">

                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="<?= number_format($pack->getPercentCompleted(), 2); ?>" aria-valuemin="0" aria-valuemax="100" 
                                                         style="width: <?= number_format($pack->getPercentCompleted(), 2); ?>%;">

                                                    </div>
                                                </div>
                                                <?= number_format($pack->getPercentCompleted(), 2) . '%'; ?>
                                            </a>
                                        </td>

                                        <td>
                                            <a href="<?= base_url() . 'backoffice/kelolapaket/remove/' . $obj->id ?>" title="Remove" onclick="return deletechecked()">
                                                <i class="fa fa-trash"></i> </a>
                                            <a href="<?= base_url() . 'backoffice/kelolapaket/edit/' . $obj->id ?>" title="Edit">
                                                <i class="fa fa-edit"></i> </a>
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
</div>
