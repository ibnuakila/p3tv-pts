<html>
    <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="<?= base_url() ?>assets/bootstrap-4.4.1/css/bootstrap.css" rel="stylesheet">
    
    
        
</head>
<body>
    <div class="mt-3 mb-1">
    <?php
    $registrasi = new Registrasi($id_registrasi);
    $pt = $registrasi->getPti();
    $result_proses = $registrasi->getProses2();
    $penyelenggara = $registrasi->getPenyelenggara();
    $res_array = $result_proses->result('array');
    //$pro1 = $res_array[0];
    //$pro2 = $res_array[1];
    
    //$eva1 = new Evaluator($pro1['id_evaluator']);
    //$eva2 = new Evaluator($pro2['id_evaluator']);
    $reviewer_1 = ''; $reviewer_2 = ''; $t_teknis = '';
    foreach ($result_proses->result() as $row) {
            if ($row->type_evaluator == '1') {
                $evaluator = new Evaluator($row->id_evaluator);
                if($reviewer_1 == ''){
                    $reviewer_1 = $evaluator->getNmEvaluator();
                }else{
                    $reviewer_2 = $evaluator->getNmEvaluator();
                }
                
            } elseif ($row->type_evaluator == '2') {
                $evaluator = new Evaluator($row->id_evaluator);
                $t_teknis = $evaluator->getNmEvaluator();
            }
            
        }
    ?>
    <h3 class="display-5 text-center">
        Usulan Barang <?= $pt->getNmPti() ?>
    </h3><hr>
    <div class="table-responsive">
        <table class="table table-striped table-condensed table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Spesifikasi</th>
                    <th>Qty</th>
                    <th>Sub Total</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                if($item_hibah->num_rows()>0){
                    $i=1; $grand_total=0;
                    foreach ($item_hibah->result() as $row){
                        $params['id_item'] = $row->id_item;
                        $params['periode'] = $periode;
                        $item_barang = new ItemBarang($params);
                        //$ppn = ($row->subtotal*10)/100;
                        $subtotal_ppn = $row->subtotal ;//+ $ppn;
                        $grand_total = $grand_total + $subtotal_ppn;
                ?>
                <tr>
                    <td><?=$i ?></td>
                    <td><?=$item_barang->getBarang() ?></td>
                    <td><?=$item_barang->getSpesifikasi() ?></td>
                    <td><?=$row->jml_item ?></td>
                    <td><?= number_format($subtotal_ppn,2) ?></td>
                    
                </tr>
                <?php $i++;
                    }?>
                <tr>
                    <td colspan="3"><b>Grand Total (Tax Inclusive):</b></td>
                    <td colspan="2"><b><?='Rp. '.number_format($grand_total,2) ?></b></td>
                    
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        <p>
            
        </p>
        <table class="table">
            <tr>
                <td><b>Reviewer</b> </br></br>
                    <?=$reviewer_1?>
                </td>
                <td><b>Reviewer</b> </br></br>
                    <?=$reviewer_2?>
                </td>
                <td><b>Tim Teknis</b> </br></br>
                    <?=$t_teknis?>
                </td>
                <td><b>Ketua <?=$penyelenggara->getNamaPenyelenggara() ?></b> </br></br>-------------------</td>
            
            </tr>
        </table>
        
    </div>
</div>
</body>
</html>

