
<script type="text/javascript" >
    $("document").ready(function () {
        $("#tglawal").datepicker({
            dateFormat: "yy-mm-dd",
            changeYear: true
        });

        $("#tglakhir").datepicker({
            dateFormat: "yy-mm-dd",
            changeYear: true
        });

        $("#tglawal2").datepicker({
            dateFormat: "yy-mm-dd",
            changeYear: true
        });

        $("#tglakhir2").datepicker({
            dateFormat: "yy-mm-dd",
            changeYear: true
        });

        $("#filter").change(function () {
            var x = document.getElementById("filter").selectedIndex;
            var y = document.getElementById("filter").options;
            //alert(y[x].value);
            if (y[x].value === 'semua') {
                $("#keyword").val("all");
            } else if (y[x].value === 'jns_usulan') {
                //$("#keyword").attr("class",'complete');
            }

        });

        $("#chevrondown").click(function () {
            $("#prosesverifikasi").animate({
                height: 'togle'
            });
        });

        $("#proses").click(function () {
            var x = confirm("Proses data terverifikasi ?");
            if (x) {
                var tgl1 = $("#tglawal2").val();
                var tgl2 = $("#tglakhir2").val();
                $.post("<?php echo base_url() . 'evapro/registrasiprodi/procesverification' ?>",
                        {
                            tglawal: tgl1,
                            tglakhir: tgl2
                        },
                        function (data, status) {
                            alert(data + "\nStatus: " + status);
                            document.location.reload();
                        });
            }
        });

        $("#keyword").autocomplete({
            minLength: 3,
            source: function (req, add) {
                var text = $("select[name='filter'] option:selected").text();

                if (text === 'Jenis Usulan') {
                    $.ajax({
                        url: '<?php echo base_url() . 'evapro/registrasiprodi/autocompletejenisusulan/'; ?>',
                        dataType: 'json',
                        type: 'POST',
                        data: req,
                        success: function (data) {
                            if (data.response == 'true') {
                                add(data.message);
                            }
                        }
                    });
                }
            },
            select: function (event, ui) {
                var nama = ui.item.nama_usulan;
                $("#keyword").val(nama);
                //alert(kdeval);

            }
        });

    });


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



    <h2 class="page-header">
        Daftar Hasil Evaluasi
    </h2>

    <div class="card mt-auto mb-2">
        <div class="card-header"><i class="fa fa-search "></i> Pencarian</div>
        <div class="card-body ">
            <div class="row-fluid">
                <form class="form-horizontal" role="form" method="post" action="<?= base_url() ?>backoffice/kelolaevaluasi/find/">    
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
                            <div class="col-lg-3">
                                <label for="filter" class="">Kriteria Pencarian</label>
                                <?php
                                $filter = array(
                                    '' => '-Pilih-', 
                                    'nmpti' => 'Nama PT', 
                                    'nama_penyelenggara' => 'Yayasan',
                                    'id_registrasi' => 'No Registrasi', 
                                    'nama_status' => 'Status', 
                                    'periode' => 'Periode',
                                    'all' => 'Semua');
                                ?>
                                <?php echo form_dropdown('filter', $filter, '', 'class="form-control form-control-sm" id="filter"'); ?>
                                <!--<select id="filter" class="form-control input-sm">
                                    <option>One</option>
                                    <option>Two</option>
                                </select>-->
                            </div>
                            <!--</div>-->

                            <!--<div class="form-group">-->
                            <div class="col-lg-4">
                                <label for="keyword" class="">Kata Kunci</label>
                                <div class="input-group">                                          
                                    <input type="text" id="keyword" name="keyword" class="form-control form-control-sm">
                                    <span class="input-group-btn">
                                        <button type="submit" name="find" class="btn btn-primary btn-sm" value="find"><i class="fa fa-search "></i> Find</button>
                                        <button type="submit" name="export" id="export" class="btn btn-success btn-sm" value="export"><i class="fa fa-share "></i> Export</button>
                                    </span>
                                </div>
                            </div><!-- /input-group -->
                            <!--</div><!-- /.col-lg-6 -->
                        </div>
                        <h4>Total Record: <span class="label label-info"><?= $total_row ?></span></h4>

                    </fieldset>
                </form>
            </div>
            <div class="row-fluid">
                <div class="table-responsive">
                    <table class="table table-condensed table-striped table-bordered">
                        <thead class="">
                            <tr class="" >
                                <th>#</th>
                                <th class="text-center">Yayasan</th> 
                                <th class="text-center">Perguruan Tinggi</th>                 

                                <th class="text-center">Tgl Rekap</th>

                                <th class="text-center">Status</th>
                                <th class="text-center">Nilai Total</th>
                                <th class="text-center">Periode</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>          

                            <?php
                            if (isset($rekapitulasi) && $rekapitulasi != null) {
                                $segment = $this->uri->segment(4, 0);
                                $user = $this->session->userdata('userid');
                                $i = $segment + 1;
                                if ($i == '') {
                                    $i = 1;
                                }
                                foreach ($rekapitulasi->result() as $obj) {
                                    $eva = new Rekapitulasi($obj->id_rekapitulasi);
                                    //$pro = $eva->getProses();
                                    $reg = $eva->getRegistrasi();
                                    $pt = $reg->getPti();
                                    //print_r($reg);
                                    //$account = $reg->getAccount();
                                    $yayasan = $reg->getPenyelenggara();
                                    //$evaluasi = $pro->getEvaluasi();
                                    $nmyayasan = '-';
                                    if (is_object($yayasan)) {
                                        $nmyayasan = $yayasan->getNamaPenyelenggara();
                                    }

                                    $status = $eva->getStatusRegistrasi();
                                    $stat_eval = '';
                                    $skor = '';
                                    if (is_object($eva)) {
                                        $stat = $eva->getStatusRegistrasi();
                                        $stat_eval = $stat->getNamaStatus();
                                        $skor = $eva->getNilaiTotal();
                                    }
                                    //$evaluator = new Evaluator($pro->getIdEvaluator());
                                    ?>
                                    <tr class="tbl-row <?php
                                    if ($skor > '300') {
                                        echo 'success';
                                    } else {
                                        echo 'warning';
                                    }
                                    ?>">

                                        <td><?= $i ?></td>

                                        <td><?= $nmyayasan; ?></td>
                                        <td><?= $pt->getNmPti(); ?></td>

                                        <td><?= $eva->getTglRekap() ?></td>

                                        <td><?= $status->getNamaStatus() ?></td>
                                        <td><?= $skor ?></td>
                                        <td><?= $reg->getPeriode() ?></td>
                                        <td>
                                            <?php
                                            if ($this->sessionutility->isAdministrator()) {
                                                ?>
                                                <a href="<?= base_url() . 'backoffice/kelolaevaluasi/view/' . $reg->getIdRegistrasi() ?>" title="View">
                                                    <i class="fa fa-file"></i> </a>
                                                <a href="<?= base_url() . 'backoffice/kelolaevaluasi/databarang/' . $reg->getIdRegistrasi() ?>" title="Data Barang">
                                                    <i class="fa fa-gift"></i> </a>
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
                <h4>Total Record: <span class="label label-info"><?= $total_row ?></span></h4>
                <div>
                    <?php
                    echo $this->pagination->create_links();
//echo $articles->count();
                    ?>
                </div>

            </div>

        </div>
    </div>


