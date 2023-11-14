
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


<div class="card mb-2 mt-auto">
    <h2 class="">
        Hasil Evaluasi
    </h2>

    <div class="card-header"><i class="fa fa-search fa-white"></i> Pencarian</div>
    <div class="card-body ">
        <form class="form-horizontal" role="form" method="post" action="<?= base_url() ?>evapro/registrasiprodi/findpraregistrasi/">    
            <fieldset>

                <div class="form-group">
                    <div class="col-sm-2">
                        <label for="tglakhir" class="">Tgl Awal</label>
                        <input type="text" id="tglawal" name="tglawal" class="form-control input-sm" placeholder="yyyy-mm-dd">                
                    </div>

                    <div class="col-sm-2">
                        <label for="tglakhir" class="">Tgl Akhir</label>
                        <input type="text" id="tglakhir" name="tglakhir" class="form-control input-sm" placeholder="yyyy-mm-dd">

                    </div>
                    <!--</div>
        
                    <div class="form-group"> 
                    <!--<div class="form-group">-->
                    <div class="col-lg-3">
                        <label for="filter" class="">Kriteria Pencarian</label>
                        <?php
                        $filter = array('' => '-Pilih-', 'nama_pt' => 'Nama PT', 'yayasan' => 'Yayasan',
                            'no_regis' => 'No Registrasi', 'status' => 'Status', 'evaluator' => 'Evaluator');
                        ?>
                        <?php echo form_dropdown('filter', $filter, '', 'class="form-control input-sm" id="filter"'); ?>
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
                            <input type="text" id="keyword" name="keyword" class="form-control input-sm">
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
    </div>
</div>



<div class="row-fluid">
    <div class="table-responsive">
        <table class="table table-condensed table-striped table-bordered">
            <thead class="tbl-head">
                <tr class="active" >
                    <th>#</th>
                    <th class="text-center">No Registrasi</th> 
                    <th class="text-center">Perguruan Tinggi</th>                 
                    <th class="text-center">Evaluator</th>
                    <th class="text-center">Tgl Penugasan</th>
                    <th class="text-center">Tgl Expire</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Skor</th>

                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>          

                <?php
                //if(isset($evaluasi) && $evaluasi != null){ 
                //print_r($evaluasi->num_rows());
                $segment = $this->uri->segment(4, 0);
                //$user = $this->session->userdata('userid');
                $i = $segment + 1;
                if ($i == '') {
                    $i = 1;
                }
                foreach ($evaluasi->result() as $obj) {
                    $eva = new Evaluasi($obj->id_evaluasi);
                    $pro = $eva->getProses();
                    $reg = $pro->getRegistrasi();
                    ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $pro->getIdProses() ?></td>
                        <td><?= $eva->getIdEvaluasi() ?></td>
                        <td><?= $eva->getIdEvaluasi() ?></td>
                        <td><?= $eva->getIdEvaluasi() ?></td>
                        <td><?= $eva->getIdEvaluasi() ?></td>
                        <td><?= $eva->getIdEvaluasi() ?></td>
                        <td><?= $eva->getIdEvaluasi() ?></td>
                        <td><?= $eva->getIdEvaluasi() ?></td>
                    </tr>
                    <?php
                    //$pro = $eva->getProses();
                    //$reg = $pro->getRegistrasi();
                    //$pt = $reg->getPti();
                    //print_r($reg);
                    //$account = $reg->getAccount();
                    //$yayasan = $reg->getPenyelenggara();
                    //$_evaluasi = $pro->getEvaluasi();
                    //$nmyayasan = '-';
                    //if(is_object($yayasan)){
                    //$nmyayasan = $yayasan->getNamaPenyelenggara();
                    //} 
                    //$status = $pro->getStatusProses();
                    $stat_eval = '';
                    $skor = '';
                    if (is_object($eva)) {
                        //$stat = $eva->getStatusRegistrasi();
                        //$stat_eval = $stat->getNamaStatus();
                        //$skor = $eva->getSkor();
                    }
                    //$evaluator = new Evaluator($pro->getIdEvaluator());
                    $i++;
                }
//}
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